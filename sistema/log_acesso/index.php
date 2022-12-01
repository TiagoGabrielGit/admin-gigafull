<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "sql.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>LOGs de acesso</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">


                        <div class="container">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="card-title">LOGs</h5>
                                </div>
                            </div>
                        </div>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Sessão</th>
                                    <th scope="col">Usuário</th>
                                    <th scope="col">IP de acesso</th>
                                    <th scope="col">Data/Hora</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Preenchendo a tabela com os dados do banco: -->
                                <?php
                                $resultado = mysqli_query($mysqli, $sql_log_acesso) or die("Erro ao retornar dados");

                                // Obtendo os dados por meio de um loop while
                                while ($campos = $resultado->fetch_array()) {
                                    $id = $campos['id'];
                                    echo "<tr>";
                                ?>
                                    <td><?php echo $campos['sessao']; ?></td>
                                    <td><?php echo $campos['usuario']; ?></td>
                                    <td><?php echo $campos['ip_address']; ?></td>
                                    <td><?php echo $campos['horario']; ?></td>
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
require "../../includes/footer.php";
?>