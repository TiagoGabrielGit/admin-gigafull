<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";
require "../../includes/remove_setas_number.php";
$pedido_id = $_GET['pedido_id'];

// Obter a lista de clientes disponíveis no banco de dados
$sql_cliente = "SELECT ep.status, ep.information, ep.archived, ep.date_entrega, ep.date, e.id, e.fantasia, e.cnpj, ca.street, ca.number, ca.city, ca.state, ca.neighborhood, ca.complement, ca.cep 
FROM ecommerce_pedido as ep
LEFT JOIN empresas as e ON e.id = ep.cliente_id
LEFT JOIN company_address AS ca ON ca.company_id = e.id
WHERE ep.id = $pedido_id ORDER BY e.fantasia ASC";
$stmt_cliente = $pdo->query($sql_cliente);
$cliente = $stmt_cliente->fetch(PDO::FETCH_ASSOC); // Usar fetch em vez de fetchAll

// Obter a lista de produtos disponíveis no banco de dados
$sql_produtos = "SELECT pe.id, pe.descricao, pe.lucro, pec.custo, (pec.custo * (1 + pe.lucro / 100)) AS valor_unitario
                FROM ecommerce_produtos as pe 
                LEFT JOIN ecommerce_produtos_custos as pec
                ON pec.produto_id = pe.id
                WHERE pe.active = 1 AND pec.principal = 1 ORDER BY pe.descricao ASC";
$stmt_produtos = $pdo->query($sql_produtos);
$produtos = $stmt_produtos->fetchAll(PDO::FETCH_ASSOC);

$sql_produtos_pedido = "SELECT pe.descricao, ep.id, ep.quantidade, ep.subtotal, ep.valor_unitario,
                        CASE
                        WHEN pe.unidade = 1 THEN 'Metros'
                        WHEN pe.unidade = 2 THEN 'Unidade'
                        END as unidade
                       FROM ecommerce_pedido_produto ep
                       JOIN ecommerce_produtos pe ON ep.produto_id = pe.id
                       WHERE ep.pedido_id = :pedido_id";
$stmt_produtos_pedido = $pdo->prepare($sql_produtos_pedido);
$stmt_produtos_pedido->bindParam(":pedido_id", $pedido_id);
$stmt_produtos_pedido->execute();
$produtos_pedido = $stmt_produtos_pedido->fetchAll(PDO::FETCH_ASSOC);

?>

