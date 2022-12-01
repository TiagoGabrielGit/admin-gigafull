<?php
require "../../includes/menu.php"
?>

<?php
$idUsuario = $_GET['id'];

$sql_usuario =
    "SELECT 
user.id as id,
pess.nome as nome,
CASE
    WHEN user.tipo_usuario = 1 THEN 'Gigafull Admin'
    WHEN user.tipo_usuario = 2 THEN 'Gigafull Portal'
    WHEN user.tipo_usuario = 3 THEN 'Gigafull RN'
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

                                                                <div class="col-6">
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


                                                                <div class="col-6">
                                                                    <label id="parceiroLabel" for="parceiroLabel" class="form-label">Parceiro</label>
                                                                    <select name="parceiroSelect" id="parceiroSelect" class="form-select" required>
                                                                        <?php
                                                                        $user_parceiro = "SELECT
                                                                e.fantasia as parceiro,
                                                                rp.id as idParceiro
                                                                FROM
                                                                usuarios as u
                                                                LEFT JOIN
                                                                redeneutra_parceiro as rp
                                                                ON
                                                                rp.id = u.parceiroRN_id
                                                                LEFT JOIN
                                                                empresas as e
                                                                ON
                                                                e.id = rp.empresa_id
                                                                WHERE
                                                                u.id = $idUsuario";

                                                                        $r_user_parceiro = mysqli_query($mysqli, $user_parceiro);
                                                                        $c_user_parceiro = $r_user_parceiro->fetch_assoc();

                                                                        if ($c_user_parceiro['idParceiro'] <> NULL) { ?>
                                                                            <option value="<?= $c_user_parceiro['idParceiro'] ?>"><?= $c_user_parceiro['parceiro'] ?></option>
                                                                        <?php } else { ?>
                                                                            <option selected disabled>Selecione a parceiro</option>
                                                                        <?php }
                                                                        ?>

                                                                        <?php
                                                                        $sql_parceiros =
                                                                            "SELECT
                                                                    rnp.id as parceiroID,
                                                                    e.fantasia as parceiro
                                                                    FROM
                                                                    redeneutra_parceiro as rnp
                                                                    LEFT JOIN
                                                                    empresas as e
                                                                    ON
                                                                    e.id = rnp.empresa_id         
                                                                    WHERE
                                                                    rnp.active = 1
                                                                    ORDER BY
                                                                    e.fantasia ASC";

                                                                        $resultado = mysqli_query($mysqli, $sql_parceiros) or die("Erro ao retornar dados");
                                                                        while ($p = $resultado->fetch_assoc()) : ?>
                                                                            <option value="<?= $p['parceiroID']; ?>"><?= $p['parceiro']; ?></option>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<?php
if ($campos['tipo'] == "Gigafull RN") { ?>
    <script>
        $(document).ready(function() {

            $('#tipoAcessoPortalRN').change(function() {
                if (this.checked) {
                    $('#parceiroLabel').show();
                    $('#parceiroSelect').show();
                }
            });

            $('#tipoAcessoAdmin').change(function() {
                if (this.checked) {
                    $('#parceiroLabel').hide();
                    $('#parceiroSelect').hide();
                }
            });

            $('#tipoAcessoPortal').change(function() {
                if (this.checked) {
                    $('#parceiroLabel').hide();
                    $('#parceiroSelect').hide();
                }
            });
        });
    </script>
<?php } else { ?>
    <script>
        $(document).ready(function() {

            $('#parceiroLabel').hide();
            $('#parceiroSelect').hide();

            //Inicialmente desmarca o CheckBox
            $('#tipoAcessoPortalRN').removeAttr('checked');

            $('#tipoAcessoPortalRN').change(function() {
                if (this.checked) {
                    $('#parceiroLabel').show();
                    $('#parceiroSelect').show();
                }
            });

            $('#tipoAcessoAdmin').change(function() {
                if (this.checked) {
                    $('#parceiroLabel').hide();
                    $('#parceiroSelect').hide();
                }
            });

            $('#tipoAcessoPortal').change(function() {
                if (this.checked) {
                    $('#parceiroLabel').hide();
                    $('#parceiroSelect').hide();
                }
            });
        });
    </script>
<?php }
?>
<?php
require "../../includes/footer.php";
?>