<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "../../conexoes/sql.php";
require "../../includes/remove_setas_number.php";
require "sql.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Usuário</h1>
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
                                <div class="col-2"></div>
                                <div class="col-2">
                                    <div class="card">
                                        <!-- Basic Modal -->
                                        <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalNovoUser">
                                            Novo usuário
                                        </button>
                                    </div>
                                </div>

                                <div class="modal fade" id="modalNovoUser" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Novo Usuário</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <form method="POST" id="formNovoUsuario" class="row g-3">

                                                        <span id="msgSalvarUsuario1"></span>
                                                        <div class="row">
                                                            <div class="col-8">
                                                                <label for="nomeUsuario" class="form-label">Nome</label>
                                                                <select id="nomeUsuario" name="nomeUsuario" class="form-select">
                                                                    <option require selected disabled>Selecione a pessoa</option>
                                                                    <?php
                                                                    $resultado = mysqli_query($mysqli, $lista_pessoas);
                                                                    while ($pessoa = mysqli_fetch_object($resultado)) :
                                                                        echo "<option value='$pessoa->pessoa_id'> $pessoa->pessoa_nome</option>";
                                                                    endwhile;
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label for="tipoAcesso" class="form-label">Tipo de Acesso</label>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="tipoAcesso" id="tipoAcessoAdmin" value="1" onchange="mostrarOcultarSelect()">
                                                                        <label class="form-check-label" for="tipoAcessoAdmin">
                                                                            Smart
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="tipoAcesso" id="tipoAcessoPortal" value="2" onchange="mostrarOcultarSelect()">
                                                                        <label class="form-check-label" for="tipoAcessoPortal">
                                                                            Cliente
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check disabled">
                                                                        <input class="form-check-input" type="radio" name="tipoAcesso" id="tipoAcessoPortalRN" value="3" onchange="mostrarOcultarSelect()">
                                                                        <label class="form-check-label" for="tipoAcessoPortalRN">
                                                                            Tenant
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <label for="empresaSelect" class="form-label">Empresa</label>
                                                                    <select name="empresaSelect" id="empresaSelect" class="form-select">
                                                                        <option selected disabled>Selecione a empresa</option>
                                                                        <?php
                                                                        $resultado = mysqli_query($mysqli, $sql_empresas) or die("Erro ao retornar dados");
                                                                        while ($p = $resultado->fetch_assoc()) : ?>
                                                                            <option value="<?= $p['empresaID']; ?>"><?= $p['fantasia']; ?></option>
                                                                        <?php endwhile; ?>
                                                                    </select>
                                                                </div>
                                                                <div id="controlaPerfil" class="col-6">
                                                                    <label for="inputPerfil" class="form-label">Perfil</label>
                                                                    <select name="perfil" id="perfil" class="form-select">
                                                                        <option selected disabled>Selecione o perfil</option>
                                                                        <?php
                                                                        $resultado = mysqli_query($mysqli, $sql_perfil) or die("Erro ao retornar dados");
                                                                        while ($p = $resultado->fetch_assoc()) : ?>
                                                                            <option value="<?= $p['idPerfil']; ?>"><?= $p['perfil']; ?></option>
                                                                        <?php endwhile; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <label for="inputEmail" class="form-label">E-mail/Usuário</label>
                                                            <input name="inputEmail" type="text" class="form-control" id="inputEmail" disabled>
                                                        </div>

                                                        <div class="col-6">
                                                            <label for="password" class="form-label">Senha</label>
                                                            <input type="password" name="password" class="form-control" id="password">
                                                            <div class="invalid-feedback">Digite uma senha.</div>
                                                        </div>

                                                        <div class="col-12" style="text-align: center;">
                                                            <span id="msgSalvarUsuario2"></span>
                                                            <input id="btnSalvarUsuario" name="btnSalvarUsuario" type="button" value="Cadastrar usuário" class="btn btn-danger"></input>
                                                            
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <p>Listagem usuários</p>

                        <!-- Table with stripped rows -->
                        <table class="table table-striped" id="styleTable">
                            <thead>
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Perfil</th>
                                    <th scope="col">E-mail/Usuário</th>
                                    <th scope="col">Ativo</th>
                                    <th style="text-align: center;" scope="col">Ativar/Inativar</th>
                                    <th style="text-align: center;" scope="col">Alterar Senha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Preenchendo a tabela com os dados do banco: -->
                                <?php

                                $sql =
                                    "SELECT 
                                        user.id as id,
                                        pess.nome as nome,
                                        CASE
                                            WHEN user.tipo_usuario = 1 THEN 'Smart'
                                            WHEN user.tipo_usuario = 2 THEN 'Cliente'
                                            WHEN user.tipo_usuario = 3 THEN 'Tenant'
                                        END as tipo,
                                        pess.email as email,
                                        user.senha as senha,
                                        p.perfil as nome_perfil,
                                        CASE
                                            WHEN user.active = 1 THEN 'Ativado'
                                            WHEN user.active = 0 THEN 'Inativado'
                                        END AS active
                                        FROM 
                                        usuarios as user
                                        LEFT JOIN                            
                                        pessoas as pess
                                        ON
                                        pess.id = user.pessoa_id
                                        LEFT JOIN
                                        perfil as p
                                        ON
                                        p.id = user.perfil_id
                                        ORDER BY
                                        pess.nome ASC
                                        ";

                                $resultado = mysqli_query($mysqli, $sql) or die("Erro ao retornar dados");

                                while ($campos = $resultado->fetch_array()) {
                                    $id = $campos['id'];
                                    $usuario = $campos['nome'];
                                ?>
                                    <tr>

                                        <td style="text-align: center;">
                                            <a style="color: red;" href="view.php?id=<?= $campos['id'] ?>"><?= $campos['nome']; ?></a>
                                        </td>

                                        <td><?= $campos['tipo']; ?></td>
                                        <td><?= $campos['nome_perfil']; ?></td>
                                        <td><?= $campos['email']; ?></td>
                                        <td><?= $campos['active']; ?></td>
                                        <td style="text-align: center;">
                                            <?php
                                            if ($campos['active'] == "Ativado") {
                                                echo "<a href='/gerenciamento/usuarios/processa/inativa.php?id=" . $campos['id'] . "' data-confirm='Tem certeza que deseja excluir permanentemente esse registro?'" . " class='bi bi-arrow-left-right' </a>";
                                            } else if ($campos['active'] == "Inativado") {
                                                echo "<a href='/gerenciamento/usuarios/processa/reativa.php?id=" . $campos['id'] . "' data-confirm='Tem certeza que deseja excluir permanentemente esse registro?'" . " class='bi bi-arrow-left-right' </a>";
                                            }
                                            ?>
                                        </td>
                                        <td style="text-align: center;">
                                            <a onclick="capturaDadosLogin(<?php echo $campos['id'] ?>,'<?php echo $campos['email'] ?>','<?php echo $campos['nome'] ?>')" class="bi bi-key-fill" role="button" data-bs-toggle="modal" data-bs-target="#basicModalSenha"></a>
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
                    <form method="POST" action="/gerenciamento/usuarios/processa/alterarSenha.php" class="row g-3 needs-validation" novalidate>

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
                            <button class="btn btn-danger w-100" type="submit">Alterar Senha</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->

<?php
require "js.php";
require "../../includes/footer.php";
?>