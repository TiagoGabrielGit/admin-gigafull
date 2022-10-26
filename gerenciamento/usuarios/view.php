<?php
require "../../includes/menu.php"
?>

<?php
$idUsuario = $_GET['id'];

$sql_usuario =
    "SELECT 
user.id as id,
CASE
    WHEN user.dashboard = 1 THEN 'Tipo 1'
    WHEN user.dashboard = 2 THEN 'Tipo 2'
    WHEN user.dashboard = 3 THEN 'Tipo 3'
END as dashboard,
pess.nome as nome,
CASE
    WHEN user.tipo_usuario = 1 THEN 'Gigafull Admin'
    WHEN user.tipo_usuario = 2 THEN 'Gigafull Portal'
    WHEN user.tipo_usuario = 3 THEN 'Gigafull RN'
END as tipo,
user.email as email,
user.senha as senha,
user.perfil_id as idPerfil,
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
WHERE
user.id = $idUsuario";

$r_sql_usuario = mysqli_query($mysqli, $sql_usuario) or die("Erro ao retornar dados");
$campos = $r_sql_usuario->fetch_array();

$sql_perfil =
    "SELECT
p.id as idPerfil,
p.perfil as perfil
FROM
perfil as p
WHERE
p.active = 1"; ?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Usuário: <?= $campos['nome']; ?></h5>

                        <form method="POST" action="processa/editUser.php">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="col-2">
                                        <label for="idUsuario" class="form-label">ID </label>
                                        <input style="text-align: center;" type="Text" name="idUsuario" class="form-control" id="idUsuario" value="<?= $campos['id']; ?>" disabled>
                                    </div>

                                    <input type="Text" name="id" id="id" value="<?= $campos['id']; ?>" hidden>

                                    <div class="col-9">
                                        <label class="form-label">Nome </label>
                                        <input type="Text" class="form-control" value="<?= $campos['nome']; ?>" disabled>
                                    </div>
                                </div>

                                <?php
                                if ($campos['active'] == "Ativado") {
                                    $checkSituacao1 = "checked";
                                    $checkSituacao0 = "";
                                } else if ($campos['active'] == "Inativado") {
                                    $checkSituacao0 = "checked";
                                    $checkSituacao1 = "";
                                }
                                ?>

                                <div class="col-lg-4">
                                    <div class="col-4">
                                        <label for="situacao" class="form-label">Situação</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="situacao" id="situacaoAtivo" value="1" <?= $checkSituacao1 ?>>
                                            <label class="form-check-label" for="situacaoAtivo">
                                                Ativo
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="situacao" id="situacaoInativo" value="0" <?= $checkSituacao0 ?>>
                                            <label class="form-check-label" for="situacaoInativo">
                                                Inativo
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label class="form-label">E-mail/Usuário </label>
                                        <input type="Text" class="form-control" value="<?= $campos['email']; ?>" disabled>
                                    </div>

                                    <div class="col-6">
                                        <label for="inputPerfil" class="form-label">Perfil</label>
                                        <select name="perfil" id="perfil" class="form-select" required>
                                            <option selected value="<?= $campos['idPerfil'] ?>"><?= $campos['nome_perfil'] ?></option>
                                            <?php
                                            $resultado = mysqli_query($mysqli, $sql_perfil) or die("Erro ao retornar dados");
                                            while ($p = $resultado->fetch_assoc()) : ?>
                                                <option value="<?= $p['idPerfil']; ?>"><?= $p['perfil']; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>

                                <?php
                                if ($campos['tipo'] == "Gigafull Admin") {
                                    $checkTipo1 = "checked";
                                    $checkTipo2 = "";
                                    $checkTipo3 = "";
                                } else if ($campos['tipo'] == "Gigafull Portal") {
                                    $checkTipo1 = "";
                                    $checkTipo2 = "checked";
                                    $checkTipo3 = "";
                                } else if ($campos['tipo'] == "Gigafull RN") {
                                    $checkTipo1 = "";
                                    $checkTipo2 = "";
                                    $checkTipo3 = "checked";
                                }
                                ?>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="tipoAcesso" class="form-label">Tipo de Acesso</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipoAcesso" id="tipoAcessoAdmin" value="1" <?= $checkTipo1 ?>>
                                            <label class="form-check-label" for="tipoAcessoAdmin">
                                                Gigafull Admin
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipoAcesso" id="tipoAcessoPortal" value="2" <?= $checkTipo2 ?>>
                                            <label class="form-check-label" for="tipoAcessoPortal">
                                                Gigafull Portal
                                            </label>
                                        </div>
                                        <div class="form-check disabled">
                                            <input class="form-check-input" type="radio" name="tipoAcesso" id="tipoAcessoPortalRN" value="3" <?= $checkTipo3 ?>>
                                            <label class="form-check-label" for="tipoAcessoPortalRN">
                                                Gigafull RN
                                            </label>
                                        </div>
                                    </div>

                                    <?php
                                    if ($campos['dashboard'] == "Tipo 1") {
                                        $checkDash1 = "checked";
                                        $checkDash2 = "";
                                        $checkDash3 = "";
                                    } else if ($campos['dashboard'] == "Tipo 2") {
                                        $checkDash1 = "";
                                        $checkDash2 = "checked";
                                        $checkDash3 = "";
                                    } else if ($campos['dashboard'] == "Tipo 3") {
                                        $checkDash1 = "";
                                        $checkDash2 = "";
                                        $checkDash3 = "checked";
                                    }
                                    ?>

                                    <div class="col-4">
                                        <label for="dashboard" class="form-label">Dashboard Inicial</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="dashboard" id="dashboard1" value="1" <?= $checkDash1 ?>>
                                            <label class="form-check-label" for="dashboard1">
                                                Tipo 1
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="dashboard" id="dashboard2" value="2" <?= $checkDash2 ?>>
                                            <label class="form-check-label" for="dashboard2">
                                                Tipo 2
                                            </label>
                                        </div>
                                        <div class="form-check disabled">
                                            <input class="form-check-input" type="radio" name="dashboard" id="dashboard3" value="3" <?= $checkDash3 ?>>
                                            <label class="form-check-label" for="dashboard3">
                                                Tipo 3
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr class="sidebar-divider">
                                <div class="col-12" style="text-align: center;">
                                    <button class="btn btn-danger" type="submit">Aplicar Alterações</button>
                                    <a class="btn btn-secondary" href="/gerenciamento/usuarios/usuarios.php">Voltar</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->



<?php
require "../../includes/footer.php"
?>