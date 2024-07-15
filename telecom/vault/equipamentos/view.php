<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$submenu_id = "65";
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
    $equipamento_id = $_GET['id'];

    $sql_sql_equipamentopop =
        "SELECT
        emp.id as idEmpresa,
        emp.fantasia as empresa,
        pop.pop as pop,
        eqpop.hostname as hostname,
        fab.fabricante as fabricante,
        eqp.equipamento as modelo,
        eqpop.ipaddress as ip
        FROM equipamentospop as eqpop
        LEFT JOIN empresas as emp ON emp.id = eqpop.empresa_id
        LEFT JOIN pop as pop ON pop.id = eqpop.pop_id
        LEFT JOIN equipamentos as eqp ON eqp.id = eqpop.equipamento_id
        LEFT JOIN fabricante as fab ON fab.id = eqp.fabricante
        LEFT JOIN tipoequipamento as tipo ON tipo.id = eqpop.tipoEquipamento_id
        WHERE eqpop.id = '$equipamento_id'";

    $resultado = mysqli_query($mysqli, $sql_sql_equipamentopop);
    $row = mysqli_fetch_assoc($resultado);

?>

    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Equipamentos POP</h5>

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
                            <label class="form-label">Fabricante</label>
                            <input readonly disabled class="form-control" value="<?= $row['fabricante'] ?>">
                        </div>

                        <div class="col-3">
                            <label class="form-label">Modelo</label>
                            <input readonly disabled class="form-control" value="<?= $row['modelo'] ?>">
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

                            <button data-bs-toggle="modal" data-bs-target="#AddSenhaEquipamento" type="button" class="btn btn-info">Adicionar Credencial</button>

                            <div class="modal fade" id="AddSenhaEquipamento" tabindex="-1">
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

                                                            <input name="idEquipamento" class="form-control" id="idEquipamento" hidden value="<?= $equipamento_id ?>">
                                                            <input name="idEmpresa" class="form-control" id="idEmpresa" hidden value="<?= $row['idEmpresa'] ?>">
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
                                                                        <label for="equipamentoDescricao" class="form-label">Descrição</label>
                                                                        <input name="equipamentoDescricao" type="text" class="form-control" id="equipamentoDescricao">
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-6" style="display: inline-block;">
                                                                            <label for="equipamentoUsuario" class="form-label">Usuário</label>
                                                                            <input name="equipamentoUsuario" type="text" class="form-control" id="equipamentoUsuario">
                                                                        </div>

                                                                        <div class="col-6" style="display: inline-block;">
                                                                            <label for="equipamentoSenha" class="form-label">Senha</label>
                                                                            <input name="equipamentoSenha" type="text" class="form-control" id="equipamentoSenha">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <hr class="sidebar-divider">

                                                            <div class="text-center">
                                                                <button class="btn btn-sm btn-danger" type="submit">Salvar</button>
                                                                <a href="/telecom/vault/equipamentos/view.php?id=<?= $equipamento_id ?>"> <input type="button" value="Voltar" class="btn btn-sm btn-secondary"></input></a>
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
                                        ce.id as id_credencial,
                                        ce.equipamentodescricao as descricao,
                                        ce.equipamentousuario as eqpuser,
                                        ce.equipamentosenha as eqpsenha,
                                        ce.privacidade as idPrivacidade,
                                        ce.usuario_id as usuarioCriador,
                                        CASE
                                            WHEN ce.privacidade = 1 THEN 'Público' 
                                            WHEN ce.privacidade = 2 THEN 'Privado'
                                            WHEN ce.privacidade = 3 THEN 'Somente Criador'
                                        END as privacidade,
                                        e.ipaddress as ip
                                        FROM credenciais_equipamento as ce
                                        LEFT JOIN equipamentospop as e ON e.id = ce.equipamento_id
                                        WHERE ce.active = 1 and ce.equipamento_id = $equipamento_id";

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
                                        FROM credenciais_privacidade_equipe as cpe
                                        WHERE
                                        cpe.credencial_id = $id_credencial AND 
                                        cpe.equipe_id IN ((SELECT ei.equipe_id as idEquipe
                                        FROM equipes_integrantes as ei
                                        WHERE ei.integrante_id = $idSessao))";

                                    $resultado_check_permissaoEquipe = mysqli_query($mysqli, $sql_check_permissao_equipe);
                                    $checkPermiEquipe = $resultado_check_permissaoEquipe->fetch_array();

                                    $sql_check_perm_user =
                                        "SELECT *
                                        FROM credenciais_privacidade_usuario as cpu
                                        WHERE cpu.credencial_id = $id_credencial AND cpu.usuario_id = $idSessao";

                                    $r_check_perm_User = mysqli_query($mysqli, $sql_check_perm_user);
                                    $checkPermiUsuario = $r_check_perm_User->fetch_array();

                                    if (empty($checkPermiUsuario) && empty($checkPermiEquipe)) {
                                    } else {
                                        require "lista_credenciais.php"; //Apresenta se a privacidade for privada e der match em alguma equipe do usuario
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