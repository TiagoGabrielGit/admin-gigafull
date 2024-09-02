<?php
require "includes/menu.php";
require "conexoes/conexao.php";
require "conexoes/conexao_pdo.php";
?>

<main id="main" class="main">

    <?php
    $empresaID = $_SESSION['empresa_id'];

    $man_prog_menos_24h_gpon =
        "SELECT count(*) as qtde
        FROM manutencao_programada as mp
        LEFT JOIN manutencao_gpon as mg ON mg.manutencao_id = mp.id
        LEFT JOIN gpon_pon as gp on gp.id = mg.pon_id
        LEFT JOIN gpon_olts as go on go.id = gp.olt_id
        LEFT JOIN gpon_olts_interessados as goi ON goi.gpon_olt_id = go.id
        where mp.active = 1   and goi.interessado_empresa_id = $empresaID and goi.active = 1 and mp.dataAgendamento <= DATE_ADD(NOW(), INTERVAL 24 HOUR) AND mp.dataAgendamento > NOW()
        GROUP BY mp.id";

    $r_man_prog_menos_24h_gpon = mysqli_query($mysqli, $man_prog_menos_24h_gpon);
    $c_man_prog_menos_24h_gpon = $r_man_prog_menos_24h_gpon->fetch_array();

    $man_prog_menos_24h_backbone =
        "SELECT count(*) as qtde
        FROM
        manutencao_programada as mp
        LEFT JOIN manutencao_rotas_fibra as mrf ON mrf.manutencao_id = mp.id
        LEFT JOIN rotas_fibras_interessados as rfi ON rfi.rf_id = mrf.rota_id
        where
        mp.active = 1  and rfi.interessado_empresa_id = $empresaID  and rfi.active = 1 and mp.dataAgendamento <= DATE_ADD(NOW(), INTERVAL 24 HOUR) AND mp.dataAgendamento > NOW()
        GROUP BY mp.id";

    $r_man_prog_menos_24h_backbone = mysqli_query($mysqli, $man_prog_menos_24h_backbone);
    $c_man_prog_menos_24h_backbone = $r_man_prog_menos_24h_backbone->fetch_array();



    $man_prog_ocorrendo_gpon =
        "SELECT count(*) as qtde
        FROM manutencao_programada as mp
        LEFT JOIN manutencao_gpon as mg ON mg.manutencao_id = mp.id
        LEFT JOIN gpon_pon as gp on gp.id = mg.pon_id
        LEFT JOIN gpon_olts as go on go.id = gp.olt_id
        LEFT JOIN gpon_olts_interessados as goi ON goi.gpon_olt_id = go.id
        where mp.active = 1   and goi.interessado_empresa_id = $empresaID and goi.active = 1 AND mp.dataAgendamento < NOW()
        GROUP BY mp.id";

    $r_man_prog_ocorrendo_gpon = mysqli_query($mysqli, $man_prog_ocorrendo_gpon);
    $c_man_prog_ocorrendo_gpon = $r_man_prog_ocorrendo_gpon->fetch_array();

    $man_prog_ocorrendo_backbone =
        "SELECT count(*) as qtde
        FROM
        manutencao_programada as mp
        LEFT JOIN manutencao_rotas_fibra as mrf ON mrf.manutencao_id = mp.id
        LEFT JOIN rotas_fibras_interessados as rfi ON rfi.rf_id = mrf.rota_id
        where
        mp.active = 1  and rfi.interessado_empresa_id = $empresaID  and rfi.active = 1 AND mp.dataAgendamento < NOW()
        GROUP BY mp.id";

    $r_man_prog_ocorrendo_backbone = mysqli_query($mysqli, $man_prog_ocorrendo_backbone);
    $c_man_prog_ocorrendo_backbone = $r_man_prog_ocorrendo_backbone->fetch_array();
    if (isset($c_man_prog_menos_24h_backbone['qtde']) || isset($c_man_prog_menos_24h_gpon['qtde'])) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
        echo '<b>Existe uma manutenção programada com inicio previsto em menos de 24h.</b>';
        //echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
    }
    if (isset($c_man_prog_ocorrendo_backbone['qtde']) || isset($c_man_prog_ocorrendo_gpon['qtde'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo '<b>Existe uma manutenção programada ocorrendo.</b>';
        //echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
    }

    ?>

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->



    <?php
    if (!empty($_SESSION['url_dashboard'])) {
        require "dashboard/personalizado.php";
    } else {
        if ($_SESSION['dashboard'] == "1") {
            require "dashboard/tipo1.php";
        } else if ($_SESSION['dashboard'] == "2") {
            require "dashboard/tipo2.php";
        } else if ($_SESSION['dashboard'] == "3") {
            require "dashboard/tipo3.php";
        }
    }



    ?>

</main><!-- End #main -->
<?php
require "includes/footer.php";
?>