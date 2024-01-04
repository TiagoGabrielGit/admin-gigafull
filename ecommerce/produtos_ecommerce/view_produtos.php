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

        $idProduto = isset($_GET['id']) ? $_GET['id'] : null;

        try {
            $sql_produto =
                "SELECT pe.id, pe.descricao, pe.lucro, pe.unidade 
                FROM ecommerce_produtos as pe
                WHERE pe.id = :idProduto";
            $stmt_produto = $pdo->prepare($sql_produto);
            $stmt_produto->bindParam(':idProduto', $idProduto, PDO::PARAM_INT);
            $stmt_produto->execute();

            // Obtendo os dados do produto
            $produto = $stmt_produto->fetch(PDO::FETCH_ASSOC);
            $porcLucro = $produto['lucro'];
        } catch (PDOException $e) {
            echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
        }

        try {
            $sql_custo_principal =
                "SELECT pec.custo
                FROM ecommerce_produtos_custos as pec
                WHERE pec.produto_id = :idProduto AND pec.principal = 1";
            $stmt_custo_principal = $pdo->prepare($sql_custo_principal);
            $stmt_custo_principal->bindParam(':idProduto', $idProduto, PDO::PARAM_INT);
            $stmt_custo_principal->execute();

            $custo_principal = $stmt_custo_principal->fetch(PDO::FETCH_ASSOC);
            $custo_principal = isset($custo_principal['custo']) ? $custo_principal['custo'] : 0;
        } catch (PDOException $e) {
            echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
        }
        $valor_venda = number_format($custo_principal * (1 + ($porcLucro / 100)), 2, ',', '.');

