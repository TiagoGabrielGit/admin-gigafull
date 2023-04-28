<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "sql.php";

if (empty($_POST['atualizar'])) {
    $_POST['atualizar'] = "nao_atualiza";
} {
    $_POST['atualizar'] = $_POST['atualizar'];
}




if ($_POST['atualizar'] == 1) {
    shell_exec("bash /root/atualiza.sh");
    $old_version = $_POST['old_version'];
    $new_version = $_POST['new_version'];
    $usuario = $_POST['usuario'];
    $insert_db = "INSERT INTO atualizacao (old_version, new_version, usuario, horario) VALUES ('$old_version', '$new_version', '$usuario', NOW())";
    $resultado = mysqli_query($mysqli, $insert_db);
}

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Atualizações</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">


                        <div class="container">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="card-title">Versão atual: <?= $versao_atual ?> <br><br> Última versão: <?= $ultima_versão ?></h5>

                                </div>

                                <div class="col-4">
                                    <div class="card">
                                        <form method="POST" class="row g-3">

                                            <input hidden type="text" name="usuario" id="usuario" value="<?= $_SESSION['id']; ?>">
                                            <input hidden type="text" name="old_version" id="old_version" value="<?= $versao_atual ?>">
                                            <input hidden type="text" name="new_version" id="new_version" value="<?= $ultima_versão ?>">

                                            <?php
                                            if ($versao_atual != $ultima_versão) { ?>
                                                <button value="1" id="atualizar" name="atualizar" style="margin-top: 30px" class="btn btn-primary">Atualizar</button>

                                            <?php } else { ?>
                                                <button disabled style="margin-top: 30px" type="button" class="btn btn-secondary">Sem atualização disponivel</button>
                                                <button hidden value="1" id="atualizar" name="atualizar" style="margin-top: 30px" class="btn btn-primary">Atualizar</button>
                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Versão antiga</th>
                                    <th scope="col">Nova versão</th>
                                    <th scope="col">Usuário</th>
                                    <th scope="col">Data/Hora</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Preenchendo a tabela com os dados do banco: -->
                                <?php
                                $resultado = mysqli_query($mysqli, $sql_atualizacoes) or die("Erro ao retornar dados");

                                // Obtendo os dados por meio de um loop while
                                while ($campos = $resultado->fetch_array()) {
                                    $id = $campos['id'];
                                    echo "<tr>";
                                ?>
                                    <td><?php echo $campos['old_version']; ?></td>
                                    <td><?php echo $campos['new_version']; ?></td>
                                    <td><?php echo $campos['usuario']; ?></td>
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