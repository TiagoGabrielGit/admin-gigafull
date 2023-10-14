<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";


$submenu_id = "42";
$uid = $_SESSION['id'];

$permissions_submenu =
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

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {

    $integracao_voalle =
        "SELECT
iv.id as id,
iv.syndata as syndata,
iv.token as tokenAPI,
iv.token_estatico as token_estatico,
iv.user_db as user_db,
iv.pass_db as pass_db,
iv.host_db as host_db,
iv.urlVoalle as urlVoalle,
iv.token_expire as token_expire,
iv.usuario_integracao as usuarioIntegracao,
iv.senha_integracao as senhaIntegracao,
iv.api_request_token as api_request_token,
iv.api_relatos_solicitacao as api_relatos_solicitacao,
iv.api_detalhes_solicitacao as api_detalhes_solicitacao,
iv.active as active
FROM
integracao_voalle as iv
WHERE
iv.id = 1
";

    $r_integracao_voalle = $pdo->query($integracao_voalle);
    $c_integracao_voalle = $r_integracao_voalle->fetch(PDO::FETCH_ASSOC);


    $expires_in = $c_integracao_voalle['token_expire'];
    $current_timestamp = time();
    $token_expired = ($current_timestamp >= strtotime($c_integracao_voalle['token_expire']));

?>

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between">
                                <div class="text-left">
                                    <h5 class="card-title">Parâmetros Integração Voalle</h5>
                                </div>
                                <div class="text-end">
                                    <?php if ($token_expired) { ?>
                                        <div class="text-end">
                                            <button class="btn btn-sm btn-danger" style="margin-top: 25px;" id="requestTokenButton">Requistar Token</button>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="processa/update.php" method="POST">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="urlVoalle" class="form-label">URL Voalle</label>
                                                <input <?= ($c_integracao_voalle['urlVoalle'] === NULL) ? "" : 'value="' . $c_integracao_voalle['urlVoalle'] . '"' ?> placeholder="Ex: https://erp.voalle.com.br" name="urlVoalle" id="urlVoalle" class="form-control" type="text">
                                            </div>
                                            <div class="col-3">
                                                <label for="statusIntegracao" class="form-label">Integração Ativa</label>
                                                <select name="statusIntegracao" id="statusIntegracao" class="form-select" aria-label="Default select example">
                                                    <option <?= ($c_integracao_voalle['active'] == "1") ? "selected" : "" ?> value="1">Sim</option>
                                                    <option <?= ($c_integracao_voalle['active'] == "0") ? "selected" : "" ?> value="0">Não</option>
                                                </select>
                                            </div>

                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="usuarioIntegracao" class="form-label">Usuário Integração</label>
                                                <input <?= ($c_integracao_voalle['usuarioIntegracao'] === NULL) ? "" : 'value="' . $c_integracao_voalle['usuarioIntegracao'] . '"' ?> name="usuarioIntegracao" id="usuarioIntegracao" class="form-control" type="text"></input>
                                            </div>

                                            <div class="col-6">
                                                <label for="senhaIntegracao" class="form-label">Senha Integração</label>
                                                <input <?= ($c_integracao_voalle['senhaIntegracao'] === NULL) ? "" : 'value="' . $c_integracao_voalle['senhaIntegracao'] . '"' ?> name="senhaIntegracao" id="senhaIntegracao" class="form-control" type="text"></input>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="hostDB" class="form-label">Host DB</label>
                                                <input <?= ($c_integracao_voalle['host_db'] === NULL) ? "" : 'value="' . $c_integracao_voalle['host_db'] . '"' ?> name="hostDB" id="hostDB" class="form-control" type="text"></input>
                                            </div>

                                            <div class="col-4">
                                                <label for="usuarioDB" class="form-label">Usuário DB</label>
                                                <input <?= ($c_integracao_voalle['user_db'] === NULL) ? "" : 'value="' . $c_integracao_voalle['user_db'] . '"' ?> name="usuarioDB" id="usuarioDB" class="form-control" type="text"></input>
                                            </div>

                                            <div class="col-4">
                                                <label for="senhaDB" class="form-label">Senha DB</label>
                                                <input <?= ($c_integracao_voalle['pass_db'] === NULL) ? "" : 'value="' . $c_integracao_voalle['pass_db'] . '"' ?> name="senhaDB" id="senhaDB" class="form-control" type="text"></input>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="syndata" class="form-label">SynData</label>
                                                <textarea rows="4" name="syndata" id="syndata" class="form-control" type="text"><?= ($c_integracao_voalle['syndata'] === NULL) ? "" : $c_integracao_voalle['syndata']  ?></textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-8">
                                                <label for="tokenEstatico" class="form-label">Token Estático</label>
                                                <input id="tokenEstatico" name="tokenEstatico" class="form-control" value="<?= $c_integracao_voalle['token_estatico'] ?>" type="text"></input>

                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-9">
                                                <label for="tokenAPI" class="form-label">Token API Voalle</label>
                                                <textarea rows="4" readonly name="tokenAPI" id="tokenAPI" class="form-control" type="text"><?= ($c_integracao_voalle['tokenAPI'] === NULL) ? "" : $c_integracao_voalle['tokenAPI'] ?></textarea>
                                            </div>
                                            <div class="col-3">
                                                <label for="tokenExpire" class="form-label">Token Expire</label>
                                                <input readonly disabled class="form-control" value="<?= $c_integracao_voalle['token_expire'] ?>" type="datetime-local"></input>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="row mb-3">
                                                    <label for="api_request_token" class="col-sm-4 col-form-label">Requisitar Token</label>
                                                    <div class="col-sm-7">
                                                        <input placeholder="Ex: :45700/connect/token" id="api_request_token" name="api_request_token" value="<?= $c_integracao_voalle['api_request_token'] ?>" type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row mb-3">
                                                    <label for="api_detalhes_solicitacao" class="col-sm-4 col-form-label">Detalhes da Solicitação </label>
                                                    <div class="col-sm-7">
                                                        <input placeholder="Ex: :45715/external/integrations/thirdparty/projects/getsolicitationdata?" id="api_detalhes_solicitacao" name="api_detalhes_solicitacao" value="<?= $c_integracao_voalle['api_detalhes_solicitacao'] ?>" type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row mb-3">
                                                    <label for="api_relatos_solicitacao" class="col-sm-4 col-form-label">Relatos da Solicitação </label>
                                                    <div class="col-sm-7">
                                                        <input placeholder="Ex: :45715/external/integrations/thirdparty/getsolicitationhistory?" id="api_relatos_solicitacao" name="api_relatos_solicitacao" value="<?= $c_integracao_voalle['api_relatos_solicitacao'] ?>" type="text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-sm btn-danger" type="submit">Salvar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script type="text/javascript">
        // JavaScript para lidar com a solicitação de novo token
        document.getElementById('requestTokenButton').addEventListener('click', function() {
            // Use uma requisição AJAX para chamar o arquivo request_token.php
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/integracao/voalle/api/request_token.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    //var response = xhr.responseText;
                    //alert("Solicitação de novo token tratada. Resposta: " + response);
                    location.reload();

                } else {
                    location.reload();

                }
            };
            xhr.send();
        });
    </script>
<?php
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>