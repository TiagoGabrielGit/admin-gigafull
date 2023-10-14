<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";
require "../../includes/remove_setas_number.php";

$submenu_id = "38";
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

    $integracao_wr =
        "SELECT
iwg.id as id,
iwg.token as token,
iwg.active as status,
iwg.urlWR as urlWR,
iwg.dateBefor as dateBefor,
iwg.mensagem_default as mensagem,
iwg.location_incident_scheduler as locIC
FROM
integracao_wr_gateway as iwg
WHERE
iwg.id = 1
";

    $r_integracao_wr = $pdo->query($integracao_wr);
    $c_integracao_wr = $r_integracao_wr->fetch(PDO::FETCH_ASSOC);
?>

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Parâmetros Integração WR Gateway</h5>

                            <?php
                            if (isset($_SESSION['apiResponse'])) {
                                $message = $_SESSION['apiResponse'];
                                unset($_SESSION['apiResponse']);

                                echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
                                echo $message;
                                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                                echo '</div>';
                            }
                            ?>

                            <div class="text-end">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#modalCriarUsuario" class="btn btn-sm btn-danger">Criar Usuário Integrador</button>

                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <form action="processa/update.php" method="POST">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="url" class="form-label">URL WR Gateway</label>
                                                <input <?= ($c_integracao_wr['urlWR'] === NULL) ? "" : 'value="' . $c_integracao_wr['urlWR'] . '"' ?> placeholder="Ex: http://wrg.dominio.com.br:3000" name="url" id="url" class="form-control" type="text">
                                            </div>
                                            <div class="col-3">
                                                <label for="statusIntegracao" class="form-label">Integração Ativa</label>
                                                <select name="statusIntegracao" id="statusIntegracao" class="form-select" aria-label="Default select example">
                                                    <option <?= ($c_integracao_wr['status'] == "1") ? "selected" : "" ?> value="1">Sim</option>
                                                    <option <?= ($c_integracao_wr['status'] == "0") ? "selected" : "" ?> value="0">Não</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="token" class="form-label">Token API WR Gateway</label>
                                                <input maxlength="200" <?= ($c_integracao_wr['token'] === NULL) ? "" : 'value="' . $c_integracao_wr['token'] . '"' ?> name="token" id="token" class="form-control" type="text"></input>
                                            </div>

                                            <div class="col-3">
                                                <label for="dateBefor" class="form-label">Dias Antecedência de Envio</label>
                                                <input <?= ($c_integracao_wr['dateBefor'] === NULL) ? "" : 'value="' . $c_integracao_wr['dateBefor'] . '"' ?> class="form-control" id="dateBefor" name="dateBefor" type="number"></input>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="col-12">
                                                    <label for="mensagemDefault" class="form-label">Mensagem Default</label>
                                                    <textarea rows="10" name="mensagem" id="mensagem" class="form-control" type="text"><?= $c_integracao_wr['mensagem'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <br><br>
                                                <div class="col-8">
                                                    <label for="locIC" class="form-label">Location API Incident Scheduler</label>
                                                    <input maxlength="100" <?= ($c_integracao_wr['locIC'] === NULL) ? "" : 'value="' . $c_integracao_wr['locIC'] . '"' ?> name="locIC" id="locIC" class="form-control" type="text"></input>
                                                </div>
                                            </div>

                                        </div>
                                        <br><br>
                                        <div class="text-center">
                                            <button class="btn btn-danger" type="submit">Salvar</button>
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

    <div class="modal fade" id="modalCriarUsuario" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form action="processa/cria_usuario_integrador.php" method="POST" class="row g-3">

                            <input id="WRurl" name="WRurl" readonly hidden value="<?= $c_integracao_wr['urlWR'] ?>"></input>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="nomeUsuario" class="form-label">Nome</label>
                                        <input type="text" name="nomeUsuario" id="nomeUsuario" class="form-control"></input>
                                    </div>

                                    <div class="col-6">
                                        <label for="emailUsuario" class="form-label">E-mail</label>
                                        <input type="email" name="emailUsuario" id="emailUsuario" class="form-control"></input>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-12" style="text-align: center;">

                                <button type="submit" class="btn btn-sm btn-danger">Cadastrar usuário</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>