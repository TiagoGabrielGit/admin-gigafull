<?php
require "../../includes/menu.php";
require "../../includes/remove_setas_number.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "45";
$uid = $_SESSION['id'];

$permissions_menu =
    "SELECT 
    u.perfil_id
FROM 
    usuarios u
JOIN 
perfil_permissoes_submenu pp
ON 
    u.perfil_id = pp.perfil_id
WHERE
    u.id = :uid
AND 
    pp.url_submenu = :submenu_id";

try {
    $exec_permissions_menu = $pdo->prepare($permissions_menu);
    $exec_permissions_menu->bindParam(':uid', $uid, PDO::PARAM_INT);
    $exec_permissions_menu->bindParam(':submenu_id', $submenu_id, PDO::PARAM_INT);
    $exec_permissions_menu->execute();

    $rowCount_permissions_menu = $exec_permissions_menu->rowCount();

    if ($rowCount_permissions_menu > 0) {
?>

        <style>
            #tabelaLista:hover {
                cursor: pointer;
                background-color: #E0FFFF;
            }
        </style>

        <main id="main" class="main">
            <div class="pagetitle">
                <h1>Produtos</h1>
            </div>
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h5 class="card-title">Cadastro de Produtos</h5>
                                        </div>

                                        <div class="col-lg-4">
                                            <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                                Novo Produto
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="card-title">Listagem Produtos</h5>
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;" scope="col">Código</th>
                                            <th scope="col">Descrição</th>
                                            <th style="text-align: center;" scope="col">Unidade</th>
                                            <th style="text-align: center;" scope="col">Valor de Venda</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        try {
                                            // Defina o modo de erro do PDO para exceções
                                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            // Consulta SQL para obter dados da tabela produtos_ecommerce
                                            $sql_produtos =
                                                "SELECT ep.id, ep.descricao,
                                            CASE
                                            WHEN ep.unidade = 1 THEN 'Metros'
                                            WHEN ep.unidade = 2 THEN 'Unidade'
                                            END as unidade,
                                            ep.lucro
                                            FROM ecommerce_produtos as ep";
                                            // Prepara a consulta
                                            $stmt = $pdo->prepare($sql_produtos);
                                            // Executa a consulta
                                            $stmt->execute();
                                            // Obtendo os dados por meio de um loop while
                                            while ($c_produtos = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                $id = $c_produtos['id'];
                                                $lucro = $c_produtos['lucro'];
                                                $sql_custo =
                                                    "SELECT epc.custo
                                                    FROM ecommerce_produtos_custos as epc
                                                    WHERE epc.principal = 1 AND epc.produto_id = $id";

                                                // Executar a consulta para obter o custo
                                                $stmt_custo = $pdo->query($sql_custo);
                                                $resultado_custo = $stmt_custo->fetch(PDO::FETCH_ASSOC);

                                                if ($resultado_custo) {
                                                    // Custos encontrados, calcular o valor de venda
                                                    $custo_principal = $resultado_custo['custo'];
                                                    $valor_venda = number_format($custo_principal * (1 + ($lucro / 100)), 2, ',', '.');

                                                    // Faça o que precisar com o $valor_venda
                                                } else {
                                                    // Caso não haja custo principal encontrado
                                                    echo "Custo principal não encontrado para o produto ID: $id";
                                                } ?>

                                                <tr id="tabelaLista" onclick="location.href='view_produtos.php?id=<?= $c_produtos['id'] ?>'">
                                                    <td style="text-align: center;"><?= $c_produtos['id']; ?></td>
                                                    <td><?= $c_produtos['descricao']; ?></td>
                                                    <td style="text-align: center;"><?= $c_produtos['unidade']; ?></td>
                                                    <td style="text-align: center;">R$ <?= $valor_venda ?></td>

                                                </tr>
                                        <?php }
                                        } catch (PDOException $e) {
                                            echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <div class="modal fade" id="basicModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Novo Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="processa/novo_produto.php">
                            <div class="row">
                                <div class="col-8">
                                    <label for="descricaoProduto" class="form-label">Descrição</label>
                                    <input name="descricaoProduto" type="text" class="form-control" id="descricaoProduto" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <label for="unidade" class="form-label">Unidade</label>
                                    <select class="form-select" required id="unidade" name="unidade">
                                        <option selected value="" disabled>Selecione...</option>
                                        <option value="1">Metros</option>
                                        <option value="2">Unidade</option>
                                    </select>
                                </div>

                                <div class="col-6">
                                    <label for="lucro" class="form-label">% Lucro</label>
                                    <input name="lucro" type="number" class="form-control" id="lucro" required>

                                </div>
                            </div>
                            <br>


                            <div class="text-center">
                                <button type="submit" class="btn btn-danger">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- End Basic Modal-->

<?php
    } else {
        require "../../acesso_negado.php";
    }
} catch (PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
} finally {
    require "../../includes/securityfooter.php";
}
?>