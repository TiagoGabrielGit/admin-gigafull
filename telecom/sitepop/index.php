<?php
require "../../includes/menu.php";
require "sql.php";
require "../../conexoes/conexao_pdo.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>POP / SITE</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <h5 class="card-title">Listagem de POPs</h5>
                            </div>
                            <div class="col-3">
                                <div class="card">
                                    <button style="margin-top: 15px" type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalNovoPOP">
                                        Novo POP
                                    </button>
                                </div>
                            </div>
                        </div>

                        <p>Listagem completa de POPs</p>
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-container">
                                <table class="table datatable datatable-table">
                                    <thead>
                                        <tr>
                                            <th>POP</th>
                                            <th>Melhorias</th>
                                            <th>Empresa</th>
                                            <th>Cidade</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <!-- Preenchendo a tabela com os dados do banco: -->
                                        <?php
                                        $resultado = mysqli_query($mysqli, $sql_lista_pops) or die("Erro ao retornar dados");

                                        // Obtendo os dados por meio de um loop while
                                        while ($campos = $resultado->fetch_array()) {
                                            $id = $campos['id'];
                                            $sql_melhorias = "SELECT COUNT(*) AS total_melhorias FROM pop_melhorias_conhecidas WHERE status = :status and pop_id = :id";
                                            $stmt = $pdo->prepare($sql_melhorias);
                                            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                                            $stmt->bindValue(':status', '1', PDO::PARAM_INT);
                                            $stmt->execute();
                                            $dados_melhorias = $stmt->fetch(PDO::FETCH_ASSOC);
                                            $total_melhorias = $dados_melhorias['total_melhorias'];


                                        ?>
                                            <tr>
                                                <td>
                                                    <a href="view.php?id=<?= $id ?>">
                                                        <span style="color: red;"><?= $campos['pop']; ?></span>
                                                    </a>
                                                </td>

                                                <td>
                                                    <?php if ($total_melhorias > 0) { ?>
                                                        <h6>
                                                            <span title="Melhorias Conhecidas" class="badge bg-danger"><?= $total_melhorias ?></span>
                                                        </h6>
                                                    <?php } ?>
                                                </td>
                                                <td><?= $campos['empresa']; ?></td>
                                                <td><?= $campos['cidade']; ?></td>
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
    </section>
</main>

<div class="modal fade" id="modalNovoPOP" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo POP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="card-body">
                    <!-- Vertical Form -->
                    <form method="POST" id="cadastraPOP" class="row g-3">
                        <span id="msgSalvarPOP1"></span>
                        <li class="nav-heading" style="list-style: none;">Dados</li>

                        <div class="col-3">
                            <label for="pop" class="form-label">POP*</label>
                            <input name="pop" type="text" class="form-control" id="pop" required>
                        </div>

                        <div class="col-5">
                            <label for="description" class="form-label">Descrição*</label>
                            <input name="description" type="text" class="form-control" id="description" required>
                        </div>

                        <div class="col-4">
                            <label for="empresa" class="form-label">Empresa*</label>
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

                        <hr class="sidebar-divider">
                        <li class="nav-heading" style="list-style: none;">Localização</li>


                        <div class="row">
                            <div class="col-4">
                                <label for="cep" class="form-label">CEP*</label>
                                <input name="cep" type="text" class="form-control" id="cep" onblur="buscarEnderecoPorCep()" required>
                            </div>

                            <div class="col-4">
                                <label for="ibgecode" class="form-label">Código IBGE</label>
                                <input name="ibgecode" type="text" class="form-control" id="ibgecode" readonly>
                            </div>
                        </div>
                        <p style='color:red;' id="mensagem-erro"></p>
                        <div class="col-4">
                            <label for="inputLogradouro" class="form-label">Logradouro*</label>
                            <input name="logradouro" type="text" class="form-control" id="logradouro" readonly required>
                        </div>

                        <div class="col-4">
                            <label for="inputBairro" class="form-label">Bairro*</label>
                            <input name="bairro" type="text" class="form-control" id="bairro" readonly>
                        </div>

                        <div class="col-4">
                            <label for="inputCidade" class="form-label">Cidade*</label>
                            <input name="cidade" type="text" class="form-control" id="cidade" readonly>
                        </div>

                        <div class="col-4">
                            <label for="inputEstado" class="form-label">Estado*</label>
                            <input name="estado" type="text" class="form-control" id="estado" readonly>
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
                            <span id="msgSalvarPOP2"></span>
                            <input id="btnSalvarPOP" name="btnSalvarPOP" type="button" value="Salvar" class="btn btn-danger"></input>
                            <button type="reset" class="btn btn-secondary">Limpar</button>
                        </div>
                    </form><!-- Vertical Form -->
                </div>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->


<?php
require "js.php";
require "../../includes/footer.php";
?>