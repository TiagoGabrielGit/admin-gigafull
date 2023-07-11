<?php
require "includes/menu.php";
require "conexoes/conexao.php";
require "conexoes/conexao_pdo.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

<?php 
if ($_SESSION['dashboard'] == "1") {
    require "dashboard/tipo1.php";
} else if ($_SESSION['dashboard'] == "2") {
    require "dashboard/tipo2.php";
} else if ($_SESSION['dashboard'] == "3") {
    require "dashboard/tipo3.php";
}

?>

</main><!-- End #main -->
<?php
require "includes/footer.php";
?>