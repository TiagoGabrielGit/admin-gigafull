<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "sql.php";
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>OLTs</h1>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Cadastrar OLT</h5>

                                    <span id="msgAlerta"></span>
                                    <form id="formCadastraOLT">
                                        <span id="msgAlertaErroCad"></span>
                                        <div class="row">
                                            <div class="col-5">
                                                <label for="equipamento" class="form-label">OLT</label>
                                                <select class="form-select" id="equipamento" name="equipamento" required>
                                                    <option disabled selected value="">Selecione a OLT</option>
                                                    <?php
                                                    $resultado = mysqli_query($mysqli, $lista_equipamentos);
                                                    while ($equipamento = mysqli_fetch_object($resultado)) :
                                                        echo "<option value='$equipamento->idEquipamento'> $equipamento->equipamento</option>";
                                                    endwhile;
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-7">
                                                <label for="olt" class="form-label">Apelido</label>
                                                <input name="olt" type="text" class="form-control" id="olt" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <label for="usuarioOLT" class="form-label">Usuário integração</label>
                                                <input name="usuarioOLT" type="text" class="form-control" id="usuarioOLT" required>
                                            </div>
                                            <div class="col-6">
                                                <label for="senhaOLT" class="form-label">Senha integração</label>
                                                <input name="senhaOLT" type="text" class="form-control" id="senhaOLT" required>
                                            </div>
                                        </div>

                                        <hr class="sidebar-divider">

                                        <div class="col-12" style="text-align: center;">
                                            <input type="submit" class="btn btn-danger" id="buttonCadastraOLT" value="Cadastrar"></input>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Informações</h5>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Lista de OLTs</h5>

                                    <table class="table table-striped" id="styleTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">OLT</th>
                                                <th scope="col">IP</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $r_lista_OLTs = mysqli_query($mysqli, $lista_OLTs);

                                            while ($campos_olts = $r_lista_OLTs->fetch_array()) {
                                            ?>
                                                <tr>

                                                    <td style="text-align: center;">
                                                        <a style="color: red;" href="view.php?idOLT=<?= $campos_olts['idOLT']; ?>"><?= $campos_olts['olt_name']; ?></a>
                                                    </td>
                                                    <td><?= $campos_olts['olt_ipAddress']; ?></td>
                                                    <td><?= $campos_olts['olt_status']; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    const cadForm = document.getElementById("formCadastraOLT");
    const msgAlertaErroCad = document.getElementById("msgAlertaErroCad");
    const msgAlerta = document.getElementById("msgAlerta");

    cadForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const dadosForm = new FormData(cadForm);

        document.getElementById("buttonCadastraOLT").value = "Salvando...";

        const dados = await fetch("cadastra_olt.php", {
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
        document.getElementById("buttonCadastraOLT").value = "Cadastrar";
    });
</script>


<?php
require "../../includes/footer.php";
?>