?>

        <main id="main" class="main">
            <div class="pagetitle">
                <h1>Produtos</h1>
            </div>
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row justify-content-between">
                                    <div class="col-md-4 text-left">
                                        <h5 class="card-title"><?= $produto['descricao']; ?></h5>
                                    </div>

                                    <div class="col-md-4 text-right">
                                        <a style="margin-top: 15px;" href="/ecommerce/produtos_ecommerce/index.php" class="btn btn-info btn-sm">Lista de Produtos</a>
                                    </div>
                                </div>

                                <form method="POST" action="processa/editar_produto.php" class="row g-3">

                                    <input type="hidden" readonly name="id" value="<?= $idProduto ?>">

                                    <hr class="sidebar-divider">
                                    <div class="row">
                                        <div class="text-left col-sm-3"> <!-- Divida a largura da tela ao meio para os elementos à esquerda -->
                                            <label for="codigo" class="col-sm-12 col-form-label">Código</label>
                                            <div class="col-sm-3"> <!-- Ajuste para ocupar toda a largura da div pai -->
                                                <input style="text-align: center;" name="codigo" type="text" class="form-control" id="codigo" value="<?= $idProduto ?>" disabled>
                                            </div>
                                        </div>

                                        <div class="text-right col-sm-6"> <!-- Divida a largura da tela ao meio para os elementos à direita -->
                                            <label for="valorVenda" class="col-sm-12 col-form-label">Valor de Venda (R$)</label>
                                            <div class="col-sm-3"> <!-- Ajuste para ocupar toda a largura da div pai -->

                                                <div class="input-group">
                                                    <span class="input-group-text">R$</span>
                                                    <input style="text-align: center;" name="valorVenda" type="text" class="form-control" id="valorVenda" value="<?= $valor_venda ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col mb-6">
                                            <label for="descricaoProduto" class="col-sm-12 col-form-label">Descrição Produto</label>
                                            <div class="col-sm-12">
                                                <input required name="descricaoProduto" type="text" class="form-control" id="descricaoProduto" value="<?= $produto['descricao']; ?>">
                                            </div>
                                        </div>

                                        <div class="col mb-6">
                                            <label for="unidade" class="col-sm-12 col-form-label">Unidade</label>
                                            <div class="col-sm-7">
                                                <select class="form-select" required id="unidade" name="unidade">
                                                    <option value="" disabled>Selecione...</option>
                                                    <option value="1" <?= ($produto['unidade'] == 1) ? 'selected' : '' ?>>Metros</option>
                                                    <option value="2" <?= ($produto['unidade'] == 2) ? 'selected' : '' ?>>Unidade</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col mb-6">
                                            <label for="fornecedorPrincipal" class="col-sm-12 col-form-label">Fornecedor Principal</label>
                                            <div class="col-sm-7">
                                                <select class="form-select" id="fornecedorPrincipal" name="fornecedorPrincipal">
                                                    <option value="">Selecione...</option>
                                                    <?php
                                                    try {
                                                        // Consulta SQL para obter os custos associados ao produto
                                                        $sql_custos = "SELECT pc.id, e.fantasia as fornecedor, pc.principal 
                                                        FROM ecommerce_produtos_custos pc
                                                        JOIN empresas e ON pc.fornecedor_id = e.id
                                                        WHERE pc.produto_id = :idProduto";
                                                        $stmt_custos = $pdo->prepare($sql_custos);
                                                        $stmt_custos->bindParam(':idProduto', $idProduto, PDO::PARAM_INT);
                                                        $stmt_custos->execute();

                                                        // Loop para adicionar opções ao menu suspenso
                                                        while ($produto_custo = $stmt_custos->fetch(PDO::FETCH_ASSOC)) {
                                                            $selected = ($produto_custo['principal'] == 1) ? 'selected' : ''; // Adiciona a opção 'selected' se for o fornecedor principal
                                                    ?>
                                                            <option value="<?= $produto_custo['id']; ?>" <?= $selected; ?>>
                                                                <?= $produto_custo['fornecedor']; ?>
                                                            </option>
                                                    <?php
                                                        }
                                                    } catch (PDOException $e) {
                                                        echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
                                                    }
                                                    ?>
                                                </select>


                                            </div>
                                        </div>

                                        <div class="col mb-6">
                                            <label for="lucro" class="col-sm-12 col-form-label">% Lucro</label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <span class="input-group-text">%</span>
                                                    <input style="text-align: center;" required name="lucro" type="number" class="form-control" id="lucro" value="<?= $produto['lucro'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class=" btn btn-sm btn-danger">Salvar Alterações</button>
                                    </div>
                                </form><!-- End Multi Columns Form -->

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="container mt-3">
                                    <div class="row justify-content-end">
                                        <div class="col-4 text-right">
                                            <button data-bs-toggle="modal" data-bs-target="#modalAddFornecedor" style="margin-top: 15px;" class="btn btn-sm btn-success">Adicionar Fornecedor do Produto</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">ID</th>
                                                    <th style="text-align: center;">Fornecedor</th>
                                                    <th style="text-align: center;">Cód Fornecedor</th>
                                                    <th style="text-align: center;">Custo</th>
                                                    <th style="text-align: center;">Data Atualização</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                try {
                                                    $sql_produtos_custo = "SELECT pc.id, pc.cod_produto as cod_produto, e.fantasia as fornecedor, pc.custo, DATE_FORMAT(pc.atualizado, '%d/%m/%Y %H:%i') as atualizado, pc.principal 
                                                FROM ecommerce_produtos_custos pc
                                                JOIN empresas e ON pc.fornecedor_id = e.id
                                                WHERE pc.produto_id = :idProduto";
                                                    $stmt_produtos_custo = $pdo->prepare($sql_produtos_custo);
                                                    $stmt_produtos_custo->bindParam(':idProduto', $idProduto, PDO::PARAM_INT);
                                                    $stmt_produtos_custo->execute();

                                                    while ($produto_custo = $stmt_produtos_custo->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                        <tr>
                                                            <td style="text-align: center;"><?= $produto_custo['id']; ?></td>
                                                            <td style="text-align: center;"><?= $produto_custo['fornecedor']; ?></td>
                                                            <td style="text-align: center;"><?= $produto_custo['cod_produto']; ?></td>
                                                            <td style="text-align: center;">R$ <?= $produto_custo['custo']; ?></td>
                                                            <td style="text-align: center;"><?= $produto_custo['atualizado']; ?></td>
                                                            <td style="text-align: center;">
                                                                <?php
                                                                if ($produto_custo['principal'] == 1) {
                                                                    echo "Principal";
                                                                } else { ?>
                                                                    <button type="button" class="btn btn-danger btn-sm" onclick="excluirCusto(<?= $idProduto ?>, <?= $produto_custo['id']; ?>)">Excluir</button>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
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
                    </div>
                </div>
            </section>
        </main>

        <script>
            function excluirCusto(idProduto, custoId) {
                if (confirm('Tem certeza que deseja excluir este custo?')) {
                    // Criar um formulário dinamicamente
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'processa/excluir_produto_custo.php';

                    // Adicionar um campo oculto para o ID do produto
                    var produtoIdInput = document.createElement('input');
                    produtoIdInput.type = 'hidden';
                    produtoIdInput.name = 'produto_id';
                    produtoIdInput.value = idProduto;
                    form.appendChild(produtoIdInput);

                    // Adicionar um campo oculto para o ID do custo
                    var custoIdInput = document.createElement('input');
                    custoIdInput.type = 'hidden';
                    custoIdInput.name = 'custo_id';
                    custoIdInput.value = custoId;
                    form.appendChild(custoIdInput);

                    // Adicionar o formulário à página e enviá-lo
                    document.body.appendChild(form);

                    form.submit();
                }
            }
        </script>


        <div class="modal fade" id="modalAddFornecedor" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Fornecedor do Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form method="POST" action="processa/novo_fornecedor_produto.php">
                            <input hidden readonly id="produto_id" name="produto_id" value="<?= $idProduto ?>">

                            <div class="row">
                                <div class="col-5">
                                    <label for="fornecedor" class="form-label">Fornecedor</label>
                                    <select class="form-select" name="fornecedor" required>
                                        <option disabled selected value="">Selecione...</option>
                                        <?php
                                        try {
                                            // Consulta SQL para obter fornecedores da tabela 'empresas' com atributoFornecedor = 1
                                            $sql_fornecedores = "SELECT id, fantasia FROM empresas WHERE atributoFornecedor = 1 ORDER BY fantasia ASC";
                                            $stmt_fornecedores = $pdo->prepare($sql_fornecedores);
                                            $stmt_fornecedores->execute();
                                            while ($fornecedor = $stmt_fornecedores->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                                <option value="<?= $fornecedor['id'] ?>"><?= $fornecedor['fantasia'] ?></option>
                                        <?php
                                            }
                                        } catch (PDOException $e) {
                                            echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="codigo_fornecedor" class="form-label">Código Fornecedor</label>
                                    <input name="codigo_fornecedor" type="text" class="form-control" id="codigo_fornecedor">
                                </div>

                                <div class="col-3">
                                    <label for="custo" class="form-label">Custo (R$)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input name="custo" type="number" class="form-control" id="custo" step="0.01" min="0" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="text-center">
                                <button type="submit" class="btn btn-danger">Adicionar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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