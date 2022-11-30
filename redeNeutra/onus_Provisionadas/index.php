<?php
require "../../includes/menu.php";
?>


<main id="main" class="main">

    <div class="pagetitle">
        <h1>ONUs</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lista ONUs Provisionadas</h5>
                        <!-- Table with stripped rows -->
                        <!--<table class="table table-striped" id="styleTable">-->
                        <table class="table datatable" id="styleTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Parceiro</th>
                                    <th scope="col">OLT</th>
                                    <th scope="col">Slot</th>
                                    <th scope="col">Pon</th>
                                    <th scope="col">ID Onu</th>
                                    <th scope="col">Serial</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Data Provisionamento</th>
                                    <th scope="col">Provisionado por</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $usuarioID = $_SESSION['id'];

                                $sql_parceiroID =
                                    "SELECT
                                    u.parceiroRN_id as parceiro
                                FROM
                                    usuarios as u
                                WHERE
                                    u.id = $usuarioID
                                ";

                                $r_sql_parceiroID = mysqli_query($mysqli, $sql_parceiroID);
                                $camposParceiro = $r_sql_parceiroID->fetch_array();

                                if ($camposParceiro['parceiro'] != "") {
                                    $parceiroID = $camposParceiro['parceiro'];
                                } else {
                                    $parceiroID = "%";
                                }

                                require "sql.php";
                                $r_onus_provisionadas = mysqli_query($mysqli, $onus_provisionadas);

                                while ($campos = $r_onus_provisionadas->fetch_array()) { ?>
                                    <tr onclick="location.href='view.php?idProvisionamento=<?= $campos['id']; ?>'">
                                        <td><?= $campos['id'] ?></th>
                                        <td><?= $campos['parceiro'] ?></td>
                                        <td><?= $campos['olt']; ?></td>
                                        <td><?= $campos['slot_olt']; ?></td>
                                        <td><?= $campos['pon_olt']; ?></td>
                                        <td><?= $campos['id_onu']; ?></td>
                                        <td><?= $campos['serial_onu']; ?></td>
                                        <td><?= $campos['descricao']; ?></td>
                                        <td><?= $campos['data_provisionamento']; ?></td>
                                        <td><?= $campos['usuario_ativador']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require "../../includes/footer.php"
?>