<?php
require "../../includes/menu.php";
require "../../includes/remove_setas_number.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "47";
$uid = $_SESSION['id'];

$permissions_menu =
    "SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = :uid AND pp.url_submenu = :submenu_id";

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
                <h1>Pedidos</h1>
            </div>
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <h5 class="card-title">Listagem de Pedidos</h5>
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;" scope="col">Nº Pedido</th>
                                            <th scope="col">Cliente</th>
                                            <th style="text-align: center;" scope="col">Data Pedido</th>
                                            <th style="text-align: center;" scope="col">Valor (R$)</th>
                                            <th style="text-align: center;" scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        try {
                                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            $sql_pedidos =
                                                "SELECT ep.id, e.fantasia, DATE_FORMAT(ep.date, '%d/%m/%Y') as date,
                                                CASE
                                                WHEN ep.status = 0 THEN 'Iniciado'
                                                WHEN ep.status = 1 THEN 'Em Orçamento'
                                                WHEN ep.status = 2 THEN 'Aguardando Cliente'
                                                WHEN ep.status = 3 THEN 'Aprovado'
                                                WHEN ep.status = 4 THEN 'Recusado'
                                                WHEN ep.status = 5 THEN 'Executado'
                                                END as status
                                                FROM ecommerce_pedido as ep
                                                LEFT JOIN empresas as e ON e.id = ep.cliente_id
                                                ORDER BY ep.date ASC";
                                            $stmt = $pdo->prepare($sql_pedidos);
                                            $stmt->execute();
                                            while ($c_pedidos = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                $pedido_id = $c_pedidos['id'];

                                                // Consulta para obter o valor subtotal
                                                $stmt_subtotal = $pdo->prepare("SELECT SUM(epp.subtotal) as subtotal FROM ecommerce_pedido_produto as epp WHERE epp.pedido_id = ?");
                                                $stmt_subtotal->execute([$pedido_id]);
                                                $result_subtotal = $stmt_subtotal->fetch(PDO::FETCH_ASSOC);
                                                $valor_subtotal = $result_subtotal['subtotal'];
                                        ?>

                                                <tr id="tabelaLista" onclick="location.href='/ecommerce/venda/pedido.php?pedido_id=<?= $c_pedidos['id'] ?>'">
                                                    <td style="text-align: center;"><?= $c_pedidos['id']; ?></td>
                                                    <td><?= $c_pedidos['fantasia']; ?></td>
                                                    <td style="text-align: center;"><?= $c_pedidos['date']; ?></td>
                                                    <td style="text-align: center;">R$ <?= number_format($valor_subtotal, 2, ',', '.'); ?></td>
                                                    <td style="text-align: center;"><?= $c_pedidos['status']; ?></td>

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