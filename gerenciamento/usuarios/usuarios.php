<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "../../conexoes/conexao_pdo.php";
require "../../conexoes/sql.php";
require "../../includes/remove_setas_number.php";
require "sql.php";

$submenu_id = "18";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT 
	u.perfil_id
FROM 
	usuarios u
JOIN 
	perfil_permissoes_submenu pp
ON 
	u.perfil_id = pp.perfil_id
WHERE
	u.id = $uid
AND 
	pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {

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
                                    <div class="col-lg-8">
                                        <h5 class="card-title">Cadastro de Usuários</h5>
                                    </div>

                                    <div class="col-lg-4" style="margin-top: 15px;">
                                        <button title="Novo usuário" type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalNovoUser"><i class="bi bi-person-plus"></i></button>
                                        <button title="Gerar invite" type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalInvite"><i class="bi bi-send-plus"></i></button>
                                        <a href="/gerenciamento/usuarios/invite_gerencia.php"> <button title="Gerenciar Invites" type="button" class="btn btn-success"><i class="bi bi-send-check"></i></button></a>
                                    </div>

                                </div>

                            </div>

                            <p>Listagem usuários</p>

                            <!-- Table with stripped rows -->
                            <table class="table table-striped" id="styleTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Dashboard</th>
                                        <th scope="col">Perfil</th>
                                        <th scope="col">E-mail/Usuário</th>
                                        <th scope="col">Último Login</th>
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
                                        user.dashboard as dashboard,
                                        pess.email as email,
                                        user.senha as senha,
                                        p.perfil as nome_perfil,
                                        CASE
                                            WHEN user.active = 1 THEN 'Ativado'
                                            WHEN user.active = 0 THEN 'Inativado'
                                        END AS active
                                        FROM usuarios as user
                                        LEFT JOIN pessoas as pess ON pess.id = user.pessoa_id
                                        LEFT JOIN perfil as p ON p.id = user.perfil_id
                                        ORDER BY pess.nome ASC ";

                                    $resultado = mysqli_query($mysqli, $sql) or die("Erro ao retornar dados");

                                    while ($campos = $resultado->fetch_array()) {
                                        $id = $campos['id'];
                                        $usuario = $campos['nome'];
                                    ?>
                                        <tr>

                                            <td style="text-align: center;">
                                                <a style="color: red;" href="view.php?id=<?= $campos['id'] ?>"><?= $campos['nome']; ?></a>
                                            </td>

                                            <td>Tipo <?= $campos['dashboard']; ?></td>
                                            <td><?= $campos['nome_perfil']; ?></td>
                                            <td><?= $campos['email']; ?></td>

                                            <?php
                                            $last_login =
                                                "SELECT DATE_FORMAT(la.horario, '%d/%m/%Y %H:%i:%s') AS horario
                                                FROM log_acesso as la
                                                WHERE usuario_id = $id";
                                            $r_last_login = mysqli_query($mysqli, $last_login) or die("Erro ao retornar dados");
                                            $c_last_login = $r_last_login->fetch_array()
                                            ?>
                                            <td>
                                                <?php
                                                if (isset($c_last_login['horario'])) {
                                                    echo $c_last_login['horario'];
                                                } else {
                                                    echo "Nunca logado";
                                                }; ?></td>

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
                                                <a onclick="capturaDadosLogin(<?= $campos['id'] ?>,'<?= $campos['email'] ?>','<?= $campos['nome'] ?>')" class="bi bi-key-fill" role="button" data-bs-toggle="modal" data-bs-target="#basicModalSenha"></a>
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
            document.querySelector("#nomeUsuarioSenha").value = nome;
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
                        <form id="resetarSenha" method="POST" class="row g-3">

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
                                <label for="nomeUsuarioSenha" class="form-label">Nome </label>
                                <input type="Text" name="nomeUsuarioSenha" class="form-control" id="nomeUsuarioSenha" disabled>

                            </div>

                            <div class="col-12" style="text-align: center;">
                                <span id="msgConfirmacao">
                                    <b>
                                        <p style='color:red;'>Tem certeza que deseja gerar a senha? <br><br>
                                            Esta ação irá gerar uma senha provisória onde o usuário tera que alterá-la no primeiro acesso!</p>
                                    </b>
                                </span>

                            </div>
                            <div class="col-12" style="text-align: center;">
                                <span id="msgSenhaGerada"></span>
                            </div>
                            <div class="text-center">
                                <input id="btnReset" name="btnReset" type="button" value="Gerar Senha" class="btn btn-danger w-50"></input>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNovoUser" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form action="processa/adiciona_usuario.php" method="POST" class="row g-3">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-7">
                                        <label for="nomeUsuario" class="form-label">Nome</label>
                                        <select id="nomeUsuario" name="nomeUsuario" class="form-select" required>
                                            <option value="" selected disabled>Selecione a pessoa</option>
                                            <?php
                                            $resultado = mysqli_query($mysqli, $lista_pessoas);
                                            while ($pessoa = mysqli_fetch_object($resultado)) :
                                                echo "<option value='$pessoa->pessoa_id'> $pessoa->pessoa_nome</option>";
                                            endwhile;
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <label for="empresaSelect" class="form-label">Empresa</label>
                                        <select name="empresaSelect" id="empresaSelect" class="form-select" required>
                                            <option value="" selected disabled>Selecione a empresa</option>
                                            <?php
                                            $resultado = mysqli_query($mysqli, $sql_empresas) or die("Erro ao retornar dados");
                                            while ($p = $resultado->fetch_assoc()) : ?>
                                                <option value="<?= $p['empresaID']; ?>"><?= $p['fantasia']; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-5">
                                        <label for="perfil" class="form-label">Perfil</label>
                                        <select name="perfil" id="perfil" class="form-select" required>
                                            <option value="" selected disabled>Selecione o perfil</option>
                                            <?php
                                            $resultado = mysqli_query($mysqli, $sql_perfil) or die("Erro ao retornar dados");
                                            while ($p = $resultado->fetch_assoc()) : ?>
                                                <option value="<?= $p['idPerfil']; ?>"><?= $p['perfil']; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="col-5">
                                        <label for="dashboard" class="form-label">Dashboard</label>
                                        <select name="dashboard" id="dashboard" class="form-select" required>
                                            <option value="" selected disabled>Selecione a dashboard</option>
                                            <option value="1">Tipo 1</option>
                                            <option value="2">Tipo 2</option>
                                            <option value="3">Tipo 3</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="col-12" style="text-align: center;">

                                <button type="submit" class="btn btn-danger">Cadastrar usuário</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalInvite" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Invite</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form method="POST" id="formInvite" class="row g-3">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="inviteTipoAcesso" class="form-label">Tipo de Acesso</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="inviteTipoAcesso" id="inviteAcessoSmart" value="1" onchange="mostrarOcultarSelect()">
                                            <label class="form-check-label" for="inviteAcessoSmart">
                                                Smart
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="inviteTipoAcesso" id="inviteAcessoCliente" value="2" onchange="mostrarOcultarSelect()">
                                            <label class="form-check-label" for="inviteAcessoCliente">
                                                Cliente
                                            </label>
                                        </div>
                                        <div class="form-check disabled">
                                            <input class="form-check-input" type="radio" name="inviteTipoAcesso" id="inviteAcessoTenant" value="3" onchange="mostrarOcultarSelect()">
                                            <label class="form-check-label" for="inviteAcessoTenant">
                                                Tenant
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="validadeInvite" class="form-label">Validade Invite</label>
                                        <select name="validadeInvite" id="validadeInvite" class="form-select">
                                            <option selected disabled>Selecione o tempo</option>
                                            <option value="60">1 Hora</option>
                                            <option value="360">6 Horas</option>
                                            <option value="720">12 Horas</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="inviteEmpresa" class="form-label">Empresa</label>
                                        <select name="inviteEmpresa" id="inviteEmpresa" class="form-select">
                                            <option selected disabled>Selecione a empresa</option>
                                            <?php
                                            $resultado = mysqli_query($mysqli, $sql_empresas) or die("Erro ao retornar dados");
                                            while ($p = $resultado->fetch_assoc()) : ?>
                                                <option value="<?= $p['empresaID']; ?>"><?= $p['fantasia']; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div id="inviteConfiguracoesUsuario" style="display: none;">
                                        <div class="col-12">
                                            <label for="invitePerfil" class="form-label">Perfil</label>
                                            <select name="invitePerfil" id="invitePerfil" class="form-select">
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

                                <br>

                                <div class="col-12">
                                    <label for="permissaoChamados" class="form-label">Permissão para abertura de chamados</label>
                                    <select name="permissaoChamados" id="permissaoChamados" class="form-select">
                                        <option selected disabled>Selecione a permissão de abertura</option>
                                        <option value="1">Permite abrir apenas chamados liberados para a empresa</option>
                                        <option value="2">Permite abrir apenas chamados liberados para a equipe</option>
                                        <option value="3">Permite abrir chamados liberados para empresa e para a equipe</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-12" style="text-align: center;">
                                <span id="msgInvite"></span>
                                <input id="btnGerarInvite" name="btnGerarInvite" type="button" value="Gerar Invite" class="btn btn-danger"></input>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    require "js.php";
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>