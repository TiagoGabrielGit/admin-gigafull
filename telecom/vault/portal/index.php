<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');


$submenu_id = "67";
$uid = $_SESSION['id'];
$empresa_usuario = $_SESSION['empresa_id'];

$permissions_submenu =
    "SELECT u.perfil_id 
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();
$permissao_portal = $_SESSION['permissao_portal'];

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if (($rowCount_permissions_submenu > 0) & ($permissao_portal != 0)) {

    if (empty($_POST['pesquisaTipo'])) {
        $_POST['pesquisaTipo'] = "%";
    }

    if (empty($_POST['empresaPesquisa'])) {
        if ($permissao_portal == 1) {
            $_POST['empresaPesquisa'] = $empresa_usuario;
        } else if ($permissao_portal == 2) {
            $_POST['empresaPesquisa'] = "%";
        }
    }


    if (empty($_POST['pesquisaDescricao'])) {
        $_POST['pesquisaDescricao'] = "%";
    }

    $varTipo = $_POST['pesquisaTipo'];
    $varEmpresa = $_POST['empresaPesquisa'];
    $varDescricao = $_POST['pesquisaDescricao'];

?>

    <style>
        /* CSS para mudar a cor de fundo da linha ao passar o mouse */
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
            /* Escolha a cor que desejar */
            cursor: pointer;
        }
    </style>

    <main class="main" id="main">
        <section class="section">
            <div class="card">
                <div class="card-body">

                    <div class="container">
                        <div class="row">
                            <div class="col-10">
                                <h5 class="card-title">Filtros</h5>
                            </div>

                            <div class="col-2">
                                <div class="card">
                                    <!-- Basic Modal -->
                                    <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalNovoPortal">
                                        Cadastrar novo
                                    </button>
                                </div>
                            </div>

                            <div class="modal fade" id="modalNovoPortal" tabindex="-1">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Novo cadastro</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card-body">

                                                <form method="POST" action="processa/add.php" class="row g-3">


                                                    <input name="usuarioCriador" type="text" class="form-control" id="usuarioCriador" value="<?php echo $_SESSION['id']; ?>" hidden>

                                                    <div class="col-6">
                                                        <label for="cadastroEmpresa" class="form-label">Empresa*</label>
                                                        <select id="cadastroEmpresa" name="cadastroEmpresa" class="form-select" required>
                                                            <option value="" selected disabled>Selecione a empresa</option>
                                                            <?php
                                                            if ($permissao_portal == 1) {
                                                                $sql_lista_empresas =
                                                                    "SELECT emp.id as id, emp.fantasia as empresa
    FROM empresas as emp
    WHERE emp.deleted = 1 AND id = $empresa_usuario
    ORDER BY emp.fantasia ASC";
                                                            } else if ($permissao_portal == 2) {
                                                                $sql_lista_empresas =
                                                                    "SELECT emp.id as id, emp.fantasia as empresa
        FROM empresas as emp
        WHERE emp.deleted = 1
        ORDER BY emp.fantasia ASC";
                                                            }
                                                            $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                                            while ($empresa = mysqli_fetch_object($resultado)) :
                                                                echo "<option value='$empresa->id'> $empresa->empresa</option>";
                                                            endwhile;
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-3">
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
                                                            <label class="form-check-label" for="cadastroPrivacidade" value="3">Somente eu</label>
                                                        </div>
                                                    </div>

                                                    <hr class="sidebar-divider">

                                                    <div class="col-lg-12">
                                                        <div class="col-6">
                                                            <label for="portalDescricao" class="form-label">Descrição</label>
                                                            <input name="portalDescricao" type="text" class="form-control" id="portalDescricao" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <label for="portalPaginaAcesso" class="form-label">Página de Acesso</label>
                                                                <input name="portalPaginaAcesso" type="text" class="form-control" id="portalPaginaAcesso" required>
                                                            </div>

                                                            <div class="col-4">
                                                                <label for="portalUsuario" class="form-label">Usuário</label>
                                                                <input name="portalUsuario" type="text" class="form-control" id="portalUsuario" required>
                                                            </div>

                                                            <div class="col-4">
                                                                <label for="portalSenha" class="form-label">Senha</label>
                                                                <input name="portalSenha" type="text" class="form-control" id="portalSenha" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="portalAnotacao" class="form-label">Anotações</label>
                                                        <textarea id="portalAnotacao" name="portalAnotacao" class="form-control" maxlength="10000" rows="4"></textarea>
                                                    </div>

                                                    <hr class="sidebar-divider">

                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-danger">Salvar</button>
                                                        <a href="/telecom/vault/portal/index.php"> <input type="button" value="Voltar" class="btn btn-secondary"></input></a>
                                                    </div>
                                                </form><!-- Vertical Form -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Basic Modal-->
                        </div>
                    </div>

                    <form method="POST" action="#" class="row g-3">
                        <input type="hidden" id="tabportal" name="tabportal">
                        <div class="col-4">
                            <label for="empresaPesquisa" class="form-label">Empresa</label>
                            <select id="empresaPesquisa" name="empresaPesquisa" class="form-select">
                                <option value="%" <?php echo ($_POST['empresaPesquisa'] == '%') ? 'selected' : ''; ?>>Todas</option>
                                <?php
                                $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                while ($empresa = mysqli_fetch_object($resultado)) :
                                    $selected = ($_POST['empresaPesquisa'] == $empresa->id) ? 'selected' : '';
                                    echo "<option value='$empresa->id' $selected> $empresa->empresa</option>";
                                endwhile;
                                ?>
                            </select>
                        </div>

                        <div class="col-4">
                            <label for="pesquisaDescricao" class="form-label">Descrição</label>
                            <input name="pesquisaDescricao" type="text" class="form-control" id="pesquisaDescricao" <?php echo ($_POST['pesquisaDescricao'] !== '%') ? 'value="' . $_POST['pesquisaDescricao'] . '"' : ''; ?>>
                        </div>

                        <div class="text-center">
                            <button style="margin-top: 15px; " type="submit" class="btn btn-danger">Filtrar</button>
                        </div>
                    </form>
                    <hr class="sidebar-divider">

                    <table class="table table-striped  table-hover">
                        <thead>
                            <tr onclick="window.location.href='view.php?id=<?= $id ?>'">
                                <th style="text-align: center;" scope="col">Descrição</th>
                                <th style="text-align: center;" scope="col">Empresa</th>
                                <th style="text-align: center;" scope="col">Usuário</th>
                                <th style="text-align: center;" scope="col">Privacidade</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $sql_pesquisa_portal =
                                ("SELECT
emp.fantasia as emp_fant,
portal.id as cred_id,
portal.privacidade as idPrivacidade, 
portal.usuario_id as usuarioCriador,
CASE
    WHEN portal.tipo = 'portal' THEN 'Portal'
END as cred_tipo,
portal.portaldescricao as cred_desc,
portal.portalusuario as cred_usuario,
CASE
    WHEN portal.privacidade = 1 THEN 'Público'
    WHEN portal.privacidade = 2 THEN 'Privado'
    WHEN portal.privacidade = 3 THEN 'Somente eu'
END as cred_priv
FROM credenciais_portal as portal
LEFT JOIN empresas as emp ON portal.empresa_id = emp.id
WHERE
portal.tipo LIKE '$varTipo' and 
portal.empresa_id LIKE '$varEmpresa' and 
portal.portaldescricao LIKE '%$varDescricao%'");


                            $resultado_portal = mysqli_query($mysqli, $sql_pesquisa_portal) or die("Erro ao retornar dados");

                            while ($campos_portal = $resultado_portal->fetch_array()) {
                                $id = $campos_portal['cred_id'];
                                $id_credencial = $campos_portal['cred_id'];
                                $idSessao = $_SESSION['id'];

                                if ($campos_portal['idPrivacidade'] == '1') { ?>
                                    <!--Apresenta se a privacidade for publico-->
                                    <tr onclick="window.location.href='view.php?id=<?= $id ?>'">
                                        <td style="text-align: center;"><?= $campos_portal['cred_desc']; ?></td>
                                        <td style="text-align: center;"><?= $campos_portal['emp_fant'] ?></td>
                                        <td style="text-align: center;"><?= $campos_portal['cred_usuario'] ?></td>
                                        <td style="text-align: center;"><?= $campos_portal['cred_priv'] ?></td>
                                    </tr>
                                <?php } else if ($campos_portal['usuarioCriador'] == $idSessao) { ?>
                                    <!--Apresenta se o for do usuario criador-->
                                    <tr onclick="window.location.href='view.php?id=<?= $id ?>'">
                                        <td style="text-align: center;"><?= $campos_portal['cred_desc']; ?></td>
                                        <td style="text-align: center;"><?= $campos_portal['emp_fant'] ?></td>
                                        <td style="text-align: center;"><?= $campos_portal['cred_usuario'] ?></td>
                                        <td style="text-align: center;"><?= $campos_portal['cred_priv'] ?></td>
                                    </tr>
                                <?php } else if ($campos_portal['idPrivacidade'] == '3' && $campos_portal['usuarioCriador'] == $idSessao) {  ?>
                                    <!--Apresenta se a privacidade for somente eu e o usuario criador é o usuario logado-->
                                    <tr onclick="window.location.href='view.php?id=<?= $id ?>'">
                                        <td style="text-align: center;"><?= $campos_portal['cred_desc']; ?></td>
                                        <td style="text-align: center;"><?= $campos_portal['emp_fant'] ?></td>
                                        <td style="text-align: center;"><?= $campos_portal['cred_usuario'] ?></td>
                                        <td style="text-align: center;"><?= $campos_portal['cred_priv'] ?></td>
                                    </tr>
                                    <?php } else if ($campos_portal['idPrivacidade'] == '2') {
                                    $sql_check_permissao_equipe =
                                        "SELECT *
                                        FROM credenciais_portal_privacidade_equipe as cpe
                                        WHERE cpe.credencial_id = $id_credencial
                                        AND cpe.equipe_id IN ((SELECT ei.equipe_id as idEquipe
                                        FROM equipes_integrantes as ei
                                        WHERE ei.integrante_id = $idSessao))";

                                    $resultado_check_permissao = mysqli_query($mysqli, $sql_check_permissao_equipe);
                                    $checkPermiEquipe = $resultado_check_permissao->fetch_array();

                                    $sql_check_perm_user =
                                        "SELECT * 
                                        FROM credenciais_portal_privacidade_usuario as cpu
                                        WHERE cpu.credencial_id = $id_credencial AND cpu.usuario_id = $idSessao";

                                    $r_check_perm_User = mysqli_query($mysqli, $sql_check_perm_user);
                                    $checkPermiUsuario = $r_check_perm_User->fetch_array();

                                    if (empty($checkPermiUsuario) && empty($checkPermiEquipe)) { //Apresenta se a privacidade for privada e der match em alguma equipe do usuario
                                    } else { ?>
                                        <tr onclick="window.location.href='view.php?id=<?= $id ?>'">
                                            <td style="text-align: center;"><?= $campos_portal['cred_desc']; ?></td>
                                            <td style="text-align: center;"><?= $campos_portal['emp_fant'] ?></td>
                                            <td style="text-align: center;"><?= $campos_portal['cred_usuario'] ?></td>
                                            <td style="text-align: center;"><?= $campos_portal['cred_priv'] ?></td>
                                        </tr>
                            <?php }
                                }
                            } ?>

                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </section>
    </main>
<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>