<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "../../includes/remove_setas_number.php";
require "sql.php";
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Parceiros</h1>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Cadastrar parceiro</h5>
                                    <span id="msgAlerta"></span>
                                    <form id="formCadastraParceiro">
                                        <span id="msgAlertaErroCad"></span>
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="codigoParceiro" class="form-label">Código</label>
                                                <input name="codigoParceiro" type="number" class="form-control" id="codigoParceiro" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <label for="parceiro" class="form-label select-label">Parceiro</label>
                                                <select id="parceiro" name="parceiro" class="form-select" required>
                                                    <option disabled selected value="">Selecione uma empresa</option>
                                                    <?php
                                                    $resultado = mysqli_query($mysqli, $lista_empresas);
                                                    while ($empresa = mysqli_fetch_object($resultado)) :
                                                        echo "<option value='$empresa->idEmpresa'> $empresa->fantasia</option>";
                                                    endwhile;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <hr class="sidebar-divider">

                                        <div class="col-12" style="text-align: center;">
                                            <input type="submit" class="btn btn-danger" id="buttonCadastraParceiro" value="Cadastrar"></input>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Informações</h5>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Lista de parceiros</h5>

                                    <table class="table table-striped" id="styleTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Parceiro</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $r_lista = mysqli_query($mysqli, $lista_parceiros);

                                            while ($campos = $r_lista->fetch_array()) {
                                            ?>
                                                <tr>
                                                    <td><?= $campos['codigoParceiro']; ?></td>
                                                    <td style="text-align: center;">
                                                        <a style="color: red;" href="view.php?idParceiro=<?= $campos['idParceiro']; ?>"><?= $campos['parceiroFantasia']; ?></a>
                                                    </td>

                                                    <td><?= $campos['parceiro_status']; ?></td>
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

<?php
require "scripts.php";
require "../../includes/footer.php";
?>