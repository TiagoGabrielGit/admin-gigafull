<?php
require "../../includes/menu.php";
require "../../includes/remove_setas_number.php";

$usuarioID = $_GET['id'];

$sql_usuario =
    "SELECT u.id as idUsuario,
    u.url_dashboard as url_dashboard,
CASE
    WHEN u.notify_email = 1 THEN 'Ativado'
    WHEN u.notify_email = 0 THEN 'Inativado'
END AS notify_email,
CASE
    WHEN u.notify_telegram = 1 THEN 'Ativado'
    WHEN u.notify_telegram = 0 THEN 'Inativado'
    WHEN u.notify_telegram IS NULL THEN 'Inativado'
END AS notify_telegram,
u.chatIdTelegram as chatIdTelegram,
u.tipo_usuario as tipoUsuario, p.nome as nome, p.email as email, pf.perfil as perfil, p.email as usuario, e.fantasia as empresa, e.atributoEmpresaPropria as EmpresaPropria
FROM usuarios as u
LEFT JOIN pessoas as p ON p.id = u.pessoa_id
LEFT JOIN perfil as pf ON pf.id = u.perfil_id
LEFT JOIN empresas as e ON e.id = u.empresa_id
WHERE u.id = $usuarioID";

$r_usuario = mysqli_query($mysqli, $sql_usuario);
$campos = $r_usuario->fetch_array();

$log_acesso =
    "SELECT ip_address, horario, id
FROM log_acesso
WHERE usuario_id = $usuarioID
ORDER BY horario DESC
LIMIT 10";

$r_log = mysqli_query($mysqli, $log_acesso);

if ($campos['notify_email'] == "Ativado") {
    $checkNotifEmail1 = "checked";
    $checkNotifEmail0 = "";
} else if ($campos['notify_email'] == "Inativado") {
    $checkNotifEmail0 = "checked";
    $checkNotifEmail1 = "";
}

if ($campos['notify_telegram'] == "Ativado") {
    $checkNotificaTelegram1 = "checked";
    $checkNotificaTelegram0 = "";
} else if ($campos['notify_telegram'] == "Inativado") {
    $checkNotificaTelegram0 = "checked";
    $checkNotificaTelegram1 = "";
}

$request_colaborador =
    "SELECT
    'Plantão' as requisicao,
    CASE
    WHEN crp.status = 1 THEN 'Em análise'
    WHEN crp.status = 2 THEN 'Recusado'
    WHEN crp.status = 3 THEN 'Aprovado'
    END as status
    FROM
    colaborador_request_plantao as crp
    WHERE
    crp.user_id = $usuarioID
    ORDER BY
    crp.id DESC";

$r_request_colaborador = mysqli_query($mysqli, $request_colaborador);

$horarioTrabalho = "SELECT * FROM colaborador_horario WHERE user_id = $usuarioID";
$r_horarioTrabalho = mysqli_query($mysqli, $horarioTrabalho);
$c_horarioTrabalho = $r_horarioTrabalho->fetch_array();

$sql_gerente = "SELECT p.nome as 'gerente' FROM colaborador_gerencia as cg LEFT JOIN usuarios as u ON cg.gerente_id = u.id LEFT JOIN pessoas as p ON u.pessoa_id = p.id WHERE cg.user_id = $usuarioID";
$r_gerente = mysqli_query($mysqli, $sql_gerente);
$c_gerente = $r_gerente->fetch_array();
if (empty($c_gerente['gerente'])) {
    $gerente = "";
} else {
    $gerente = $c_gerente['gerente'];
}

$sql_coordenador = "SELECT p.nome as 'coordenador' FROM colaborador_gerencia as cg LEFT JOIN usuarios as u ON cg.coordenador_id = u.id LEFT JOIN pessoas as p ON u.pessoa_id = p.id WHERE cg.user_id = $usuarioID";
$r_coordenador = mysqli_query($mysqli, $sql_coordenador);
$c_coordenador = $r_coordenador->fetch_array();
if (empty($c_coordenador['coordenador'])) {
    $coordenador = "";
} else {
    $coordenador = $c_coordenador['coordenador'];
}

if (isset($_GET['tab'])) {
    if ($_GET['tab'] == "altPass") {
        $nav_info = "";
        $tab_info = "";
        $nav_comp = "";
        $tab_comp = "";
        $nav_colab = "";
        $tab_colab = "";
        $nav_altPass = "active";
        $tab_altPass = "show active";
        $nav_log = "";
        $tab_log = "";
    }
} else {
    $nav_info = "active";
    $tab_info = "show active";
    $nav_comp = "";
    $tab_comp = "";
    $nav_colab = "";
    $tab_colab = "";
    $nav_altPass = "";
    $tab_altPass = "";
    $nav_log = "";
    $tab_log = "";
}

?>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <hr class="sidebar-divider">
                        <div class="col-lg-12">
                            <span><b><?= $campos['nome']; ?></b></span>
                        </div>


                        <div class="row g-3">

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?= $nav_info ?>" id="infos-tab" data-bs-toggle="tab" data-bs-target="#infos" type="button" role="tab" aria-controls="infos" aria-selected="true">Informações</button>
                                </li>
                                <?php if ($campos['EmpresaPropria'] == 1) { ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?= $nav_comp ?>" id="competencia-tab" data-bs-toggle="tab" data-bs-target="#competencia" type="button" role="tab" aria-controls="competencia" aria-selected="false" tabindex="-1">Competências</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?= $nav_colab ?>" id="colaborador-tab" data-bs-toggle="tab" data-bs-target="#colaborador" type="button" role="tab" aria-controls="colaborador" aria-selected="false" tabindex="-1">Colaborador</button>
                                    </li>
                                <?php } ?>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?= $nav_altPass ?>" id="senha-tab" data-bs-toggle="tab" data-bs-target="#senha" type="button" role="tab" aria-controls="senha" aria-selected="false" tabindex="-1">Alterar Senha</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?= $nav_log ?>" id="log-tab" data-bs-toggle="tab" data-bs-target="#log" type="button" role="tab" aria-controls="log" aria-selected="false" tabindex="-1">LOGs Acesso</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2" id="myTabContent">
                                <div class="tab-pane fade <?= $tab_info ?>" id="infos" role="tabpanel" aria-labelledby="infos-tab">
                                    <?php require "profile_tabs/infos.php" ?>
                                </div>
                                <?php if ($campos['EmpresaPropria'] == 1) { ?>
                                    <div class="tab-pane fade <?= $tab_comp ?>" id="competencia" role="tabpanel" aria-labelledby="competencia-tab">
                                        <?php require "profile_tabs/competencia.php" ?>
                                    </div>
                                    <div class="tab-pane fade <?= $tab_colab ?>" id="colaborador" role="tabpanel" aria-labelledby="colaborador-tab">
                                        <?php require "profile_tabs/colaborador.php" ?>
                                    </div>

                                <?php } ?>

                                <div class="tab-pane fade <?= $tab_altPass ?>" id="senha" role="tabpanel" aria-labelledby="senha-tab">
                                    <?php require "profile_tabs/altera_senha.php" ?>
                                </div>

                                <div class="tab-pane fade <?= $tab_log ?>" id="log" role="tabpanel" aria-labelledby="log-tab">
                                    <?php require "profile_tabs/logs.php" ?>
                                </div>
                            </div><!-- End Default Tabs -->



                            <hr class="sidebar-divider">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
require "js_profile.php";
require "../../includes/footer.php";
?>