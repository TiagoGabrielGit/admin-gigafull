<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$pedido_id = $_GET['pedido_id'];

// Obter a lista de clientes disponíveis no banco de dados
$sql_cliente = "SELECT ep.status, ep.date_entrega, ep.date, e.id, e.fantasia, e.cnpj, ca.street, ca.number, ca.city, ca.state, ca.neighborhood, ca.complement, ca.cep 
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
                        <div class="pagetitle">
                            <h1>Dados do Pedido</h1>
                        </div><!-- End Page Title -->

                        <div class="col-1">
                            <label class="form-label">Nº Pedido:</label>
                            <input style="text-align: center;" value="<?= $pedido_id ?>" class="form-control" disabled>
                        </div>
                        <br>
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
                            </div>
                            <div class="col-lg-5">
                                <form action="processa/atualiza_dados_pedido.php" method="POST">
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

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-sm btn-info">Salvar Modificações</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
                                            $valor_unitario = number_format($produto['valor_unitario'], 2, ',', '.');
                                        ?>
                                            <option value="<?php echo $produto['id']; ?>" data-valor-unitario="<?= $valor_unitario ?>"><?php echo $produto['descricao']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>


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
                        <div class="pagetitle">
                            <h1>Informações do Pedido</h1>
                        </div><!-- End Page Title -->

                        <div class="container mt-6">
                            <div class="row justify-content-end">
                                <div class="col-6 text-right">
                                    <?php
                                    $sql_total_pedido = "SELECT SUM(epp.subtotal) as total_pedido
                                FROM ecommerce_pedido_produto as epp
                                WHERE epp.pedido_id = $pedido_id";

                                    // Executar a consulta
                                    $stmt_total_pedido = $pdo->query($sql_total_pedido);
                                    $resultado_total_pedido = $stmt_total_pedido->fetch(PDO::FETCH_ASSOC);

                                    // Verificar se há resultados
                                    if ($resultado_total_pedido && isset($resultado_total_pedido['total_pedido'])) {
                                        $total_pedido = number_format($resultado_total_pedido['total_pedido'], 2, ',', '.');
                                        echo "<h3>Total do Pedido: R$ $total_pedido</h3>";
                                    } else {
                                        echo "<h3>Total do Pedido: R$ 0,00</h3>";
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

<?php
require "../../includes/securityfooter.php";
?>