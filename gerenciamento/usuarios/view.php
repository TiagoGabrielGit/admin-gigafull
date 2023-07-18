<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";
?>

<?php
$idUsuario = $_GET['id'];

$sql_usuario =
    "SELECT 
user.id as id,
pess.nome as nome,
user.tipo_usuario as tipoUsuario,
CASE
    WHEN user.tipo_usuario = 1 THEN 'Smart'
    WHEN user.tipo_usuario = 2 THEN 'Cliente'
    WHEN user.tipo_usuario = 3 THEN 'Tenant'
END as tipo,
pess.email as email,
user.senha as senha,
user.perfil_id as idPerfil,
user.permissao_chamado as 'permissao_abertura_chamado',
user.permissao_visualiza_chamado as 'permissao_visualiza_chamado',
user.permissao_abrir_chamado as 'permissao_abrir_chamado',
user.permissao_apropriar_chamado as 'permissao_apropriar_chamado',
user.permissao_encaminhar_chamado as 'permissao_encaminhar_chamado',
user.permissao_interessados_chamados as 'permissao_interessados_chamados',
user.permissao_selecionar_competencias as 'permissao_selecionar_competencias',
user.permissao_selecionar_solicitante as 'permissao_selecionar_solicitante',
user.permissao_selecionar_atendente as 'permissao_selecionar_atendente',
user.notify_email_abertura as 'notify_email_abertura',
user.notify_email_encaminhamento as 'notify_email_encaminhamento',
user.notify_email_relatos as 'notify_email_relatos',
user.notify_email_apropriacao as 'notify_email_apropriacao',
user.notify_email_execucao as 'notify_email_execucao',
user.permissao_privacidade_credenciais as 'permissao_privacidade_credenciais',
p.perfil as nome_perfil,
CASE
    WHEN user.active = 1 THEN 'Ativado'
    WHEN user.active = 0 THEN 'Inativado'
END AS active,
CASE
    WHEN user.notify_email = 1 THEN 'Ativado'
    WHEN user.notify_email = 0 THEN 'Inativado'
END AS notify_email
FROM 
usuarios as user
LEFT JOIN                            
pessoas as pess
ON
pess.id = user.pessoa_id
LEFT JOIN
perfil as p
ON
p.id = user.perfil_id
WHERE
user.id = $idUsuario";

$r_sql_usuario = mysqli_query($mysqli, $sql_usuario) or die("Erro ao retornar dados");
$campos = $r_sql_usuario->fetch_array();

$sql_perfil =
    "SELECT
p.id as idPerfil,
p.perfil as perfil
FROM
perfil as p
WHERE
p.active = 1";

$horarioColaborador = "SELECT * FROM colaborador_horario WHERE user_id = $idUsuario";
$r_horarioColaborador = $pdo->query($horarioColaborador);
if ($r_horarioColaborador->rowCount() > 0) {
    // Existem registros para o user_id
    $row = $r_horarioColaborador->fetch(PDO::FETCH_ASSOC);

    // Preencha os campos do formulário com os valores do banco de dados
    $seg_ini_p1 = $row['seg_ini_p1'];
    $seg_fim_p1 = $row['seg_fim_p1'];
    $seg_ini_p2 = $row['seg_ini_p2'];
    $seg_fim_p2 = $row['seg_fim_p2'];

    $ter_ini_p1 = $row['ter_ini_p1'];
    $ter_fim_p1 = $row['ter_fim_p1'];
    $ter_ini_p2 = $row['ter_ini_p2'];
    $ter_fim_p2 = $row['ter_fim_p2'];

    $qua_ini_p1 = $row['qua_ini_p1'];
    $qua_fim_p1 = $row['qua_fim_p1'];
    $qua_ini_p2 = $row['qua_ini_p2'];
    $qua_fim_p2 = $row['qua_fim_p2'];

    $qui_ini_p1 = $row['qui_ini_p1'];
    $qui_fim_p1 = $row['qui_fim_p1'];
    $qui_ini_p2 = $row['qui_ini_p2'];
    $qui_fim_p2 = $row['qui_fim_p2'];

    $sex_ini_p1 = $row['sex_ini_p1'];
    $sex_fim_p1 = $row['sex_fim_p1'];
    $sex_ini_p2 = $row['sex_ini_p2'];
    $sex_fim_p2 = $row['sex_fim_p2'];

    $sab_ini_p1 = $row['sab_ini_p1'];
    $sab_fim_p1 = $row['sab_fim_p1'];
    $sab_ini_p2 = $row['sab_ini_p2'];
    $sab_fim_p2 = $row['sab_fim_p2'];

    $dom_ini_p1 = $row['dom_ini_p1'];
    $dom_fim_p1 = $row['dom_fim_p1'];
    $dom_ini_p2 = $row['dom_ini_p2'];
    $dom_fim_p2 = $row['dom_fim_p2'];
} else {
    $seg_ini_p1 = "";
    $seg_fim_p1 = "";
    $seg_ini_p2 = "";
    $seg_fim_p2 = "";

    $ter_ini_p1 = "";
    $ter_fim_p1 = "";
    $ter_ini_p2 = "";
    $ter_fim_p2 = "";

    $qua_ini_p1 = "";
    $qua_fim_p1 = "";
    $qua_ini_p2 = "";
    $qua_fim_p2 = "";

    $qui_ini_p1 = "";
    $qui_fim_p1 = "";
    $qui_ini_p2 = "";
    $qui_fim_p2 = "";

    $sex_ini_p1 = "";
    $sex_fim_p1 = "";
    $sex_ini_p2 = "";
    $sex_fim_p2 = "";

    $sab_ini_p1 = "";
    $sab_fim_p1 = "";
    $sab_ini_p2 = "";
    $sab_fim_p2 = "";

    $dom_ini_p1 = "";
    $dom_fim_p1 = "";
    $dom_ini_p2 = "";
    $dom_fim_p2 = "";
}

