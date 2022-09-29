<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "sql.php";
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
                                                <select class="form-select" id="olt" name="olt" required>
                                                    <option disabled selected value="">Selecione a OLT</option>
                                                    <?php
                                                    $resultado = mysqli_query($mysqli, $redeNeutra_OLTs);
                                                    while ($olts = mysqli_fetch_object($resultado)) :
                                                        echo "<option value='$olts->idOLT'> $olts->nameOLT</option>";
                                                    endwhile;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-2">
                                                <label for="slotOLT" class="form-label">SLOT</label>
                                                <input name="slotOLT" type="text" class="form-control" id="slotOLT" required>
                                            </div>
                                            <div class="col-2">
                                                <label for="ponOLT" class="form-label">PON</label>
                                                <input name="ponOLT" type="text" class="form-control" id="ponOLT" required>
                                            </div>
                                            <div class="col-8">
                                                <label for="serialONU" class="form-label">Serial ONU</label>
                                                <input name="serialONU" type="text" class="form-control" id="serialONU" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <label for="script" class="form-label">Script de ativação</label>
                                                <select class="form-select" id="script" name="script" required>
                                                    <option disabled selected value="">Selecione um script</option>
                                                    <?php
                                                    $resultado = mysqli_query($mysqli, $redeneutra_scripts);
                                                    while ($scripts = mysqli_fetch_object($resultado)) :
                                                        echo "<option value='$scripts->scriptName'> $scripts->descricao</option>";
                                                    endwhile;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <hr class="sidebar-divider">

                                        <input name="ipOLT" type="text" class="form-control" id="ipOLT" placeholder="IP">
                                        <input name="userOLT" type="text" class="form-control" id="userOLT" placeholder="Usuario">
                                        <input name="passOLT" type="text" class="form-control" id="passOLT" placeholder="Senha">

                                        <div class="col-12" style="text-align: center;">
                                            <button id="buttonExecutaScript" class="btn btn-danger" type="button">Executar</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Resultado</h5>

                                    <div class="col-12">
                                        <textarea style="resize: none" rows="15" type="text" class="form-control" disabled></textarea>
                                    </div>

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
require "js_script.php";
require "../../includes/footer.php";
?>