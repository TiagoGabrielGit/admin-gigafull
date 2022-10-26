<?php
require "../../includes/menu.php";
require "sql.php";
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
                                </tr>
                            </thead>
                            <tbody>

                                <?php
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
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
require "../../includes/footer.php"
?>