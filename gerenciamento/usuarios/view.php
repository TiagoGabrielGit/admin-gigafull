<?php
require "../../includes/menu.php"
?>

<?php
$idUsuario = $_GET['id'];

$sql_usuario =
    "SELECT 
user.id as id,
pess.nome as nome,
user.tipo_usuario as tipoUsuario,
CASE
    WHEN user.tipo_usuario = 1 THEN 'Smart'
    WHEN user.tipo_usuario = 2 THEN 'Cliente'
    WHEN user.tipo_usuario = 3 THEN 'Tenant'
END as tipo,
pess.email as email,
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
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="dados-tab" data-bs-toggle="tab" data-bs-target="#dados" type="button" role="tab" aria-controls="dados" aria-selected="true">Informações</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="log-tab" data-bs-toggle="tab" data-bs-target="#log" type="button" role="tab" aria-controls="log" aria-selected="true">LOGs</button>
                                        </li>
                                    </ul>

                                    <div class="tab-content pt-2" id="myTabContent">
                                        <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                                            <h5 class="card-title">Usuário: <?= $campos['nome']; ?></h5>
                                            <form method="POST" action="processa/editUser.php">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="row">
                                                                    <div class="col-2">
                                                                        <label for="idUsuario" class="form-label">ID </label>
                                                                        <input style="text-align: center;" type="Text" name="idUsuario" class="form-control" id="idUsuario" value="<?= $campos['id']; ?>" disabled>
                                                                    </div>

                                                                    <input type="Text" name="id" id="id" value="<?= $campos['id']; ?>" hidden>
                                                                </div>

                                                                <div class="col-6">
                                                                    <label class="form-label">Nome </label>
                                                                    <input type="Text" class="form-control" value="<?= $campos['nome']; ?>" disabled>
                                                                </div>

                                                                <div class="col-6">
                                                                    <label class="form-label">E-mail/Usuário </label>
                                                                    <input type="Text" class="form-control" value="<?= $campos['email']; ?>" disabled>
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
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-6">


                                                            <div class="row">
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

                                                                <?php
                                                                if ($campos['tipoUsuario'] == "1") {
                                                                    $checkTipo1 = "checked";
                                                                    $checkTipo2 = "";
                                                                    $checkTipo3 = "";
                                                                } else if ($campos['tipoUsuario'] == "2") {
                                                                    $checkTipo1 = "";
                                                                    $checkTipo2 = "checked";
                                                                    $checkTipo3 = "";
                                                                } else if ($campos['tipoUsuario'] == "3") {
                                                                    $checkTipo1 = "";
                                                                    $checkTipo2 = "";
                                                                    $checkTipo3 = "checked";
                                                                }
                                                                ?>

                                                                <div class="col-6">
                                                                    <label for="tipoAcesso" class="form-label">Tipo de Acesso</label>
                                                                    <div class="form-check">
                                                                        
                                                                        <input class="form-check-input" type="radio" name="tipoAcesso" id="tipoAcessoAdmin" value="1" <?= $checkTipo1 ?> onchange="mostrarOcultarSelect()">
                                                                        <label class="form-check-label" for="tipoAcessoAdmin">
                                                                            Smart
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="tipoAcesso" id="tipoAcessoPortal" value="2" <?= $checkTipo2 ?> onchange="mostrarOcultarSelect()">
                                                                        <label class="form-check-label" for="tipoAcessoPortal">
                                                                            Cliente
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check disabled">
                                                                        <input class="form-check-input" type="radio" name="tipoAcesso" id="tipoAcessoPortalRN" value="3" <?= $checkTipo3 ?> onchange="mostrarOcultarSelect()">
                                                                        <label class="form-check-label" for="tipoAcessoPortalRN">
                                                                            Tenant
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div id="controlaPerfil" class="col-6">
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


                                                                <div class="col-6">
                                                                    <label for="empresaSelect" class="form-label">Empresa</label>
                                                                    <select name="empresaSelect" id="empresaSelect" class="form-select" required>
                                                                        <?php
                                                                        $sql_empresa =
                                                                            "SELECT
                                                                        e.id as idEmpresa,
                                                                        e.fantasia as fantasia
                                                                        FROM
                                                                        usuarios as u
                                                                        LEFT JOIN
                                                                        empresas as e
                                                                        ON
                                                                        e.id = u.empresa_id
                                                                        WHERE
                                                                        u.id = $idUsuario";

                                                                        $r_empresa = mysqli_query($mysqli, $sql_empresa);
                                                                        $c_empresa = $r_empresa->fetch_assoc();

                                                                        if ($c_empresa['idEmpresa'] <> NULL) { ?>
                                                                            <option value="<?= $c_empresa['idEmpresa'] ?>"><?= $c_empresa['fantasia'] ?></option>
                                                                        <?php } else { ?>
                                                                            <option selected disabled>Selecione a empresa</option>
                                                                        <?php }
                                                                        ?>

                                                                        <?php
                                                                        $sql_lista_empresa =
                                                                            "SELECT
                                                                            e.id as idEmpresa,
                                                                            e.fantasia as fantasia
                                                                            FROM
                                                                            empresas as e
                                                                            WHERE
                                                                            e.deleted = 1
                                                                            ORDER BY
                                                                            e.fantasia ASC";

                                                                        $r_lista_empresa = mysqli_query($mysqli, $sql_lista_empresa) or die("Erro ao retornar dados");
                                                                        while ($p = $r_lista_empresa->fetch_assoc()) : ?>
                                                                            <option value="<?= $p['idEmpresa']; ?>"><?= $p['fantasia']; ?></option>
                                                                        <?php endwhile; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
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
                                        <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-tab">
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
                                                                $log_acesso =
                                                                    "SELECT
                                                                        ip_address,
                                                                        horario,
                                                                        id
                                                                        FROM
                                                                        log_acesso
                                                                        WHERE
                                                                        usuario_id = $idUsuario
                                                                        ORDER BY
                                                                        horario DESC
                                                                        LIMIT 10";

                                                                $r_log = mysqli_query($mysqli, $log_acesso);


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
                                    </div><!-- End Default Tabs -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
require "js.php";
require "../../includes/footer.php";
?>