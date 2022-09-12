<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "sql.php"
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Usuários portal</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">

                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="card-title">Cadastro de Usuários</h5>
                                </div>

                                <div class="col-4">
                                    <div class="card">
                                        <!-- Basic Modal -->
                                        <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                            Novo usuário
                                        </button>
                                    </div>
                                </div>

                                <div class="modal fade" id="basicModal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Novo Usuário</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <!-- Vertical Form -->
                                                    <form id="cadastraUsuarioPortal" method="POST" class="row g-3 needs-validation">

                                                        <span id="msg"></span>

                                                        <div class="col-12">
                                                            <label for="inputNome" class="form-label">Nome*</label>
                                                            <select id="inputNome" name="inputNome" class="form-select" required>
                                                                <option require selected disabled>Selecione a pessoa</option>
                                                                <?php
                                                                $resultado = mysqli_query($mysqli, $lista_pessoas);
                                                                while ($pessoa = mysqli_fetch_object($resultado)) :
                                                                    echo "<option value='$pessoa->pessoa_id'> $pessoa->pessoa_nome</option>";
                                                                endwhile;
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-12">
                                                            <label for="inputEmail" class="form-label">E-mail/Usuário</label>
                                                            <input id="inputEmail" name="inputEmail" class="form-control" disabled required></input>
                                                            <input id="inputEmailHidden" name="inputEmailHidden" class="form-control" hidden></input>
                                                        </div>

                                                        <div class="col-12">
                                                            <label for="inputEmpresa" class="form-label">Empresa*</label>
                                                            <select id="inputEmpresa" name="inputEmpresa" class="form-select" required>
                                                                <option require selected disabled>Selecione a empresa</option>
                                                                <?php
                                                                $resultado = mysqli_query($mysqli, $lista_empresas);
                                                                while ($empresa = mysqli_fetch_object($resultado)) :
                                                                    echo "<option value='$empresa->empresa_id'> $empresa->empresa_nome</option>";
                                                                endwhile;
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-12">
                                                            <label for="inputSenha" class="form-label">Senha</label>
                                                            <input id="inputSenha" name="inputSenha" class="form-control" required></input>
                                                        </div>

                                                        <hr class="sidebar-divider">

                                                        <div class="text-center">
                                                            <input id="btnSalvar" name="btnSalvar" type="button" value="Salvar" class="btn btn-danger"></input>
                                                            <a href="/portal/usuarios/index.php"> <input type="button" value="Voltar" class="btn btn-secondary"></input></a>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End Basic Modal-->

                            </div>

                        </div>

                        <p>Listagem usuários</p>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" scope="col">Nome</th>
                                    <th style="text-align: center;" scope="col">Empresa</th>
                                    <th style="text-align: center;" scope="col">E-mail/Usuário</th>
                                    <th style="text-align: center;" scope="col">Ativo</th>
                                    <th style="text-align: center;" scope="col">Ativar/Inativar</th>
                                    <th style="text-align: center;" scope="col">Alterar Senha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Preenchendo a tabela com os dados do banco: -->
                                <?php

                                $resultado = mysqli_query($mysqli, $sql_lista_user_portal) or die("Erro ao retornar dados");

                                // Obtendo os dados por meio de um loop while
                                while ($campos = $resultado->fetch_array()) {
                                    $id = $campos['id_usuario'];
                                    echo "<tr>";
                                ?>
                                    <td style="text-align: center;"><?php echo $campos['nome_pessoa']; ?></td>
                                    <td style="text-align: center;"><?php echo $campos['fantasia_empresa']; ?></td>
                                    <td style="text-align: center;"><?php echo $campos['user_usuario']; ?></td>
                                    <td style="text-align: center;"><?php echo $campos['active']; ?></td>
                                    <td style="text-align: center;">
                                        <?php
                                        if ($campos['active'] == "Ativado") {
                                            echo "<a href='processa/inativa.php?id=" . $campos['id_usuario'] . "' data-confirm='Tem certeza que deseja excluir permanentemente esse registro?'" . " class='bi bi-arrow-left-right' </a>";
                                        } else if ($campos['active'] == "Inativado") {
                                            echo "<a href='processa/ativa.php?id=" . $campos['id_usuario'] . "' data-confirm='Tem certeza que deseja excluir permanentemente esse registro?'" . " class='bi bi-arrow-left-right' </a>";
                                        }
                                        ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <a onclick="capturaDadosLogin(<?= $campos['id_usuario'] ?>,'<?= $campos['user_usuario'] ?>','<?= $campos['nome_pessoa'] ?>')" class="bi bi-key-fill" role="button" data-bs-toggle="modal" data-bs-target="#basicModalSenha"></a>
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

<script>
    function capturaDadosLogin(id, usuario, nome) {
        document.querySelector("#id").value = id;
        document.querySelector("#id_disable").value = id;
        document.querySelector("#usuario").value = usuario;
        document.querySelector("#usuario_disable").value = usuario;
        document.querySelector("#nomeUsuario").value = nome;
    }
</script>


<div class=" modal fade" id="basicModalSenha" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alterar senha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <!-- Vertical Form -->
                    <form method="POST" action="/portal/usuarios/processa/senha.php" class="row g-3 needs-validation" novalidate>

                        <div class="col-12">
                            <label for="nomeUsuario" class="form-label">Nome </label>
                            <input type="Text" name="nomeUsuario" class="form-control" id="nomeUsuario" disabled>

                        </div>

                        <div class="col-3">
                            <label for="id" class="form-label">ID</label>
                            <input type="text" name="id_disable" class="form-control" id="id_disable" disabled>
                            <input type="text" name="id" class="form-control" id="id" hidden>
                        </div>

                        <div class="col-9">
                            <label for="usuario" class="form-label">Usuário </label>
                            <input type="Text" name="usuario_disable" class="form-control" id="usuario_disable" disabled>
                            <input type="text" name="usuario" class="form-control" id="usuario" hidden>
                        </div>

                        <div class="col-12">
                            <label for="senha" class="form-label">Digite a senha nova</label>
                            <input type="password" name="senha" class="form-control" id="senha" required>
                            <div class="invalid-feedback">Digite seu e-mail.</div>
                        </div>

                        <div class="col-12">
                            <label for="senhaRepeat" class="form-label">Repita a senha</label>
                            <input type="password" name="senhaRepeat" class="form-control" id="senhaRepeat" required>
                            <div class="invalid-feedback">Digite seu e-mail.</div>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Alterar Senha</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->









<?php
require "../../scripts/usuario_portal.php";
require "../../includes/footer.php";
?>