<?php
require '../includes/menu.php';
require '../conexoes/conexao.php';
require '../conexoes/sql.php';
require '../includes/remove_setas_number.php';
?>

<style>
    #tabelaLista:hover {
        cursor: pointer;
        background-color: #E0FFFF;
    }
</style>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Pessoas</h1>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="card-title">Cadastro de pessoas</h5>
                                </div>
                                <div class="col-2"></div>
                                <div class="col-2">
                                    <div class="card">
                                        <!-- Basic Modal -->
                                        <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                            Nova pessoa
                                        </button>
                                    </div>
                                </div>

                                <div class="modal fade" id="basicModal" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Nova pessoa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <!-- Vertical Form -->
                                                    <form method="POST" action="/pessoas/processa/add.php" class="row g-3">

                                                        <li class="nav-heading" style="list-style: none;">Dados</li>

                                                        <div class="col-12">
                                                            <label for="nomePessoa" class="form-label">Nome</label>
                                                            <input name="nomePessoa" type="text" class="form-control" id="nomePessoa" required>
                                                        </div>

                                                        <div class="col-6">
                                                            <label for="cpf" class="form-label">CPF</label>
                                                            <input name="cpf" type="text" class="form-control" id="cpf" minlength="11" maxlength="11" required>
                                                        </div>

                                                        <div class="col-6">
                                                            <label for="email" class="form-label">E-mail</label>
                                                            <input name="email" type="text" class="form-control" id="email" required>
                                                        </div>

                                                        <div class="col-6">
                                                            <label for="telefone" class="form-label">Telefone</label>
                                                            <input name="telefone" type="text" class="form-control" id="telefone" minlength="13" maxlength="13">
                                                        </div>

                                                        <div class="col-6">
                                                            <label for="celular" class="form-label">Celular</label>
                                                            <input name="celular" type="text" class="form-control" id="celular" minlength="14" maxlength="14" required>
                                                        </div>

                                                        <hr class="sidebar-divider">
                                                        <li class="nav-heading" style="list-style: none;">Atributos</li>

                                                        <div class="col-6">
                                                            <ul class="list-group" style="list-style: none;">
                                                                <li> <input class="form-check-input me-1" name="atributoCliente" type="checkbox" value="1"> Cliente</li>
                                                                <li> <input class="form-check-input me-1" name="permiteUsuario" type="checkbox" value="1"> Permite Usuário</li>
                                                                <li> <input class="form-check-input me-1" name="atributoPrestadorServico" type="checkbox" value="1"> Prestador de Serviço</li>
                                                            </ul>
                                                        </div>

                                                        <hr class="sidebar-divider">
                                                        <li class="nav-heading" style="list-style: none;">Localização</li>

                                                        <div class="col-6">
                                                            <label for="inputPaís" class="form-label">País</label>
                                                            <select id="pais" name="pais" class="form-select" aria-label="Default select example">
                                                                <option selected disabled>Selecione o país</option>
                                                                <?php
                                                                $resultado = mysqli_query($mysqli, $sql_pais);
                                                                while ($pais = mysqli_fetch_object($resultado)) :
                                                                    echo "<option value='$pais->id'> $pais->pais</option>";
                                                                endwhile;
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-6">
                                                            <label for="inputEstado" class="form-label">Estado</label>
                                                            <select id="estado" name="estado" class="form-select" aria-label="Default select example">
                                                                <option selected disabled>Selecione o país</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-6">
                                                            <label for="inputCidade" class="form-label">Cidade</label>
                                                            <select id="cidade" name="cidade" class="form-select" aria-label="Default select example">
                                                                <option selected disabled>Selecione o estado</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-6">
                                                            <label for="inputBairro" class="form-label">Bairro</label>
                                                            <select id="bairro" name="bairro" class="form-select" aria-label="Default select example">
                                                                <option selected disabled>Selecione a cidade</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-12">
                                                            <label for="inputLogradouro" class="form-label">Logradouro</label>
                                                            <select id="logradouro" name="logradouro" class="form-select" aria-label="Default select example">
                                                                <option selected disabled>Selecione o bairro</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-2">
                                                            <label for="numero" class="form-label">Número</label>
                                                            <input name="numero" type="number" class="form-control" id="numero" required>
                                                        </div>

                                                        <div class="col-4">
                                                            <label for="complemento" class="form-label">Complemento</label>
                                                            <input name="complemento" type="text" class="form-control" id="complemento">
                                                        </div>

                                                        <div class="col-6">
                                                            <label for="cep" class="form-label">CEP</label>
                                                            <select id="cep" name="cep" class="form-select" disabled></select>

                                                        </div>

                                                        <hr class="sidebar-divider">

                                                        <div class="text-center">
                                                            <button name="salvar" type="submit" class="btn btn-primary">Salvar</button>
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

                        <p>Listagem de pessoas</p>


                        <table class="table table-striped" id="styleTable">
                            <thead>
                                <tr id="styleth">
                                    <th scope="col">Código</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">CPF</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Preenchendo a tabela com os dados do banco: -->
                                <?php
                                $resultado = mysqli_query($mysqli, $sql_pessoas) or die("Erro ao retornar dados");
                                // Obtendo os dados por meio de um loop while
                                while ($campos = $resultado->fetch_array()) {
                                    $id = $campos['id']; ?>
                                    <tr>



                                        <td><?= $campos['id']; ?></td>

                                        <td style="text-align: center;">
                                            <a style="color: red;" href="view.php?id=<?= $campos['id'] ?>"><?= $campos['nome']; ?></a>
                                        </td>


                                        <td><?= $campos['nome']; ?></td>
                                        <td><?= $campos['email']; ?></td>
                                        <td><?= $campos['cpf']; ?></td>
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
require '../scripts/pessoas.php';
require '../includes/footer.php';
?>