<main id="main" class="main">


    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <br>
                        <div class="pagetitle d-flex justify-content-between align-items-center">
                            <h1 class="mb-0">Dados do Pedido</h1>
                            <button class="btn btn-primary" onclick="window.open('/tcpdf/export/pedido.php?id=<?= $pedido_id ?>', '_blank')">Gerar PDF do Pedido</button>

                        </div>

                        <div class="col-1">
                            <label class="form-label">Nº Pedido:</label>
                            <input style="text-align: center;" value="<?= $pedido_id ?>" class="form-control" disabled>
                        </div>
                        <br>
                        <form action="processa/atualiza_dados_pedido.php" method="POST">
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label" for="cliente"><strong>Cliente:</strong> <?= $cliente['fantasia'] ?></label>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label" for="cnpj"><strong>CNPJ:</strong> <?= $cliente['cnpj'] ?></label>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-5">
                                            <label class="form-label" for="endereco"><strong>Endereço:</strong> <?= $cliente['street'] ?></label>
                                        </div>
                                        <div class="col-3">
                                            <label class="form-label" for="numero"><strong>Número:</strong> <?= $cliente['number'] ?></label>
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label" for="cep"><strong>CEP:</strong> <?= $cliente['cep'] ?></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <label class="form-label" for="bairro"><strong>Bairro:</strong> <?= $cliente['neighborhood'] ?></label>
                                        </div>

                                        <div class="col-4">
                                            <label class="form-label" for="complemento"><strong>Complemento:</strong> <?= $cliente['complement'] ?></label>

                                        </div>

                                        <div class="col-4">
                                            <label class="form-label" for="city"><strong>Cidade:</strong> <?= $cliente['city'] ?></label>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <label class="form-label" for="information"><b>Informações</b></label>
                                        <textarea id="information" name="information" class="form-control" style="height: 100px; resize: none;" rows="4"><?= $cliente['information'] ?></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <input hidden readonly id="atualiza_pedido_id" name="atualiza_pedido_id" value="<?= $pedido_id ?>">

                                    <div class="row mb-3">
                                        <label for="data_pedido" class="col-sm-4 col-form-label"><strong> Data Pedido </strong></label>
                                        <div class="col-sm-8">
                                            <input value="<?= $cliente['date'] ?>" id="data_pedido" name="data_pedido" type="date" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="status_pedido" class="col-sm-4 col-form-label"><strong> Status</strong></label>
                                        <div class="col-sm-8">
                                            <select required id="status_pedido" name="status_pedido" class="form-select" aria-label="Default select example">
                                                <option disabled value="" <?php echo ($cliente['status'] == 0) ? 'selected' : ''; ?>>Selecione</option>
                                                <option value="1" <?php echo ($cliente['status'] == 1) ? 'selected' : ''; ?>>Em orçamento</option>
                                                <option value="2" <?php echo ($cliente['status'] == 2) ? 'selected' : ''; ?>>Aguardando Cliente</option>
                                                <option value="3" <?php echo ($cliente['status'] == 3) ? 'selected' : ''; ?>>Aprovado</option>
                                                <option value="4" <?php echo ($cliente['status'] == 4) ? 'selected' : ''; ?>>Recusado</option>
                                                <option value="5" <?php echo ($cliente['status'] == 5) ? 'selected' : ''; ?>>Executado</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="data_entrega" class="col-sm-4 col-form-label"><strong>Data Entrega</strong></label>
                                        <div class="col-sm-8">
                                            <input value="<?= $cliente['date_entrega'] ?>" id="data_entrega" name="data_entrega" type="date" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="archived" class="col-sm-4 col-form-label"><strong>Arquivado</strong></label>
                                        <div class="col-sm-8">
                                            <input class="form-check-input" type="checkbox" id="archived" name="archived" <?php echo ($cliente['archived'] == 1) ? 'checked=""' : ''; ?>>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-sm btn-info">Salvar Modificações</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <br>
                        <div class="pagetitle">
                            <h1>Produtos</h1>
                        </div><!-- End Page Title -->

                        <form action="processa/adiciona_produto.php" method="POST">
                            <input hidden readonly id="pedido_id" name="pedido_id" value="<?= $pedido_id ?>">
                            <div class="row">
                                <div class="col-5">
                                    <label class="form-label" for="produto">Produto:</label>
                                    <select class="form-select" id="produto" name="produto" required>
                                        <option value="" disabled selected>Selecione um produto</option>
                                        <?php foreach ($produtos as $produto) :
                                            $preco_custo = number_format($produto['custo'], 2, ',', '.');
                                            $valor_unitario = number_format($produto['valor_unitario'], 2, ',', '.'); ?>
                                            <option value="<?php echo $produto['id']; ?>" data-valor-unitario="<?= $valor_unitario ?>" data-preco-custo="<?= $preco_custo ?>">
                                                <?php echo $produto['descricao']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <input hidden readonly id="preco_custo" name="preco_custo" value="">

                                <div class="text-right col-2"> <!-- Divida a largura da tela ao meio para os elementos à direita -->
                                    <label for="valor_unitario" class="col-sm-12 col-form-label">Valor Unitário (R$)</label>
                                    <div class="col-sm-10"> <!-- Ajuste para ocupar toda a largura da div pai -->
                                        <div class="input-group">
                                            <span class="input-group-text">R$</span>
                                            <input style="text-align: center;" name="valor_unitario" type="text" class="form-control" id="valor_unitario" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-2">
                                    <label class="form-label" for="quantidade">Quantidade:</label>
                                    <input class="form-control" type="number" id="quantidade" name="quantidade" min="1" required>
                                </div>

                                <div class="col-3">
                                    <button style="margin-top: 35px;" class="btn btn-sm btn-success" type="submit">Adicionar Produto</button>
                                </div>
                            </div>
                        </form>

                        <br>
                        <!-- Tabela para exibir os produtos adicionados -->
                        <table class="table" id="tabelaProdutos">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th style="text-align: center;">Unidade</th>
                                    <th style="text-align: center;">Quantidade</th>
                                    <th style="text-align: center;">Valor Unitário</th>
                                    <th style="text-align: center;">Subtotal</th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php
                                foreach ($produtos_pedido as $produto) {
                                    $valor_unitario = number_format($produto['valor_unitario'], 2, ',', '.');
                                    $subtotal = number_format($produto['subtotal'], 2, ',', '.');

                                ?>
                                    <tr>
                                        <td><?= $produto['descricao'] ?></td>
                                        <td style="text-align: center;"><?= $produto['unidade'] ?></td>
                                        <td style="text-align: center;"><?= $produto['quantidade'] ?></td>
                                        <td style="text-align: center;">R$ <?= $valor_unitario ?></td>
                                        <td style="text-align: center;">R$ <?= $subtotal ?></td>
                                        <td style="text-align: center;">
                                            <button class="btn btn-sm btn-secondary rounded-pill btn-remover-produto" data-produto-id="<?= $produto['id'] ?>">Remover</button>
                                        </td>
                                    </tr>
                                <?php }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <div class="pagetitle">
                                    <h1>Informações de Pagamento</h1>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalRelatorioFinanceiro">
                                    Relatório Financeiro
                                </button>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-lg-6">
                                <form action="processa/atualiza_infos_pagamentos.php" method="POST">
                                    <input readonly hidden id="id_pedido_infs_pgto" name="id_pedido_infs_pgto" value="<?= $pedido_id ?>">
                                    <div class="row mb-3">
                                        <label for="tipo_pagamento" class="col-sm-4 col-form-label">Forma Pagamento:</label>
                                        <div class="col-sm-7">
                                            <select id="tipo_pagamento" name="tipo_pagamento" class="form-select" aria-label="Default select example">
                                                <option value="" disabled selected="">Selecione a forma de pagamento</option>
                                                <option value="1">Boleto</option>
                                                <option value="2">Cartão de Crédito</option>
                                                <option value="3">Dinheiro</option>
                                                <option value="4">PIX</option>
                                                <option value="5">Tranferência</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="parcelamento" class="col-sm-4 col-form-label">Condição Pagamento:</label>
                                        <div class="col-sm-7">
                                            <select id="parcelamento" name="parcelamento" class="form-select" aria-label="Default select example">
                                                <option value="" disabled selected="">Selecione a Condição</option>
                                                <option value="100">À Vista</option>
                                                <option value="1">1x (30 dias) </option>
                                                <option value="2">2x (30/60 dias)</option>
                                                <option value="3">3x (30/60/90 dias)</option>
                                                <option value="4">4x (30/60/90/120 dias)</option>
                                                <option value="5">5x (30/60/90/120/150 dias)</option>
                                                <option value="6">6x (30/60/90/120/150/180 dias)</option>
                                                <option value="7">7x (30/60/90/120/150/180/... dias)</option>
                                                <option value="8">8x (30/60/90/120/150/180/... dias) </option>
                                                <option value="9">9x (30/60/90/120/150/180/... dias) </option>
                                                <option value="10">10x (30/60/90/120/150/180/... dias) </option>
                                                <option value="11">11x (30/60/90/120/150/180/... dias) </option>
                                                <option value="12">12x (30/60/90/120/150/180/... dias) </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="mao_de_obra" class="col-form-label">Mão de Obra (R$)</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <span class="input-group-text">R$</span>
                                                <input style="text-align: center;" name="mao_de_obra" type="number" class="form-control" id="mao_de_obra">
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label for="valor_desconto" class="col-form-label">Desconto (R$)</label>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <span class="input-group-text">R$</span>
                                                <input style="text-align: center;" name="valor_desconto" type="number" class="form-control" id="valor_desconto">
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-sm btn-info">Salvar Informações</button>
                                    </div>
                                </form>

                            </div>

                            <div class="col-lg-6">
                                <div class="col-12">
                                    <?php
                                    // Consulta para obter o Tipo de Pagamento, Parcelamento e Desconto
                                    $sql_info_pedido = "SELECT mao_de_obra, tipo_pagamento, parcelamento, valor_desconto FROM ecommerce_pedido WHERE id = $pedido_id";
                                    $stmt_info_pedido = $pdo->query($sql_info_pedido);
                                    $resultado_info_pedido = $stmt_info_pedido->fetch(PDO::FETCH_ASSOC);

                                    if ($resultado_info_pedido) {
                                        $valor_tipo_pagamento = $resultado_info_pedido['tipo_pagamento'];
                                        $valor_parcelamento = $resultado_info_pedido['parcelamento'];
                                        $valor_desconto = $resultado_info_pedido['valor_desconto'];
                                        $mao_de_obra = $resultado_info_pedido['mao_de_obra'];

                                        switch ($valor_tipo_pagamento) {
                                            case 1:
                                                echo "<p style='text-align: right;' class='card-text'>Forma Pagamento: Boleto</p>";
                                                break;
                                            case 2:
                                                echo "<p style='text-align: right;' class='card-text'>Forma Pagamento: Cartão de Crédito</p>";
                                                break;
                                            case 3:
                                                echo "<p style='text-align: right;' class='card-text'>Forma Pagamento: Dinheiro</p>";
                                                break;
                                            case 4:
                                                echo "<p style='text-align: right;' class='card-text'>Forma Pagamento: PIX</p>";
                                                break;
                                            case 5:
                                                echo "<p style='text-align: right;' class='card-text'>Forma Pagamento: Transferência</p>";
                                                break;
                                            default:
                                                echo "<p style='text-align: right;' class='card-text'>Forma Pagamento: Não Definido</p>";
                                                break;
                                        }


                                        switch ($valor_parcelamento) {
                                            case 100:
                                                echo "<p style='text-align: right;' class='card-text'>Condição: À Vista</p>";
                                                break;
                                            case 1:
                                                echo "<p style='text-align: right;' class='card-text'>Condição: 1x (30 dias)</p>";
                                                break;
                                            case 2:
                                                echo "<p style='text-align: right;' class='card-text'>Condição: 2x (30/60 dias)</p>";
                                                break;
                                            case 3:
                                                echo "<p style='text-align: right;' class='card-text'>Condição: 3x (30/60/90 dias)</p>";
                                                break;
                                            case 4:
                                                echo "<p style='text-align: right;' class='card-text'>Condição: 4x (30/60/90/120 dias)</p>";
                                                break;
                                            case 5:
                                                echo "<p style='text-align: right;' class='card-text'>Condição: 5x (30/60/90/120/150 dias)</p>";
                                                break;
                                            case 6:
                                                echo "<p style='text-align: right;' class='card-text'>Condição: 6x (30/60/90/120/150/180 dias)</p>";
                                                break;
                                            case 7:
                                                echo "<p style='text-align: right;' class='card-text'>Condição: 7x (30/60/90/120/150/180/... dias)</p>";
                                                break;
                                            case 8:
                                                echo "<p style='text-align: right;' class='card-text'>Condição: 8x (30/60/90/120/150/180/... dias)</p>";
                                                break;
                                            case 9:
                                                echo "<p style='text-align: right;' class='card-text'>Condição: 9x (30/60/90/120/150/180/... dias)</p>";
                                                break;
                                            case 10:
                                                echo "<p style='text-align: right;' class='card-text'>Condição: 10x (30/60/90/120/150/180/... dias)</p>";
                                                break;
                                            case 11:
                                                echo "<p style='text-align: right;' class='card-text'>Condição: 11x (30/60/90/120/150/180/... dias)</p>";
                                                break;
                                            case 12:
                                                echo "<p style='text-align: right;' class='card-text'>Condição: 12x (30/60/90/120/150/180/... dias)</p>";
                                                break;
                                            default:
                                                echo "<p style='text-align: right;' class='card-text'>Condição: Não Definido</p>";
                                                break;
                                        }

                                        echo "<p style='text-align: right;' class='card-text'>Mão de Obra: R$ " . number_format($mao_de_obra, 2, ',', '.') . "</p>";
                                        echo "<p style='text-align: right;' class='card-text'>Desconto: R$ " . number_format($valor_desconto, 2, ',', '.') . "</p>";
                                    } else {
                                        echo "<p style='text-align: right;' class='card-text'>Informações do pedido não encontradas.</p>";
                                    }
                                    ?>
                                </div>
                                <br>
                                <div class="col-12">
                                    <?php
                                    $sql_total_pedido = "SELECT SUM(epp.subtotal) as total_pedido, SUM(epp.custo_total) as custo_total FROM ecommerce_pedido_produto as epp WHERE epp.pedido_id = $pedido_id";
                                    $stmt_total_pedido = $pdo->query($sql_total_pedido);
                                    $resultado_total_pedido = $stmt_total_pedido->fetch(PDO::FETCH_ASSOC);

                                    if ($resultado_total_pedido && isset($resultado_total_pedido['total_pedido'])) {
                                        $valor_produtos = $resultado_total_pedido['total_pedido'];
                                        $valor_final = (($resultado_total_pedido['total_pedido'] + $mao_de_obra) - $valor_desconto);
                                        $custo_total = $resultado_total_pedido['custo_total'];

                                        $valor_produtos_form = number_format($valor_produtos, 2, ',', '.');
                                        $custo_total_form = number_format($custo_total, 2, ',', '.');
                                        $total_pedido_form = number_format($valor_final, 2, ',', '.');

                                        echo "<h4 style='text-align: right;'><b>Total do Pedido: R$ $total_pedido_form</b></h4>";
                                    } else {
                                        echo "<h4 style='text-align: right;'><b>Total do Pedido: R$ 0,00</b></h4>";
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<div class="modal fade" id="modalRelatorioFinanceiro" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Relatório Financeiro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <?php
                $lucro_produtos = ($valor_produtos - $custo_total);
                $lucro_produtos_form = number_format($lucro_produtos, 2, ',', '.');
                $mao_de_obra_form = number_format($mao_de_obra, 2, ',', '.');
                $valor_desconto_form = number_format($valor_desconto, 2, ',', '.');
                $lucro_total = (($lucro_produtos + $mao_de_obra) - $valor_desconto);
                $lucro_total_form = number_format($lucro_total, 2, ',', '.');

                ?>
                <p>Custo Total de Produtos: R$ <?= $custo_total_form ?></p>
                <p>Total de Produtos: R$ <?= $valor_produtos_form ?></p>
                <p>Lucro Produtos: R$ <?= $lucro_produtos_form ?></p>
                <br>
                <p>Mão de Obra: R$ <?= $mao_de_obra_form ?> </p>
                <p>Desconto: R$ <?= $valor_desconto_form ?></p>
                <p>Lucro Total: R$ <?= $lucro_total_form ?></p>
                <p>Total do Pedido: R$ <?= $total_pedido_form ?></p>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-remover-produto').click(function() {
            var produtoId = $(this).data('produto-id');

            // Exibir mensagem de confirmação
            var confirmacao = confirm("Tem certeza de que deseja remover este produto da lista?");

            // Se o usuário confirmar, realizar a remoção
            if (confirmacao) {
                // Aqui você pode fazer uma chamada AJAX para remover o produto do banco de dados
                // ou realizar outras ações necessárias
                // Por exemplo, você pode redirecionar para uma página PHP que trata a remoção
                window.location.href = 'processa/remover_produto.php?produto_id=' + produtoId;
            }
        });
    });
</script>


<script>
    $(document).ready(function() {
        // Quando o valor do select produto mudar
        $("#produto").change(function() {
            // Obter o valor unitário associado ao produto selecionado
            var valorUnitario = $(this).find("option:selected").data("valor-unitario");

            // Definir o valor unitário no campo valor_unitario
            $("#valor_unitario").val(valorUnitario);
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Quando o valor do select produto mudar
        $("#produto").change(function() {
            // Obter o valor do custo associado ao produto selecionado
            var precoCusto = $(this).find("option:selected").data("preco-custo");

            // Definir o valor do custo no campo preco_custo
            $("#preco_custo").val(precoCusto);
        });
    });
</script>

<?php
require "../../includes/securityfooter.php";
?>