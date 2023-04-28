<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "../../includes/remove_setas_number.php";
require "sql.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>POPs</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">

                    <div class="card-body">


                        <div class="container">
                            <div class="row">
                                <div class="col-10">
                                    <h5 class="card-title">Cadastro de POP</h5>
                                </div>

                                <div class="col-2">
                                    <div class="card">
                                        <!-- Basic Modal -->
                                        <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                            Novo POP
                                        </button>
                                    </div>
                                </div>
                                <div class="modal fade" id="basicModal" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Novo POP</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <!-- Vertical Form -->
                                                    <form method="POST" action="processa/add.php" class="row g-3">

                                                        <div class="col-12">
                                                            <label for="inputEmpresa" class="form-label">Empresa*</label>
                                                            <select id="empresa" name="empresa" class="form-select" required>
                                                                <option selected disabled>Selecione a empresa</option>
                                                                <?php
                                                                $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                                                while ($empresa = mysqli_fetch_object($resultado)) :
                                                                    echo "<option value='$empresa->id'> $empresa->fantasia</option>";
                                                                endwhile;
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-4">
                                                            <label for="inputPOP" class="form-label">POP*</label>
                                                            <input name="pop" type="text" class="form-control" id="inputPOP" required>
                                                        </div>

                                                        <div class="col-8">
                                                            <label for="inputApelidoPop" class="form-label">Descrição</label>
                                                            <input name="apelidoPop" type="text" class="form-control" id="inputApelidoPop">
                                                        </div>

                                                        <div class="col-6">
                                                            <label for="cidade" class="form-label">Cidade*</label>
                                                            <select id="cidade" name="cidade" class="form-select" required>
                                                                <option selected disabled>Selecione a cidade</option>
                                                                <?php
                                                                $resultado = mysqli_query($mysqli, $sql_lista_cidades);
                                                                while ($cidade = mysqli_fetch_object($resultado)) :
                                                                    echo "<option value='$cidade->id'> $cidade->cidade</option>";
                                                                endwhile;
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-6">
                                                            <label for="inputBairro" class="form-label">Bairro*</label>
                                                            <select id="bairro" name="bairro" class="form-select" required>
                                                                <option selected disabled>Selecione a cidade</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-8">
                                                            <label for="inputLogradouro" class="form-label">Logradouro*</label>
                                                            <select id="logradouro" name="logradouro" class="form-select" required>
                                                                <option selected disabled>Selecione o bairro</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-4">
                                                            <label for="cep" class="form-label">CEP</label>
                                                            <select id="cep" name="cep" class="form-select" disabled></select>
                                                        </div>

                                                        <div class="col-2">
                                                            <label for="numero" class="form-label">Número*</label>
                                                            <input name="numero" type="number" class="form-control" id="numero" required>
                                                        </div>

                                                        <div class="col-4">
                                                            <label for="complemento" class="form-label">Complemento</label>
                                                            <input name="complemento" type="text" class="form-control" id="complemento">
                                                        </div>

                                                        <hr class="sidebar-divider">

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

                        <p>Listagem de pop</p>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped" id="styleTable">
                            <thead>
                                <tr>
                                    <th scope="col">Empresa</th>
                                    <th scope="col">POP</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Cidade</th>
                                    <th style="text-align: center;" scope="col">Visualizar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Preenchendo a tabela com os dados do banco: -->
                                <?php
                                $resultado = mysqli_query($mysqli, $sql_lista_pops) or die("Erro ao retornar dados");

                                // Obtendo os dados por meio de um loop while
                                while ($campos = $resultado->fetch_array()) {
                                    $id = $campos['id'];?>
                                <tr>
                                    <td><?= $campos['empresa']; ?></td>
                                    <td><?= $campos['pop']; ?></td>
                                    <td><?= $campos['apelidoPop']; ?></td>
                                    <td><?= $campos['cidade']; ?></td>
                                    <td style="text-align: center;">
                                        <a href="view.php?id=<?= $campos['id']; ?>" type="button" title="Ver mais" class="bi bi-eye-fill"></a>
                                        <a href="rack.php?id=<?= $campos['id']; ?>&pop=<?=$campos['pop']?>" type="button" title="Racks" class="bi bi-menu-button-wide"></a>
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
require "../../scripts/pop.php";
require "../../includes/footer.php";
?>