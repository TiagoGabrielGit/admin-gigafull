<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";
// Consulta SQL para obter a listagem de servidores de e-mail
$lista_servidores = "SELECT * FROM servermail as se order by server ASC";
$stmt = $pdo->query($lista_servidores);
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Configurações E-mail</h5>

                        <!-- Bordered Tabs Justified -->
                        <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-home" type="button" role="tab" aria-controls="home" aria-selected="true">Servidor E-mail</button>
                            </li>
                            <li class="nav-item flex-fill" role="presentation">
                                <button class="nav-link w-100" id="config-send-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-config-send" type="button" role="tab" aria-controls="config-send" aria-selected="false" tabindex="-1">Configurações de Envio</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                            <div class="tab-pane fade active show" id="bordered-justified-home" role="tabpanel" aria-labelledby="home-tab">
                                <?php require "tabs/configuracao.php"; ?>
                            </div>
                            <div class="tab-pane fade" id="bordered-justified-config-send" role="tabpanel" aria-labelledby="config-send-tab">
                                <?php require "tabs/config-send.php"; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
require "js.php";
require "../../includes/footer.php";
