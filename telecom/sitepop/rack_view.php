<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql_rack_view =
    "SELECT
rack.id as rack_id,
rack.nomenclatura as rack_nomenclatura,
rack.pop_id as rack_popid,
rack.tamanho as rack_tamanho,
rack.polegada as rack_polegada,
pop.pop as pop_nome
FROM
pop_rack as rack
LEFT JOIN
pop as pop
ON
pop.id = rack.pop_id
WHERE
rack.id = $id
";

$resultado = mysqli_query($mysqli, $sql_rack_view);
$row = mysqli_fetch_assoc($resultado);

?>



<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Rack ID: <?php echo $row['rack_id']; ?></h5>

                        <form id="editRackPOP" method="POST" class="row g-3">


                            <span id="msg"></span>

                            <input hidden id="idRack" name="idRack" type="text" class="form-control" value="<?= $row['rack_id']; ?>">

                            <div class="col-3">
                                <label class="form-label">POP</label>
                                <input type="text" class="form-control" disabled value="<?= $row['pop_nome']; ?>">
                            </div>

                            <div class="col-9"></div>

                            <div class="col-3">
                                <label for="nomenclaturaRack" class="form-label">Nomenclatura</label>
                                <input name="nomenclaturaRack" id="nomenclaturaRack" type="text" class="form-control" value="<?= $row['rack_nomenclatura']; ?>" required>
                            </div>

                            <div class="col-4">
                                <label for="tamanhoRack" class="form-label">Tamanho</label>
                                <select name="tamanhoRack" id="nomenclaturaRack" class="form-select" required>
                                    <?php
                                    if ($row['rack_tamanho'] == "1") { ?>
                                        <option selected value="1">1U</option>
                                    <?php } else { ?>
                                        <option selected value="<?=$row['rack_tamanho']; ?>"><?= $row['rack_tamanho']; ?>U's</option>
                                    <?php }
                                    ?>
                                    <option value="1">1U</option>
                                    <option value="2">2U's</option>
                                    <option value="3">3U's</option>
                                    <option value="4">4U's</option>
                                    <option value="5">5U's</option>
                                    <option value="6">6U's</option>
                                    <option value="7">7U's</option>
                                    <option value="8">8U's</option>
                                    <option value="9">9U's</option>
                                    <option value="10">10u's</option>
                                    <option value="11">11u's</option>
                                    <option value="12">12u's</option>
                                    <option value="13">13u's</option>
                                    <option value="14">14u's</option>
                                    <option value="15">15u's</option>
                                    <option value="16">16u's</option>
                                    <option value="17">17u's</option>
                                    <option value="18">18u's</option>
                                    <option value="19">19u's</option>
                                    <option value="20">20u's</option>
                                    <option value="21">21u's</option>
                                    <option value="22">22u's</option>
                                    <option value="23">23u's</option>
                                    <option value="24">24u's</option>
                                    <option value="25">25u's</option>
                                    <option value="26">26u's</option>
                                    <option value="27">27u's</option>
                                    <option value="28">28u's</option>
                                    <option value="29">29u's</option>
                                    <option value="30">30u's</option>
                                    <option value="31">31u's</option>
                                    <option value="32">32u's</option>
                                    <option value="33">33u's</option>
                                    <option value="34">34u's</option>
                                    <option value="35">35u's</option>
                                    <option value="36">36u's</option>
                                    <option value="37">37u's</option>
                                    <option value="38">38u's</option>
                                    <option value="39">39u's</option>
                                    <option value="40">40u's</option>
                                    <option value="41">41u's</option>
                                    <option value="42">42u's</option>
                                    <option value="43">43u's</option>
                                    <option value="44">44u's</option>
                                    <option value="45">45u's</option>
                                    <option value="46">46u's</option>
                                    <option value="47">47u's</option>
                                    <option value="48">48u's</option>
                                    <option value="49">49u's</option>
                                    <option value="50">50u's</option>
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="polegadaRack" class="form-label">Polegada</label>
                                <select name="polegadaRack" id="polegadaRack" class="form-select" required>
                                    <option value="<?= $row['rack_polegada']?>" selected><?= $row['rack_polegada']?>' Polegadas</option>
                                    <option value="19">19' Polegadas</option>
                                    <option value="21">21' Polegadas</option>
                                </select>
                            </div>


                            <hr class="sidebar-divider">

                            <div class="col-4" style="text-align: left;">
                                <a href="?id=<?= $id ?>"><input type="button" class="btn btn-info" value="Visualizar equipamentos"></input></a>
                            </div>

                            <div class="col-4" style="text-align: center;">
                                <input id="btnSalvarEdit" name="btnSalvarEdit" type="button" value="Salvar" class="btn btn-primary"></input>
                                <a href="/telecom/sitepop/rack.php?id=<?= $row['rack_popid']; ?>&pop=<?=$row['pop_nome']; ?>"><input type="button" value="Voltar" class="btn btn-secondary"></a>
                            </div>

                            <div class="col-4" style="text-align: right;">
                                <a href="processa/delete_rack.php?id=<?= $id ?>"><input type="button" class="btn btn-danger" value="Excluir permanente"></input></a>
                            </div>
                        </form><!-- Vertical Form -->

                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->


<?php
require "../../scripts/rack.php";
require "../../includes/footer.php";
?>