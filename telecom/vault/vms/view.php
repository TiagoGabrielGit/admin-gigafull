<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$submenu_id = "68";
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
    $vm_id = $_GET['id'];

    $sql_sql_vm =
        "SELECT e.fantasia as empresa, p.pop as pop, vm.hostname as hostname, ep.hostname as servidor, vm.ipaddress as ip
        FROM vms as vm
        LEFT JOIN empresas as e ON e.id = vm.empresa_id
        LEFT JOIN pop as p ON p.id = vm.pop_id
        LEFT JOIN equipamentospop as ep ON vm.servidor_id = ep.id
        WHERE vm.id = $vm_id";

    $resultado = mysqli_query($mysqli, $sql_sql_vm);
    $row = mysqli_fetch_assoc($resultado);

?>

    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <h5 class="card-title">Credenciais VM</h5>
                        </div>
                       
                        <div class="col-2">
                            <a href="/telecom/vmslocal/view.php?id=<?=$vm_id?>">
                                <button style="margin-top: 15px;" type="button" class="btn btn-sm btn-secondary">Voltar a VM</button>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <label class="form-label">Empresa</label>
                            <input readonly disabled class="form-control" value="<?= $row['empresa'] ?>">
                        </div>

                        <div class="col-2">
                            <label class="form-label">POP</label>
                            <input readonly disabled class="form-control" value="<?= $row['pop'] ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <label class="form-label">Hostname</label>
                            <input readonly disabled class="form-control" value="<?= $row['hostname'] ?>">
                        </div>

                        <div class="col-3">
                            <label class="form-label">Servidor</label>
                            <input readonly disabled class="form-control" value="<?= $row['servidor'] ?>">
                        </div>

                        <div class="col-3">
                            <label class="form-label">IP</label>
                            <input readonly disabled class="form-control" value="<?= $row['ip'] ?>">
                        </div>
                    </div>

                    <hr class="sidebar-divider">
                    <div class="row">
                        <div class="col-10"></div>
                        <div class="col-2">

                            <button data-bs-toggle="modal" data-bs-target="#AddSenhaVM" type="button" class="btn btn-info">Adicionar Credencial</button>

                            <div class="modal fade" id="AddSenhaVM" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Adicionar senha</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <form action="processa/adicionar_credencial.php" method="POST" class="row g-3 needs-validation">

                                                            <input name="idVM" class="form-control" id="idVM" hidden value="<?= $vm_id ?>">
                                                            <div class="row">

                                                                <div class="col-lg-3">
                                                                    <div class="col-12">
                                                                        <label for="cadastroPrivacidade" class="form-label">Privacidade*</label>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="cadastroPrivacidade" id="cadastroPrivacidade" value="1" checked="">
                                                                            <label class="form-check-label" for="cadastroPrivacidade" value="1">Público</label>
                                                                        </div>

                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="cadastroPrivacidade" id="cadastroPrivacidade" value="2">
                                                                            <label class="form-check-label" for="cadastroPrivacidade" value="2">Privado</label>
                                                                        </div>

                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="cadastroPrivacidade" id="cadastroPrivacidade" value="3">
                                                                            <label class="form-check-label" for="cadastroPrivacidade" value="3">Somente Criador</label>
                                                                        </div>

                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-9">

                                                                    <div class="col-8" style="display: inline-block;">
                                                                        <label for="VMDescricao" class="form-label">Descrição</label>
                                                                        <input name="VMDescricao" type="text" class="form-control" id="VMDescricao">
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-6" style="display: inline-block;">
                                                                            <label for="VMUsuario" class="form-label">Usuário</label>
                                                                            <input name="VMUsuario" type="text" class="form-control" id="VMUsuario">
                                                                        </div>

                                                                        <div class="col-6" style="display: inline-block;">
                                                                            <label for="VMSenha" class="form-label">Senha</label>
                                                                            <input name="VMSenha" type="text" class="form-control" id="VMSenha">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <hr class="sidebar-divider">

                                                            <div class="text-center">
                                                                <button class="btn btn-sm btn-danger" type="submit">Salvar</button>
                                                                <a href="/telecom/vault/vms/view.php?id=<?= $vm_id ?>"> <input type="button" value="Voltar" class="btn btn-sm btn-secondary"></input></a>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <br>
                    <div class="col-12">
                        <div class="accordion" id="accordionExample">
                            <?php
                            $sql_credenciais =
                                "SELECT
                                        cv.id as id_credencial,
                                        cv.vmdescricao as descricao,
                                        cv.vmusuario as vmusuario,
                                        cv.vmsenha as vmsenha,
                                        cv.privacidade as idPrivacidade,
                                        cv.usuario_id as usuarioCriador,
                                        CASE
                                            WHEN cv.privacidade = 1 THEN 'Público' 
                                            WHEN cv.privacidade = 2 THEN 'Privado'
                                            WHEN cv.privacidade = 3 THEN 'Somente Criador'
                                        END as privacidade,
                                        vm.ipaddress as ip
                                        FROM credenciais_vms as cv
                                        LEFT JOIN vms as vm ON vm.id = cv.vm_id
                                        WHERE cv.active = 1 and cv.vm_id = $vm_id";

                            $resultado_credenciais = mysqli_query($mysqli, $sql_credenciais)  or die("Erro ao retornar dados");
                            $cont = 1;

                            while ($campos = $resultado_credenciais->fetch_array()) {
                                $id_credencial = $campos['id_credencial'];
                                $idSessao = $_SESSION['id'];

                                if ($campos['idPrivacidade'] == '1') {
                                    require "lista_credenciais.php";    //Apresenta se a privacidade for publico
                                } else if ($campos['usuarioCriador'] == $idSessao) {
                                    require "lista_credenciais.php";    //Apresenta se o for do usuario criador
                                } else if ($campos['idPrivacidade'] == '3' && $campos['usuarioCriador'] == $idSessao) {
                                    require "lista_credenciais.php";    //Apresenta se a privacidade for somente eu e o usuario criador é o usuario logado
                                } else if ($campos['idPrivacidade'] == '2') {
                                    $sql_check_permissao_equipe =
                                        "SELECT *
                                        FROM credenciais_vms_privacidade_equipe as cpe
                                        WHERE
                                        cpe.credencial_id = $id_credencial AND 
                                        cpe.equipe_id IN ((SELECT ei.equipe_id as idEquipe
                                        FROM equipes_integrantes as ei
                                        WHERE ei.integrante_id = $idSessao))";

                                    $resultado_check_permissaoEquipe = mysqli_query($mysqli, $sql_check_permissao_equipe);
                                    $checkPermiEquipe = $resultado_check_permissaoEquipe->fetch_array();

                                    $sql_check_perm_user =
                                        "SELECT *
                                        FROM credenciais_vms_privacidade_usuario as cpu
                                        WHERE cpu.credencial_id = $id_credencial AND cpu.usuario_id = $idSessao";

                                    $r_check_perm_User = mysqli_query($mysqli, $sql_check_perm_user);
                                    $checkPermiUsuario = $r_check_perm_User->fetch_array();

                                    if (empty($checkPermiUsuario) && empty($checkPermiEquipe)) {
                                    } else {
                                        require "lista_credenciais.php";
                                    }
                                }

                                $cont++;
                            } ?>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
<?php
} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php";
?>