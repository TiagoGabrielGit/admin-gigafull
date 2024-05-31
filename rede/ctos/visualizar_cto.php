<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];

$submenu_id = "48";

// Verificação de permissões
$permissions = "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp
ON u.perfil_id = pp.perfil_id
WHERE u.id = :uid AND pp.url_submenu = :submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->bindParam(':uid', $uid, PDO::PARAM_INT);
$exec_permissions->bindParam(':submenu_id', $submenu_id, PDO::PARAM_INT);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {
    $consulta_cto = "SELECT * FROM gpon_ctos as gc WHERE id = :id";
    $stmt = $pdo->prepare($consulta_cto);
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $caixa = $result['title'];
    $codigoIntegracao = $result['paintegration_code'];
    $nbintegration_code = $result['nbintegration_code'];
    $longitude = $result['lng'];
    $latitude = $result['lat'];
    $nbintegration = $result['nbintegration_code'];


?>
    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h5 class="card-title">CTO - <?= $result['title'] ?></h5>
                        <form method="POST" action="processa/atualizar_cto.php">
                            <input id="id_cto" name="id_cto" hidden readonly value="<?= $_GET['id'] ?>">
                            <div class="row">
                                <div class="col-3">
                                    <label for="caixa" class="form-label">Caixa</label>
                                    <input id="caixa" name="caixa" class="form-control" value="<?= $caixa ?>"></input>
                                </div>
                                <div class="col-3">
                                    <label for="nbintegration" class="form-label">NB Integration</label>
                                    <input id="nbintegration" name="nbintegration" class="form-control" value="<?= $nbintegration ?>"></input>
                                </div>
                                <div class="col-2">
                                    <label for="codigoIntegracao" class="form-label">Código Integração</label>
                                    <input id="codigoIntegracao" name="codigoIntegracao" class="form-control" value="<?= $codigoIntegracao ?>"></input>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input id="latitude" name="latitude" class="form-control" value="<?= $latitude ?>"></input>
                                </div>
                                <div class="col-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input id="longitude" name="longitude" class="form-control" value="<?= $longitude ?>"></input>
                                </div>
                            </div>
                            <br><br>
                            <div class="text-center">
                                <button type="submit" class="btn btn-sm btn-danger">Salvar Alterações</button>
                            </div>
                        </form>
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