<?php
require "../../includes/menu.php";
require "sql_filtros.php";

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $empresa_id = $_POST['empresaPesquisa'];
    if (empty($_POST['filterDate'])) {
        $filter_data = "%";
    } else {
        $filter_data = $_POST['filterDate'];
    }
} else {
    $empresa_id = "%";
    $filter_data = "%";
} ?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>ONUs</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <?php
                        $usuarioID = $_SESSION['id'];

                        $sql_parceiroID =
                            "SELECT
                            rnp.id as parceiro
                            FROM
                            usuarios as u
                            LEFT JOIN
                            redeneutra_parceiro as rnp
                            ON
                            u.empresa_id = rnp.empresa_id
                            WHERE
                            u.id =  $usuarioID
                                ";

                        $r_sql_parceiroID = mysqli_query($mysqli, $sql_parceiroID);
                        $camposParceiro = $r_sql_parceiroID->fetch_array();

                        if ($camposParceiro['parceiro'] != "") {
                        } else { ?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-9">
                                        <h5 class="card-title">Filtros</h5>
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="#" class="row g-3">

                                <div class="col-4">
                                    <label for="empresaPesquisa" class="form-label">Parceiro</label>
                                    <select id="empresaPesquisa" name="empresaPesquisa" class="form-select">
                                        <option selected value="%">Todos</option>
                                        <?php
                                        $resultado = mysqli_query($mysqli, $sql_lista_parceiros);

                                        while ($empresa = mysqli_fetch_object($resultado)) :
                                            echo "<option value='$empresa->id_empresa'> $empresa->fantasia_empresa</option>";
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

                                <div class="col-3">
                                    <label for="filterDate" class="form-label">Data Ativação</label>
                                    <input id="filterDate" name="filterDate" type="date" class="form-control">
                                    <?php
                                    if ($_SERVER["REQUEST_METHOD"] == 'POST') : ?>
                                        <script>
                                            let dataFilter = '<?= $_POST['filterDate']; ?>'
                                            if (dataFilter == '%') {} else {
                                                document.querySelector("#filterDate").value = dataFilter
                                            }
                                        </script>
                                    <?php endif;
                                    ?>
                                </div>


                                <div class="col-6">
                                    <button style="margin-top: 30px; " type="submit" class="btn btn-danger">Filtrar</button>
                                </div>

                            </form>

                        <?php  }
                        ?>

                        <hr class="sidebar-divider">

                        <h5 class="card-title">Lista ONUs Provisionadas</h5>

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
                                    $parceiroID = $empresa_id;
                                }

                                require "sql.php";
                                $r_onus_provisionadas = mysqli_query($mysqli, $onus_provisionadas);

                                while ($campos = $r_onus_provisionadas->fetch_array()) { ?>
                                    <tr>


                                        <td style="text-align: center;">
                                            <a style="color: red;" href="view.php?idProvisionamento=<?= $campos['id']; ?>"><?= $campos['id']; ?></a>
                                        </td>

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