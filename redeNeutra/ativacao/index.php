<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "../../includes/remove_setas_number.php";

?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Ativação</h1>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Execução</h5> 
                                    <form id="formExecutaScript" method="POST">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="parceiro" class="form-label">Parceiro</label>
                                                <select class="form-select" id="parceiro" name="parceiro" required>
                                                    <option disabled selected value="">Selecione o parceiro</option>
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
                                                        u.id =   $usuarioID";

                                                    $r_sql_parceiroID = mysqli_query($mysqli, $sql_parceiroID);
                                                    $camposParceiro = $r_sql_parceiroID->fetch_array();

                                                    if ($camposParceiro['parceiro'] != "") {
                                                        $parceiroID = $camposParceiro['parceiro'];
                                                    } else {
                                                        $parceiroID = "%";
                                                    }

                                                    require "sql.php";

                                                    $resultado = mysqli_query($mysqli, $redeneutra_parceiro);
                                                    while ($parceiro = mysqli_fetch_object($resultado)) :
                                                        echo "<option value='$parceiro->idparceiro'> $parceiro->parceiro</option>";
                                                    endwhile;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <label for="olt" class="form-label">OLT</label>
                                                <select id="olt" name="olt" class="form-select" aria-label="Default select example">
                                                    <option selected disabled>Selecione a OLT</option>
                                                </select>
                                            </div>

                                            <div class="col-6">
                                                <label for="profile" class="form-label">Profile</label>
                                                <select id="profile" name="profile" class="form-select" aria-label="Default select example">
                                                    <option selected disabled>Selecione o profile</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-3">
                                                <label for="slotOLT" class="form-label">SLOT</label>
                                                <input name="slotOLT" type="number" class="form-control" id="slotOLT" required>
                                            </div>
                                            <div class="col-3">
                                                <label for="ponOLT" class="form-label">PON</label>
                                                <input name="ponOLT" type="number" class="form-control" id="ponOLT" required>
                                            </div>
                                            <div class="col-6">
                                                <label for="serialONU" class="form-label">Serial ONU</label>
                                                <input name="serialONU" type="text" class="form-control" id="serialONU" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-4">
                                                <label for="codigoParceiro" class="form-label">Código Parceiro</label>
                                                <input name="codigoParceiro" type="text" class="form-control" id="codigoParceiro" disabled>
                                            </div>

                                            <div class="col-6">
                                                <label for="codigoReserva" class="form-label">Código Reserva</label>
                                                <input name="codigoReserva" type="text" class="form-control" id="codigoReserva" required>
                                            </div>
                                        </div>

                                        <input name="usuarioID" type="text" class="form-control" id="usuarioID" value="<?=$usuarioID?>" hidden>

                                        <hr class="sidebar-divider">

                                        <div class="row">
                                            <div class="col-4">
                                            </div>
                                            <div class="col-4">
                                                <button data-bs-toggle="modal" data-bs-target="#modalProvisionando" id="buttonExecutaScript" class="btn btn-danger" type="button">Executar</button>
                                                <button id="buttonExecutandoScript" class="btn btn-danger" type="button" disabled="" hidden><span class="spinner-border spinner-border-sm" role="status" aria-hidden="false"></span> Executando</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-8">
                                                <h5 class="card-title">Resultado</h5>
                                            </div>
                                            <div class="col-3" style="text-align: right;">
                                                <input class="btn btn-secondary" style="margin-top: 10px" type="reset" value="Limpar">
                                            </div>
                                        </div>
                                        <div id="resultScript" class="col-12">
                                            <textarea style="resize: none" rows="17" type="text" class="form-control" disabled></textarea>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<div class="modal fade" id="modalProvisionando" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Provisionando</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="text-align: center;">
                <div id="loadingProvisionamento" class="spinner-border" style="width: 50px; height: 50px;" role="status">
                </div><br>
                <span id="spanMensagem"></span>
                <div style="font-size: 20px;" id="timer"></div>
            </div>
            <div class="modal-footer">

                <a href="/redeNeutra/onus_Provisionadas/index.php">
                    <input hidden id="irParaONU" type="button" value="Ir para ONUs Provisionadas" class="btn btn-danger"></input>
                </a>

                <a href="/redeNeutra/ativacao/index.php">
                    <input hidden id="okProvisionamento" type="button" value="Ok" class="btn btn-danger"></input>
                </a>
            </div>
        </div>
    </div>
</div>


<?php
require "js_script.php";
require "../../includes/footer.php";
?>