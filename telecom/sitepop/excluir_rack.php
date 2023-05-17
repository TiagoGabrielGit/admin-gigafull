<?php
require "../../conexoes/conexao.php";
require "../../includes/menu.php";
require "sql.php";

$id_pop = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$nome_pop = filter_input(INPUT_GET, 'pop');

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Rack's POP - <?= $nome_pop ?> </h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">

                    <div class="card-body">

                        <div class="container">
                            <div class="row">

                                <div class="col-2">
                                    <div class="card">
                                        <!-- Basic Modal -->
                                        <button style="margin-top: 30px" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                                            Cadastrar novo
                                        </button>
                                    </div>
                                </div>

                                <div class="modal fade" id="basicModal" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Novo cadastro</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-body">

                                                    <!-- Vertical Form -->
                                                    <form id="addRackPOP" method="POST" class="row g-3">

                                                        <span id="msg"></span>

                                                        <input hidden id="idPOP" name="idPOP" type="text" class="form-control" value="<?= $id_pop ?>">

                                                        <div class="col-3">
                                                            <label class="form-label">POP</label>
                                                            <input type="text" class="form-control" disabled value="<?= $nome_pop ?>">
                                                        </div>

                                                        <div class="col-9"></div>

                                                        <div class="col-3">
                                                            <label for="nomenclaturaRack" class="form-label">Nomenclatura</label>
                                                            <input name="nomenclaturaRack" id="nomenclaturaRack" type="text" class="form-control" placeholder="Ex: rack01" required>
                                                        </div>

                                                        <div class="col-4">
                                                            <label for="tamanhoRack" class="form-label">Tamanho</label>
                                                            <select name="tamanhoRack" id="nomenclaturaRack" class="form-select" required>
                                                                <option selected disabled>Selecione</option>
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
                                                                <option selected disabled>Selecione</option>
                                                                <option value="19">19' Polegada</option>
                                                                <option value="21">21' Polegada</option>
                                                            </select>
                                                        </div>

                                                        <hr class="sidebar-divider">

                                                        <div class="text-center">
                                                            <input id="btnSalvar" name="btnSalvar" type="button" value="Salvar" class="btn btn-primary"></input>
                                                        </div>
                                                    </form><!-- Vertical Form -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End Basic Modal-->
                            </div>
                        </div>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" scope="col">POP</th>
                                    <th style="text-align: center;" scope="col">Rack</th>
                                    <th style="text-align: center;" scope="col">Quantidade "U"</th>
                                    <th style="text-align: center;" scope="col">Polegada</th>
                                    <th style="text-align: center;" scope="col">Visualizar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $sql_lista_rack =
                                    "SELECT
                                    rack.id as rack_id,
                                    pop.pop as pop,
                                    rack.nomenclatura as rack,
                                    rack.tamanho as tamanho,
                                    rack.polegada as polegada
                                    FROM
                                    pop_rack as rack
                                    LEFT JOIN
                                    pop as pop
                                    ON
                                    pop.id = rack.pop_id
                                    WHERE
                                    rack.pop_id LIKE '$id_pop'
                                    ";

                                $resultado = mysqli_query($mysqli, $sql_lista_rack);

                                while ($row = $resultado->fetch_array()) {
                                    $id = $row['rack_id'];
                                    echo "<tr>";
                                ?>
                                    <td style="text-align: center;"><?= $row['pop']; ?></td>
                                    <td style="text-align: center;"><?= $row['rack']; ?></td>
                                    <td style="text-align: center;"><?= $row['tamanho']; ?></td>
                                    <td style="text-align: center;"><?= $row['polegada']; ?></td>
                                    <td style="text-align: center;">
                                        <a href="rack_view.php?id=<?= $id ?>" type="button" title="Ver mais" class="bi bi-eye-fill"></a>
                                    </td>
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
require "../../scripts/rack.php";
require "../../includes/footer.php";
?>