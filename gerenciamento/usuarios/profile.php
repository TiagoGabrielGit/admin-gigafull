<?php
require "../../includes/menu.php";
?>

<?php
$usuarioID = $_GET['id'];

$sql_usuario =
    "SELECT
u.id as idUsuario,    
p.nome as nome,
p.email as email,
pf.perfil as perfil,
p.email as usuario,
e.fantasia as empresa
FROM
usuarios as u
LEFT JOIN
pessoas as p
ON
p.id = u.pessoa_id
LEFT JOIN
perfil as pf
ON
pf.id = u.perfil_id
LEFT JOIN
redeneutra_parceiro as rnp
ON
rnp.id = u.parceiroRN_id
LEFT JOIN
empresas as e
ON
e.id = rnp.empresa_id
WHERE
u.id = $usuarioID";

$r_usuario = mysqli_query($mysqli, $sql_usuario);
$campos = $r_usuario->fetch_array();

$log_acesso =
    "SELECT
ip_address,
horario,
id
FROM
log_acesso
WHERE
usuario_id = $usuarioID
ORDER BY
horario DESC
LIMIT 10";

$r_log = mysqli_query($mysqli, $log_acesso);
?>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">

                        <hr class="sidebar-divider">

                        <div class="row g-3">
                            <div class="col-lg-12">
                                <span><b><?= $campos['nome']; ?></b></span>
                            </div>

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">Nome</label>
                                        <input type="text" class="form-control" value="<?= $campos['nome']; ?>" disabled>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label">Rede Neutra</label>
                                        <input type="text" class="form-control" value="<?= $campos['empresa']; ?>" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">Usuário</label>
                                        <input type="text" class="form-control" value="<?= $campos['usuario']; ?>" disabled>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label">Perfil</label>
                                        <input type="text" class="form-control" value="<?= $campos['perfil']; ?>" disabled>
                                    </div>
                                </div>

                                <hr class="sidebar-divider">
                                <div class="col-lg-12">
                                    <span><b>Alterar senha</b></span>
                                </div>

                                <form method="POST" action="/gerenciamento/usuarios/processa/alterarSenha.php" class="needs-validation" novalidate>
                                    <div class="row">
                                        <input type="text" name="id" class="form-control" id="id" value="<?= $campos['idUsuario'] ?>" hidden>
                                        <input type="text" name="usuario" class="form-control" id="usuario" value="<?= $campos['nome'] ?>" hidden>

                                        <div class="col-4">
                                            <label for="senha" class="form-label">Digite a senha nova</label>
                                            <input type="password" name="senha" class="form-control" id="senha" required>
                                            <div class="invalid-feedback">Digite uma senha</div>
                                        </div>

                                        <div class="col-4">
                                            <label for="senhaRepeat" class="form-label">Repita a senha</label>
                                            <input type="password" name="senhaRepeat" class="form-control" id="senhaRepeat" required>
                                            <div class="invalid-feedback">Digite uma senha</div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-3">
                                        <button class="btn btn-danger w-100" type="submit">Alterar Senha</button>
                                    </div>
                                </form>
                            </div>
                            <hr class="sidebar-divider">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">

                        <hr class="sidebar-divider">

                        <div class="row g-3">
                            <div class="col-lg-12">
                                <span><b>Últimos 10 Acessos</b></span>
                            </div>

                            <div class="col-lg-12">
                                <div class="row">

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Sessão</th>
                                                <th scope="col">IP</th>
                                                <th scope="col">Horário</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($campos_log = $r_log->fetch_array()) { ?>
                                                <tr>
                                                    <td><?= $campos_log['id'] ?></td>
                                                    <td><?= $campos_log['ip_address'] ?></td>
                                                    <td><?= $campos_log['horario'] ?></td>
                                                </tr>
                                            <?php } ?>



                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <hr class="sidebar-divider">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
require "../../includes/footer.php";
?>