<?php
require "../../includes/menu.php"
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
p.active = 1"; ?>

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