<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao.php";
?>

<style>
    #tabelaLista:hover {
        cursor: pointer;
        background-color: #E0FFFF;
    }
</style>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Fabricantes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item">Cadastros</li>
                <li class="breadcrumb-item active">Fabricantes</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">

                    <div class="card-body">


                        <div class="container">
                            <div class="row">
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="card-title">Cadastro fabricantes</h5>
                                    </div>
                                    <div class="col-4">
                                        <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                            Novo fabricante
                                        </button>
                                    </div>
                                </div>
                                <div class="modal fade" id="basicModal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Novo fabricante</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <!-- Vertical Form -->
                                                    <form method="POST" action="processa/add.php" class="row g-3">
                                                        <div class="col-12">
                                                            <label for="inputFabricante" class="form-label">Fabricante</label>
                                                            <input name="fabricante" type="text" class="form-control" id="inputFabricante">
                                                        </div>


                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-danger">Salvar</button>
                                                            <button type="reset" class="btn btn-secondary">Limpar</button>
                                                        </div>
                                                    </form><!-- Vertical Form -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End Basic Modal-->

                            </div>

                        </div>

                        <p>Listagem fabricantes</p>

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Fabricante</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Preenchendo a tabela com os dados do banco: -->
                                <?php
                                $sql = "SELECT * FROM fabricante WHERE deleted = 1 ORDER BY fabricante ASC";
                                $resultado = mysqli_query($mysqli, $sql) or die("Erro ao retornar dados");

                                // Obtendo os dados por meio de um loop while
                                while ($campos = $resultado->fetch_array()) {
                                    $id = $campos['id']; ?>
                                    <tr id="tabelaLista" onclick="location.href='view.php?id=<?= $campos['id'] ?>'">
                                        <td><?php echo $campos['fabricante']; ?></td>
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
require "../../../includes/footer.php";
?>