$gerenteColaborador = "SELECT p.nome as 'gerente', u.id as 'usuario'FROM colaborador_gerencia as cg LEFT JOIN usuarios as u ON u.id = cg.gerente_id LEFT JOIN pessoas as p ON p.id = u.pessoa_id WHERE user_id  = $idUsuario";
$r_gerenteColaborador = $pdo->query($gerenteColaborador);
if ($r_gerenteColaborador->rowCount() > 0) {
    $rowGerente = $r_gerenteColaborador->fetch(PDO::FETCH_ASSOC);

    $gerente = $rowGerente['gerente'];
    $usuarioGerente = $rowGerente['usuario'];

    if ($usuarioGerente <> null) {
        $opcaoGerente = '<option value="' . $usuarioGerente . '" selected="">' . $gerente . '</option>';
    } else {
        $opcaoGerente = '<option value="" disabled selected="">Selecione...</option>';
    }
} else {
    $opcaoGerente = '<option value="" disabled selected="">Selecione...</option>';
}

$coordenadorColaborador = "SELECT p.nome as 'coordenador', u.id as 'usuario'FROM colaborador_gerencia as cg LEFT JOIN usuarios as u ON u.id = cg.coordenador_id LEFT JOIN pessoas as p ON p.id = u.pessoa_id WHERE user_id  = $idUsuario";
$r_coordenadorColaborador = $pdo->query($coordenadorColaborador);
if ($r_coordenadorColaborador->rowCount() > 0) {
    $rowCoordenador = $r_coordenadorColaborador->fetch(PDO::FETCH_ASSOC);

    $coordenador = $rowCoordenador['coordenador'];
    $usuarioCoordenador = $rowCoordenador['usuario'];

    if ($usuarioCoordenador <> null) {
        $opcaoCoordenador = '<option value="' . $usuarioCoordenador . '" selected="">' . $coordenador . '</option>';
    } else {
        $opcaoCoordenador = '<option value="" disabled selected="">Selecione...</option>';
    }
} else {
    $opcaoCoordenador = '<option value="" disabled selected="">Selecione...</option>';
}
?>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="dados-tab" data-bs-toggle="tab" data-bs-target="#dados" type="button" role="tab" aria-controls="dados" aria-selected="true">Informações</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="colaborador-tab" data-bs-toggle="tab" data-bs-target="#colaborador" type="button" role="tab" aria-controls="colaborador" aria-selected="true">Colaborador</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="competencia-tab" data-bs-toggle="tab" data-bs-target="#competencia" type="button" role="tab" aria-controls="competencia" aria-selected="true">Competência</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="log-tab" data-bs-toggle="tab" data-bs-target="#log" type="button" role="tab" aria-controls="log" aria-selected="true">LOGs</button>
                                        </li>

                                    </ul>

                                    <div class="tab-content pt-2" id="myTabContent">
                                        <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                                            <?php require "tabs/information.php" ?>
                                        </div>


                                        <div class="tab-pane fade" id="colaborador" role="tabpanel" aria-labelledby="colaborador-tab">
                                            <?php require "tabs/colaborador.php" ?>
                                        </div>


                                        <div class="tab-pane fade" id="competencia" role="tabpanel" aria-labelledby="competencia-tab">
                                            <?php require "tabs/competencias.php" ?>
                                        </div>

                                        <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-tab">
                                            <?php require "tabs/log.php" ?>
                                        </div>
                                    </div><!-- End Default Tabs -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
require "js.php";
require "../../includes/footer.php";
?>