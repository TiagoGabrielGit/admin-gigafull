<?php
require "../../../includes/menu.php";
require "../../../includes/remove_setas_number.php";
require "../../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];
$submenu_id = "37";

$permissions =
    "SELECT u.perfil_id 
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {
?>
    <main id="main" class="main">

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Novo Incidente</h3>

                            <hr class="sidebar-divider">

                            <br><br>

                            <form method="POST" action="processa/novo_incidente.php" class="row g-3">
                                <div class="row">
                                    <div class="col-5">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <input name="descricao" type="text" class="form-control" id="descricao" required>
                                    </div>

                                    <div class="col-3">
                                        <label for="inicio" class="form-label">Inicio</label>
                                        <input name="inicio" type="datetime-local" class="form-control" id="inicio" required>
                                    </div>

                                    <div class="col-2">
                                        <label for="tipo" class="form-label">Tipo Incidente</label>
                                        <select class="form-select" id="tipo" name="tipo" required>
                                            <option selected disabled value="">Selecione...</option>
                                            <option value="102">Backbone</option>
                                            <option value="100">GPON</option>
                                            <option value="200">Outros</option>
                                        </select>
                                    </div>
                                </div>

                                <hr class="sidebar-divider">

                                <div class="row">
                                    <div class="col-lg-12" id="fibraOptions">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Rotas de Fibra</h5>
                                                <?php
                                                $query = "SELECT
                                                rf.id as id,
                                                rf.ponta_a as ponta_a,
                                                rf.ponta_b as ponta_b,
                                                rf.codigo as codigo
                                                FROM
                                                rotas_fibra as rf
                                                WHERE
                                                rf.active = 1";

                                                try {
                                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                    $stmt = $pdo->prepare($query);
                                                    $stmt->execute();
                                                    $rotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                                } catch (PDOException $e) {
                                                    echo "Erro na consulta SQL: " . $e->getMessage();
                                                } ?>
                                                <select class="form-select" id="rotasFibras" name="rotasFibras">
                                                    <option value="" disabled selected>Selecione...</option>
                                                    <?php
                                                    foreach ($rotas as $rota) :
                                                    ?>
                                                        <option value="<?= $rota['codigo'] ?>"><?= $rota['ponta_a'] . " <b> <> </b> " . $rota['ponta_b']; ?></option>

                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12" id="gponOptions">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">GPON</h5>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label" for="olt">Selecione OLT</label>
                                                        <select class="form-select" id="olt" name="olt">
                                                            <option disabled selected value="">Selecione...</option>

                                                            <?php
                                                            $query_olts =
                                                                "SELECT
                                                                gpo.id as idOLT,
                                                                gpo.olt_name as olt,
                                                                gpo.equipamento_id as equipamento_id
                                                                FROM
                                                                gpon_olts as gpo
                                                                WHERE
                                                                gpo.active = 1
                                                                ORDER BY
                                                                gpo.olt_name ASC
                                                                ";

                                                            try {
                                                                $stmt_olts = $pdo->prepare($query_olts);
                                                                $stmt_olts->execute();
                                                                $olts = $stmt_olts->fetchAll(PDO::FETCH_ASSOC);

                                                                foreach ($olts as $olt) {
                                                                    $idsOLTs = $olt['idOLT'];
                                                                    $equipamento_id = $olt['equipamento_id'];
                                                                    echo '<option value="' . $equipamento_id . '">' . $olt['olt'] . '</option>';
                                                                }
                                                            } catch (PDOException $e) {
                                                                echo "Erro na consulta SQL: " . $e->getMessage();
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div id="ponsList" class="col-6"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-sm btn-danger">Criar Incidente</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main><!-- End #main -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtém uma referência ao elemento de seleção do tipo de incidente
            var tipoIncidenteSelect = document.getElementById("tipo");

            // Obtém referências aos elementos de opções de GPON e de rota de fibra
            var gponOptions = document.getElementById("gponOptions");
            var fibraOptions = document.getElementById("fibraOptions");

            // Define um ouvinte de evento para detectar mudanças no tipo de incidente
            tipoIncidenteSelect.addEventListener("change", function() {
                var selectedValue = tipoIncidenteSelect.value;

                // Oculta todos os elementos de opções inicialmente
                gponOptions.style.display = "none";
                fibraOptions.style.display = "none";

                // Mostra o elemento apropriado com base na seleção
                if (selectedValue === "100") {
                    gponOptions.style.display = "block";
                } else if (selectedValue === "102") {
                    fibraOptions.style.display = "block";
                }
            });

            // Executa o código para configurar a exibição inicial com base no valor selecionado
            tipoIncidenteSelect.dispatchEvent(new Event("change"));
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Certifique-se de incluir a biblioteca jQuery -->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var oltSelect = document.getElementById("olt");
            var ponsList = document.getElementById("ponsList");

            oltSelect.addEventListener("change", function() {
                var selectedOLT = oltSelect.value;

                $.ajax({
                    url: "lista_pons.php", // Substitua com o caminho do seu script PHP
                    type: "POST",
                    data: {
                        olt_id: selectedOLT
                    },
                    success: function(response) {
                        ponsList.innerHTML = response;
                    },
                    error: function() {
                        console.error("Erro na solicitação AJAX");
                    }
                });
            });
        });
    </script>


<?php

} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php";
?>