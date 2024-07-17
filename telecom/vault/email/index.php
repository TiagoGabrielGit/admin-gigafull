<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');


$submenu_id = "66";
$uid = $_SESSION['id'];
$empresa_usuario = $_SESSION['empresa_id'];

$permissions_submenu =
    "SELECT u.perfil_id 
    FROM usuarios u 
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();
$permissao_email = $_SESSION['permissao_email'];

if (($rowCount_permissions_submenu > 0) & ($permissao_email != 0)) {
    if (empty($_POST['pesquisaTipo'])) {
        $_POST['pesquisaTipo'] = "%";
    }

    if (empty($_POST['empresaPesquisa'])) {
        if ($permissao_email == 1) {
            $_POST['empresaPesquisa'] = $empresa_usuario;
        } else if ($permissao_email == 2) {
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
            <div class="row">
                <div class="col-lg-12">

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
                                            <button style="margin-top: 15px" type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalNovoEmail">
                                                Cadastrar novo
                                            </button>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="modalNovoEmail" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Novo cadastro</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card-body">

                                                        <!-- Vertical Form -->
                                                        <form action="processa/add.php" method="POST" class="row g-3">

                                                            <input name="usuarioCriador" type="text" class="form-control" id="usuarioCriador" value="<?php echo $_SESSION['id']; ?>" hidden>

                                                            <div class="col-6">
                                                                <label for="cadastroEmpresa" class="form-label">Empresa*</label>
                                                                <select id="cadastroEmpresa" name="cadastroEmpresa" class="form-select" required>
                                                                    <option value="" selected disabled>Selecione a empresa</option>
                                                                    <?php
  if ($permissao_email == 1) {
    $sql_lista_empresas =
        "SELECT emp.id as id, emp.fantasia as empresa
    FROM empresas as emp
    WHERE emp.deleted = 1 AND id = $empresa_usuario
    ORDER BY emp.fantasia ASC";
} else if ($permissao_email == 2) {
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



                                                            <div class="col-8" style="display: inline-block;">
                                                                <label for="acessoWebmail" class="form-label">Webmail</label>
                                                                <input name="acessoWebmail" type="text" class="form-control" id="acessoWebmail">
                                                            </div>

                                                            <div class="col-6" style="display: inline-block;">
                                                                <label for="emailDescricao" class="form-label">Descrição</label>
                                                                <input name="emailDescricao" type="text" class="form-control" id="emailDescricao">
                                                            </div>

                                                            <div class="col-4" style="display: inline-block;"> </div>

                                                            <div class="col-6" style="display: inline-block;">
                                                                <label for="emailUsuario" class="form-label">E-mail</label>
                                                                <input name="emailUsuario" type="text" class="form-control" id="emailUsuario">
                                                            </div>

                                                            <div class="col-5" style="display: inline-block;">
                                                                <label for="emailSenha" class="form-label">Senha</label>
                                                                <input name="emailSenha" type="text" class="form-control" id="emailSenha">
                                                            </div>

                                                            <div class="col-12">
                                                                <label for="emailAnotacao" class="form-label">Anotações</label>
                                                                <textarea id="emailAnotacao" name="emailAnotacao" class="form-control" maxlength="10000" rows="4"></textarea>
                                                            </div>

                                                            <hr class="sidebar-divider">

                                                            <div class="text-center">
                                                                <button class="btn btn-sm btn-danger" type="submit">Salvar</button>

                                                                <a href="/telecom/vault/email/index.php"> <input type="button" value="Voltar" class="btn btn-sm btn-secondary"></input></a>
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

                                <input type="hidden" id="tabemail" name="tabemail">

                                <div class="col-4">
                                    <label for="empresaPesquisa" class="form-label">Empresa</label>
                                    <select id="empresaPesquisa" name="empresaPesquisa" class="form-select">
                                        <option value="%" selected>Todas</option>
                                        <?php
                                        $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                        while ($empresa = mysqli_fetch_object($resultado)) :
                                            echo "<option value='$empresa->id'> $empresa->empresa</option>";
                                        endwhile;

                                        if ($_SERVER["REQUEST_METHOD"] == 'POST') :

                                        ?>
                                            <script>
                                                let nomeEmpresa = '<?= $_POST['empresaPesquisa']; ?>'
                                                if (nomeEmpresa == '%') {} else {
                                                    document.querySelector("#empresaPesquisa").value = nomeEmpresa
                                                }
                                            </script>
                                        <?php
                                        endif;
                                        ?>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="pesquisaDescricao" class="form-label">Descrição</label>
                                    <input name="pesquisaDescricao" type="text" class="form-control" id="pesquisaDescricao">
                                    <?php
                                    if ($_SERVER["REQUEST_METHOD"] == 'POST') :
                                    ?>
                                        <script>
                                            let pesquisaDescricao = '<?= $_POST['pesquisaDescricao']; ?>'
                                            if (pesquisaDescricao == '%') {} else {
                                                document.querySelector("#pesquisaDescricao").value = pesquisaDescricao
                                            }
                                        </script>
                                    <?php
                                    endif;
                                    ?>
                                </div>

                                <div class="text-center">
                                    <button style="margin-top: 15px; " type="submit" class="btn btn-danger">Filtrar</button>
                                </div>

                            </form>

                            <hr class="sidebar-divider">

                            <table class="table table-striped  table-hover">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;" scope="col">Descrição</th>
                                        <th style="text-align: center;" scope="col">Empresa</th>
                                        <th style="text-align: center;" scope="col">Usuário</th>
                                        <th style="text-align: center;" scope="col">Privacidade</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $sql_pesquisa_email =
                                        ("SELECT
                                        emp.fantasia as emp_fant,
                                        email.id as cred_id,
                                        CASE
                                            WHEN email.tipo = 'email' THEN 'E-mail'
                                        END as cred_tipo,
                                        email.emaildescricao as cred_desc,
                                        email.emailusuario as cred_usuario,
                                        email.privacidade as idPrivacidade,
                                        email.usuario_id as usuarioCriador,
                                        CASE
                                            WHEN email.privacidade = 1 THEN 'Público'
                                            WHEN email.privacidade = 2 THEN 'Privado'
                                            WHEN email.privacidade = 3 THEN 'Somente eu'
                                        END as cred_priv
                                        FROM credenciais_email as email
                                        LEFT JOIN empresas as emp ON email.empresa_id = emp.id
                                        WHERE email.tipo LIKE '$varTipo' and email.empresa_id LIKE '$varEmpresa' and email.emaildescricao LIKE '%$varDescricao%'");

                                    $resultado_email = mysqli_query($mysqli, $sql_pesquisa_email) or die("Erro ao retornar dados");

                                    while ($campos_email = $resultado_email->fetch_array()) {
                                        $id = $campos_email['cred_id'];
                                        $id_credencial = $campos_email['cred_id'];
                                        $idSessao = $_SESSION['id'];


                                        if ($campos_email['idPrivacidade'] == '1') { ?>
                                            <!--Apresenta se a privacidade for publico-->
                                            <tr onclick="window.location.href='view.php?id=<?= $id ?>'">
                                                <td style="text-align: center;"><?= $campos_email['cred_desc']; ?></td>
                                                <td style="text-align: center;"><?= $campos_email['emp_fant'] ?></td>
                                                <td style="text-align: center;"><?= $campos_email['cred_usuario'] ?></td>
                                                <td style="text-align: center;"><?= $campos_email['cred_priv'] ?></td>
                                            </tr>
                                        <?php } else if ($campos_email['usuarioCriador'] == $idSessao) { ?>
                                            <!--Apresenta se o for do usuario criador-->
                                            <tr onclick="window.location.href='view.php?id=<?= $id ?>'">
                                                <td style="text-align: center;"><?= $campos_email['cred_desc']; ?></td>
                                                <td style="text-align: center;"><?= $campos_email['emp_fant'] ?></td>
                                                <td style="text-align: center;"><?= $campos_email['cred_usuario'] ?></td>
                                                <td style="text-align: center;"><?= $campos_email['cred_priv'] ?></td>
                                            </tr>
                                        <?php } else if ($campos_email['idPrivacidade'] == '3' && $campos_email['usuarioCriador'] == $idSessao) {  ?>
                                            <!--Apresenta se a privacidade for somente eu e o usuario criador é o usuario logado-->
                                            <tr onclick="window.location.href='view.php?id=<?= $id ?>'">

                                                <td style="text-align: center;"><?= $campos_email['cred_desc']; ?></td>

                                                <td style="text-align: center;"><?= $campos_email['emp_fant'] ?></td>
                                                <td style="text-align: center;"><?= $campos_email['cred_usuario'] ?></td>
                                                <td style="text-align: center;"><?= $campos_email['cred_priv'] ?></td>
                                            </tr>
                                            <?php } else if ($campos_email['idPrivacidade'] == '2') {
                                            $sql_check_permissao_equipe =
                                                "SELECT *
                                                FROM credenciais_email_privacidade_equipe as cpe
                                                WHERE cpe.credencial_id = $id_credencial AND 
                                                cpe.equipe_id IN ((SELECT ei.equipe_id as idEquipe
                                                FROM equipes_integrantes as ei
                                                WHERE ei.integrante_id = $idSessao))";

                                            $resultado_check_permissao = mysqli_query($mysqli, $sql_check_permissao_equipe);
                                            $checkPermiEquipe = $resultado_check_permissao->fetch_array();

                                            $sql_check_perm_user =
                                                "SELECT *
                                                FROM credenciais_email_privacidade_usuario as cpu
                                                WHERE cpu.credencial_id = $id_credencial AND 
                                                cpu.usuario_id = $idSessao";

                                            $r_check_perm_User = mysqli_query($mysqli, $sql_check_perm_user);
                                            $checkPermiUsuario = $r_check_perm_User->fetch_array();

                                            if (empty($checkPermiUsuario) && empty($checkPermiEquipe)) { //Apresenta se a privacidade for privada e der match em alguma equipe do usuario
                                            } else { ?>
                                                <tr onclick="window.location.href='view.php?id=<?= $id ?>'">
                                                    <td style="text-align: center;"><?= $campos_email['cred_desc']; ?></td>

                                                    <td style="text-align: center;"><?= $campos_email['emp_fant'] ?></td>
                                                    <td style="text-align: center;"><?= $campos_email['cred_usuario'] ?></td>
                                                    <td style="text-align: center;"><?= $campos_email['cred_priv'] ?></td>
                                                </tr>
                                    <?php }
                                        }
                                    }
                                    ?>

                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>

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