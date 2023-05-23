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