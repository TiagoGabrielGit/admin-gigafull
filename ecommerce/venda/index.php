<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

// Obter a lista de clientes disponíveis no banco de dados
$sql_clientes = "SELECT e.id, e.fantasia FROM empresas as e WHERE e.atributoCliente = 1 ORDER BY e.fantasia ASC"; // Substitua pela sua consulta SQL real
$stmt_clientes = $pdo->query($sql_clientes);
$clientes = $stmt_clientes->fetchAll(PDO::FETCH_ASSOC);

// Obter a lista de produtos disponíveis no banco de dados
$sql_produtos = "SELECT pe.id, pe.descricao FROM ecommerce_produtos as pe WHERE pe.active = 1 ORDER BY pe.descricao ASC"; // Substitua pela sua consulta SQL real
$stmt_produtos = $pdo->query($sql_produtos);
$produtos = $stmt_produtos->fetchAll(PDO::FETCH_ASSOC);
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dados do Pedido</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <br>
                        <form method="POST" action="processa/dados_pedido.php">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label" for="cliente">Cliente:</label>
                                    <select class="form-select" id="cliente" name="cliente" required>
                                        <option value="" disabled selected>Selecione um cliente</option>
                                        <?php foreach ($clientes as $cliente) : ?>
                                            <option value="<?= $cliente['id']; ?>"><?= $cliente['fantasia']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button class="btn btn-sm btn-info" type="submit">Iniciar Pedido</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require "../../includes/securityfooter.php";
?>