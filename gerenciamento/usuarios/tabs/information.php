<h5 class="card-title">Usuário: <?= $campos['nome']; ?></h5>

<?php
if (isset($_SESSION['temp_password'])) {
    $tempPassword = $_SESSION['temp_password'];

    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo 'Usuário criado. A senha provisória é: "<b>' . $tempPassword . '</b>". Por favor, salve essa senha, pois ela não ficará disponível para visualização novamente.';
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
    unset($_SESSION['temp_password']);
}
?>

<form method="POST" action="processa/edita_user_information.php">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-7">
                <div class="row">
                    <div class="row">
                        <div class="col-2">
                            <label for="idUsuario" class="form-label">ID </label>
                            <input style="text-align: center;" type="Text" name="idUsuario" class="form-control" id="idUsuario" value="<?= $campos['id']; ?>" disabled>
                        </div>

                        <input type="Text" name="id" id="id" value="<?= $campos['id']; ?>" hidden>
                    </div>

                    <div class="col-8">
                        <label class="form-label">Nome </label>
                        <input type="Text" class="form-control" value="<?= $campos['nome']; ?>" disabled>
                    </div>

                    <div class="col-8">
                        <label class="form-label">E-mail/Usuário </label>
                        <input type="Text" class="form-control" value="<?= $campos['email']; ?>" disabled>
                    </div>

                </div>
                <br>

            </div>

            <div class="col-lg-5">

                <?php
                if ($campos['active'] == "Ativado") {
                    $checkSituacao1 = "checked";
                    $checkSituacao0 = "";
                } else if ($campos['active'] == "Inativado") {
                    $checkSituacao0 = "checked";
                    $checkSituacao1 = "";
                } ?>

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
                    <div class="row">
                        <div class="col-12">
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
                    <div class="row">
                        <div class="col-12">
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

                    <div class="row">
                        <div class="col-12">
                            <label for="usuarioDashboard" class="form-label">Dashboard</label>
                            <select name="usuarioDashboard" id="usuarioDashboard" class="form-select" required>

                                <option disabled value="" <?php echo ($campos['dashboard'] === null) ? 'selected' : ''; ?>>Selecione uma opção</option>
                                <option value="1" <?php echo ($campos['dashboard'] == 1) ? 'selected' : ''; ?>>Tipo 1</option>
                                <option value="2" <?php echo ($campos['dashboard'] == 2) ? 'selected' : ''; ?>>Tipo 2</option>
                                <option value="3" <?php echo ($campos['dashboard'] == 3) ? 'selected' : ''; ?>>Tipo 3</option>


                            </select>
                        </div>
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