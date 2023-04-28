<?php
require "../../includes/menu.php";
require "sql.php";

$usuarioID = $_SESSION['id'];
$tipo_usuario =
    "SELECT
u.tipo_usuario as tipo
FROM
usuarios as u
WHERE
u.id = $usuarioID
";

$r_tipo_usuario = mysqli_query($mysqli, $tipo_usuario);
$c_tipo_usuario = $r_tipo_usuario->fetch_array();

if ($c_tipo_usuario['tipo' == "1"]) { ?>
    <main id="main" class="main">

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-4">
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Seriais Duplicados</h5>
                                <table class="table table-striped" id="styleTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Serial</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($c_serial_duplicado = $r_serial_duplicado->fetch_array()) { ?>
                                            <tr>
                                                <td><?= $c_serial_duplicado['serialONU'] ?></td>
                                            </tr>
                                        <?php
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Códigos Identificadores Duplicados</h5>
                                <table class="table table-striped" id="styleTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Código</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($c_codigo_duplicado = $r_codigo_duplicado->fetch_array()) { ?>
                                            <tr>
                                                <td><?= $c_codigo_duplicado['descricao'] ?></td>
                                            </tr>
                                        <?php
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
<?php } else { ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Operação não permitida!</h1>
        </div>
    </main>
<?php } ?>



<?php
require "../../includes/footer.php";
?>