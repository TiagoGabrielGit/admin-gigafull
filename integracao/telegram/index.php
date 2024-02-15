<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";


$submenu_id = "51";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp ON  u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {

    $integracao_telegram =
        "SELECT
        it.id as id, it.token as token, it.active as active
        FROM integracao_telegram as it
        WHERE it.id = 1";

    $r_integracao_telegram = $pdo->query($integracao_telegram);
    $c_integracao_telegram = $r_integracao_telegram->fetch(PDO::FETCH_ASSOC);
?>

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between">
                                <div class="text-left">
                                    <h5 class="card-title">Parâmetros Integração Telegram</h5>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="processa/update.php" method="POST">
                                        <div class="row">
                                            <div class="col-5">
                                                <label for="tokenTelegram" class="form-label">Token Telegram</label>
                                                <input <?= ($c_integracao_telegram['token'] === NULL) ? "" : 'value="' . $c_integracao_telegram['token'] . '"' ?> placeholder="" name="tokenTelegram" id="tokenTelegram" class="form-control" type="text">
                                            </div>
                                            <div class="col-4"></div>
                                            <div class="col-3">
                                                <label for="statusIntegracao" class="form-label">Integração Ativa</label>
                                                <select name="statusIntegracao" id="statusIntegracao" class="form-select" aria-label="Default select example">
                                                    <option <?= ($c_integracao_telegram['active'] == "1") ? "selected" : "" ?> value="1">Sim</option>
                                                    <option <?= ($c_integracao_telegram['active'] == "0") ? "selected" : "" ?> value="0">Não</option>
                                                </select>
                                            </div>

                                        </div>
                                        <br>
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