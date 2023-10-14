<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];
$submenu_id = "32";

$permissions =
    "SELECT 
	u.perfil_id
FROM 
	usuarios u
JOIN 
	perfil_permissoes_submenu pp
ON 
	u.perfil_id = pp.perfil_id
WHERE
	u.id = $uid
AND 
	pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {

    $idPON = $_GET['id'];

    $sql_pon =
        "SELECT
    gpp.id as idPON,
    gpp.slot as slot,
    gpp.pon as pon,
    gpo.olt_name as olt,
    gpp.active as active,
    gpp.cod_int as codigo
    FROM
    gpon_pon as gpp
    LEFT JOIN
    gpon_olts as gpo
    ON
    gpo.id = gpp.olt_id
    WHERE
    gpp.id = :idPON
    ";

    try {
        // Prepara e executa a consulta usando prepared statements
        $stmt = $pdo->prepare($sql_pon);
        $stmt->bindParam(':idPON', $idPON, PDO::PARAM_INT); // Vincule o valor de idPON como parâmetro
        $stmt->execute();

        // Obtém o resultado da consulta como um array associativo
        $pon = $stmt->fetch(PDO::FETCH_ASSOC);
        $codIntPON = $pon['codigo'];
    } catch (PDOException $e) {
        echo "Erro na consulta: " . $e->getMessage();
    }

?>

    <main id="main" class="main">

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">ID: <?= $idPON ?></h5>
                            <?php
                            if (isset($_GET['error'])) {
                                $errorMessage = $_GET['error'];

                                if ($errorMessage === 'codigo_ja_existe') {
                                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                    echo 'Esse código de integração já existe.';
                                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                                    echo '</div>';
                                }
                            }
                            ?>
                            <form action="processa/edita_pon.php" method="POST" class="row g-3">

                                <input readonly hidden name="idPON" type="text" class="form-control" id="idPON" value="<?= $idPON ?>">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="olt" class="form-label">OLT</label>
                                        <input disabled name="olt" type="text" class="form-control" id="olt" value="<?= $pon['olt']; ?>" required>
                                    </div>

                                    <div class="col-3">
                                        <label for="activePON" class="form-label">Status</label>
                                        <select class="form-select" id="activePON" name="activePON" required>
                                            <option value="" disabled selected>Selecione...</option>
                                            <option value="0" <?= ($pon['active'] == 0) ? 'selected' : ''; ?>>Inativo</option>
                                            <option value="1" <?= ($pon['active'] == 1) ? 'selected' : ''; ?>>Ativo</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-2">
                                        <label for="slot" class="form-label">SLOT</label>
                                        <input disabled readonly name="slot" type="text" class="form-control" id="slot" value="<?= $pon['slot']; ?>" required>
                                    </div>

                                    <div class="col-2">
                                        <label for="pon" class="form-label">PON</label>
                                        <input disabled readonly name="pon" type="text" class="form-control" id="pon" value="<?= $pon['pon']; ?>" required>
                                    </div>

                                    <div class="col-2">
                                        <label for="codigo" class="form-label">Código Integração</label>
                                        <input name="codigo" type="text" class="form-control" id="codigo" value="<?= $pon['codigo']; ?>" required>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-danger">Salvar</button>
                                    <a href="/rede/gpon/index.php" class="btn btn-secondary">Voltar</a>
                                </div>

                            </form>
                            <hr class="sidebar-divider">
                        </div>

                        <div class="card-body">
                            <div class="row">

                                <div class="col-lg-6">
                                    <h5 class="card-title">Localidades Atendidas</h5>

                                    <form method="POST" action="processa/adicionar_localidades.php" class="row g-3">
                                        <hr class="sidebar-divider">

                                        <input id="loc_idPON" name="loc_idPON" readonly hidden value="<?= $idPON ?>"></input>

                                        <div class="row">
                                            <div class="col-4">
                                                <label for="cidade" class="form-label">Cidade</label>
                                                <input required id="cidade" name="cidade" class="form-control"></input>
                                            </div>

                                            <div class="col-4">
                                                <label for="bairro" class="form-label">Bairro</label>
                                                <input required id="bairro" name="bairro" class="form-control"></input>
                                            </div>

                                            <div class="col-4">
                                                <button style="margin-top: 35px;" type="submit" class="btn btn-sm btn-danger">Adicionar</button>
                                            </div>
                                        </div>
                                    </form>
                                    <hr class="sidebar-divider">

                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Cidade</th>
                                                <th scope="col">Bairro</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $localidades =
                                                "SELECT
                                        gpl.id as idLocalidade,
                                        gpl.cidade as cidade,
                                        gpl.bairro as bairro
                                        FROM
                                        gpon_localidades as gpl
                                        WHERE
                                        gpl.active = 1
                                        and
                                        gpl.pon_id = $idPON
                                        ";
                                            $r_localidades = mysqli_query($mysqli, $localidades) or die("Erro ao retornar dados");
                                            while ($c_localidades = $r_localidades->fetch_array()) {
                                                $idLocalidade = $c_localidades['idLocalidade'];
                                            ?>
                                                <tr id="tabelaLista">
                                                    <td><?= $c_localidades['cidade'] ?></td>
                                                    <td><?= $c_localidades['bairro'] ?></td>
                                                    <td>
                                                        <form method="POST" action="processa/excluir_localidade.php">
                                                            <input hidden readonly id="locPONID" name="locPONID" value="<?= $idPON ?>"></input>

                                                            <input hidden readonly id="locID" name="locID" value="<?= $idLocalidade ?>"></input>
                                                            <button class="btn btn-sm btn-danger">Excluir</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-6">
                                    <h5 class="card-title">CTOs da PON</h5>

                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Caixa</th>
                                                <th scope="col">Latitude</th>
                                                <th scope="col">Longitude</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query_ctos =
                                                "SELECT *
                                        FROM gpon_ctos as gc
                                        WHERE gc.paintegration_code =  $codIntPON";
                                            $r_ctos = mysqli_query($mysqli, $query_ctos) or die("Erro ao retornar dados");
                                            while ($c_ctos = $r_ctos->fetch_array()) {
                                                $caixa = $c_ctos['title'];
                                                $lat = $c_ctos['lat'];
                                                $lng = $c_ctos['lng'];

                                            ?>
                                                <tr>
                                                    <td><?= $caixa ?></td>
                                                    <td><?= $lat ?></td>
                                                    <td><?= $lng ?></td>

                                                </tr>
                                            <?php } ?>
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
<?php
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>