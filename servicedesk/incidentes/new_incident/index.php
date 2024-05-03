<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao.php";
require "../../../conexoes/conexao_pdo.php";

$submenu_id = "37";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {

?>

    <main id="main" class="main">
        <section class="section">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Criar Informativo</h5>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="row">
                                <div class="col-4">
                                    <label for="tipo" class="form-label">Tipo Incidente</label>
                                    <select class="form-select" id="tipo" name="tipo" required>
                                        <option selected disabled value="">Selecione...</option>
                                        <?php
                                        $sql = "SELECT * FROM incidentes_types as it where it.active = 1 ORDER BY it.type ASC";
                                        $result = $mysqli->query($sql);
                                        while ($row = $result->fetch_assoc()) { ?>

                                            <option value="<?= $row['codigo'] ?>" <?php if (isset($_POST['tipo']) && $_POST['tipo'] == $row['codigo']) echo "selected"; ?>><?= $row['type'] ?></option>

                                        <?php }
                                        ?>
                                    </select>
                                </div>
                                <div style="margin-top: 35px;" class="col-4">
                                    <button type="submit" class="btn btn-sm btn-danger">Selecionar</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Formulário Novo Informativo</h5>
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $tipo_incidente = $_POST['tipo'];
                            if ($tipo_incidente == 100) { ?>
                                <form method="POST" action="processa/novo_incidente_gpon.php" class="row g-3">
                                    <input readonly hidden id="tipo" name="tipo" value="100"></input>

                                    <div class="row">
                                        <div class="col-5">
                                            <label for="descricao" class="form-label">Descrição</label>
                                            <input name="descricao" type="text" class="form-control" id="descricao" required>
                                        </div>

                                        <div class="col-3">
                                            <label for="inicio" class="form-label">Inicio</label>
                                            <input name="inicio" type="datetime-local" class="form-control" id="inicio" required>
                                        </div>
                                    </div>

                                    <hr class="sidebar-divider">
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

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-sm btn-danger">Criar Incidente</button>
                                    </div>
                                </form>
                            <?php } elseif ($tipo_incidente == 102) { ?>
                                <form method="POST" action="processa/novo_incidente_backbone.php" class="row g-3">
                                    <input readonly hidden id="tipo" name="tipo" value="102"></input>

                                    <div class="row">
                                        <div class="col-5">
                                            <label for="descricao" class="form-label">Descrição</label>
                                            <input name="descricao" type="text" class="form-control" id="descricao" required>
                                        </div>

                                        <div class="col-3">
                                            <label for="inicio" class="form-label">Inicio</label>
                                            <input name="inicio" type="datetime-local" class="form-control" id="inicio" required>
                                        </div>
                                    </div>

                                    <hr class="sidebar-divider">
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

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-sm btn-danger">Criar Incidente</button>
                                    </div>
                                </form>
                            <?php } else { ?>
                                <form method="POST" action="processa/novo_incidente_outros.php" class="row g-3">
                                    <input readonly hidden id="tipo" name="tipo" value="<?= $tipo_incidente ?>"></input>

                                    <div class="row">
                                        <div class="col-5">
                                            <label for="descricao" class="form-label">Descrição</label>
                                            <input name="descricao" type="text" class="form-control" id="descricao" required>
                                        </div>

                                        <div class="col-3">
                                            <label for="inicio" class="form-label">Inicio</label>
                                            <input name="inicio" type="datetime-local" class="form-control" id="inicio" required>
                                        </div>
                                    </div>

                                    <hr class="sidebar-divider">


                                    <div class="text-center">
                                        <button type="submit" class="btn btn-sm btn-danger">Criar Incidente</button>
                                    </div>
                                </form>
                        <?php }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </main>


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