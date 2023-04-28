<?php
require "../../includes/menu.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Perfil</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Novo Perfil</h5>
                        <span id="msgAlerta"></span>
                        <form id="cad-perfil-form">
                            <span id="msgAlertaErroCad"></span>
                            <div class="col-8">
                                <label for="nomePerfil" class="form-label">Perfil</label>
                                <input name="nomePerfil" type="text" class="form-control" id="nomePerfil" required>
                            </div>

                            <hr class="sidebar-divider">

                            <div class="col-12" style="text-align: center;">
                                <input type="submit" class="btn btn-danger" id="cad-perfil-btn" value="Cadastrar" />
                            </div>
                        </form>

                    </div>
                </div>
            </div>



            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lista de Perfil</h5>
                        <!-- Table with stripped rows -->
                        <!--<table class="table table-striped" id="styleTable">-->
                        <table class="table datatable" id="styleTable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Perfil</th>
                                    <th scope="col">Situação</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql_perfil =
                                    "SELECT 
                                p.id as idPerfil,
                                p.perfil as perfil,
                                CASE
                                WHEN p.active = 1 THEN 'Ativo'
                                WHEN p.active = 0 THEN 'Inativo'
                                END as situacao
                                FROM perfil as p";

                                $r_sql_perfil = mysqli_query($mysqli, $sql_perfil);

                                while ($campos = $r_sql_perfil->fetch_array()) { ?>
                                    <tr onclick="location.href='view.php?idPerfil=<?= $campos['idPerfil']; ?>'">
                                        <td><?= $campos['idPerfil'] ?></th>
                                        <td><?= $campos['perfil'] ?></td>
                                        <td><?= $campos['situacao']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<script>
    const cadForm = document.getElementById("cad-perfil-form");
    const msgAlertaErroCad = document.getElementById("msgAlertaErroCad");
    const msgAlerta = document.getElementById("msgAlerta");

    cadForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const dadosForm = new FormData(cadForm);

        document.getElementById("cad-perfil-btn").value = "Salvando...";

        const dados = await fetch("cadastrar.php", {
            method: "POST",
            body: dadosForm,
        });

        const resposta = await dados.json();

        if (resposta['erro']) {
            msgAlertaErroCad.innerHTML = resposta['msg'];
        } else {
            msgAlerta.innerHTML = resposta['msg'];
            cadForm.reset();

            setTimeout(function() {
                window.location.reload(1);
            }, 1200); 
        }
        document.getElementById("cad-perfil-btn").value = "Cadastrar";
    });
</script>

<?php
require "../../includes/footer.php";
?>