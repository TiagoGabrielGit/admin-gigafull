<h5 class="card-title">Usuário: <?= $campos['nome']; ?></h5>
<form method="POST" action="processa/editUser.php">
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

                    <div class="col-6">
                        <label class="form-label">Nome </label>
                        <input type="Text" class="form-control" value="<?= $campos['nome']; ?>" disabled>
                    </div>

                    <div class="col-6">
                        <label class="form-label">E-mail/Usuário </label>
                        <input type="Text" class="form-control" value="<?= $campos['email']; ?>" disabled>
                    </div>

                </div>
                <br>

                <div class="row">
                    <div class="col-12">
                        <label for="permissaoAberturaChamado" class="form-label">Permissão para abertura de chamado </label>
                        <select name="permissaoAberturaChamado" id="permissaoAberturaChamado" class="form-select" required>
                            <?php
                            if ($campos['permissao_abertura_chamado'] == 1) { ?>
                                <option selected value="1">Permite abrir apenas chamados liberados para a empresa</option>
                                <option value="2">Permite abrir apenas chamados liberados para a equipe</option>
                                <option value="3">Permite abrir chamados liberados para empresa e para a equipe</option>
                            <?php } else if ($campos['permissao_abertura_chamado'] == 2) { ?>
                                <option value="1">Permite abrir apenas chamados liberados para a empresa</option>
                                <option selected value="2">Permite abrir apenas chamados liberados para a equipe</option>
                                <option value="3">Permite abrir chamados liberados para empresa e para a equipe</option>
                            <?php } else if ($campos['permissao_abertura_chamado'] == 3) { ?>
                                <option value="1">Permite abrir apenas chamados liberados para a empresa</option>
                                <option value="2">Permite abrir apenas chamados liberados para a equipe</option>
                                <option selected value="3">Permite abrir chamados liberados para empresa e para a equipe</option>
                            <?php } else { ?>
                                <option selected disabled value="">Selecione uma opção</option>
                                <option value="1">Permite abrir apenas chamados liberados para a empresa</option>
                                <option value="2">Permite abrir apenas chamados liberados para a equipe</option>
                                <option value="3">Permite abrir chamados liberados para empresa e para a equipe</option>
                            <?php }
                            ?>
                        </select>
                    </div>
                </div>

                <?php if ($campos['tipoUsuario'] == "1") { ?>
                    <div class="row">
                        <div class="col-12">
                            <label for="permissaoVisualizaChamado" class="form-label">Permissão para visualização de chamado </label>
                            <select name="permissaoVisualizaChamado" id="permissaoVisualizaChamado" class="form-select" required>
                                <?php
                                if ($campos['permissao_visualiza_chamado'] == 1) { ?>
                                    <option selected value="1">Visualiza somente da empresa do usuário</option>
                                    <option value="2">Visualiza somente tipos de chamados permitidos por equipe do usuário</option>
                                    <option value="3">Visualiza todos</option>
                                <?php } else if ($campos['permissao_visualiza_chamado'] == 2) { ?>
                                    <option value="1">Visualiza somente da empresa do usuário</option>
                                    <option selected value="2">Visualiza somente tipos de chamados permitidos por equipe do usuário</option>
                                    <option value="3">Visualiza todos</option>
                                <?php } else if ($campos['permissao_visualiza_chamado'] == 3) { ?>
                                    <option value="1">Visualiza somente da empresa do usuário</option>
                                    <option value="2">Visualiza somente tipos de chamados permitidos por equipe do usuário</option>
                                    <option selected value="3">Visualiza todos</option>
                                <?php } else { ?>
                                    <option selected disabled value="">Selecione uma opção</option>
                                    <option value="1">Visualiza somente da empresa do usuário</option>
                                    <option value="2">Visualiza somente tipos de chamados permitidos por equipe do usuário</option>
                                    <option value="3">Visualiza todos</option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="permissaoAbrirChamado" class="form-label">Pode abrir chamados para outras empresas</label>
                            <select name="permissaoAbrirChamado" id="permissaoAbrirChamado" class="form-select" required>
                                <?php
                                if ($campos['permissao_abrir_chamado'] == 1) { ?>

                                    <option selected value="1">Sim</option>
                                    <option value="0">Não</option>
                                <?php } else if ($campos['permissao_abrir_chamados'] == 0) { ?>
                                    <option value="1">Sim</option>
                                    <option selected value="0">Não</option>
                                <?php } else { ?>
                                    <option selected disabled value="">Selecione uma opção</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="permissaoApropriarChamados" class="form-label">Pode se apropriar de chamados</label>
                            <select name="permissaoApropriarChamados" id="permissaoApropriarChamadoss" class="form-select" required>
                                <?php
                                if ($campos['permissao_apropriar_chamado'] == 1) { ?>
                                    <option selected value="1">Sim</option>
                                    <option value="0">Não</option>
                                <?php } else if ($campos['permissao_apropriar_chamado'] == 0) { ?>
                                    <option value="1">Sim</option>
                                    <option selected value="0">Não</option>
                                <?php } else { ?>
                                    <option selected disabled value="">Selecione uma opção</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="permissaoEncaminharChamados" class="form-label">Pode encaminhar chamados</label>
                            <select name="permissaoEncaminharChamados" id="permissaoEncaminharChamados" class="form-select" required>
                                <?php
                                if ($campos['permissao_encaminhar_chamado'] == 1) { ?>
                                    <option selected value="1">Sim</option>
                                    <option value="0">Não</option>
                                <?php } else if ($campos['permissao_encaminhar_chamado'] == 0) { ?>
                                    <option value="1">Sim</option>
                                    <option selected value="0">Não</option>
                                <?php } else { ?>
                                    <option selected disabled value="">Selecione uma opção</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="permissaoInteressadosChamados" class="form-label">Pode incluir/remover interessados</label>
                            <select name="permissaoInteressadosChamados" id="permissaoInteressadosChamados" class="form-select" required>
                                <?php
                                if ($campos['permissao_interessados_chamados'] == 1) { ?>
                                    <option selected value="1">Sim</option>
                                    <option value="0">Não</option>
                                <?php } else if ($campos['permissao_interessados_chamados'] == 0) { ?>
                                    <option value="1">Sim</option>
                                    <option selected value="0">Não</option>
                                <?php } else { ?>
                                    <option selected disabled value="">Selecione uma opção</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="permissaoSelecionarCompetencias" class="form-label">Pode selecionar competências na abertura do chamado</label>
                            <select name="permissaoSelecionarCompetencias" id="permissaoSelecionarCompetencias" class="form-select" required>
                                <?php
                                if ($campos['permissao_selecionar_competencias'] == 1) { ?>
                                    <option selected value="1">Sim</option>
                                    <option value="0">Não</option>
                                <?php } else if ($campos['permissao_selecionar_competencias'] == 0) { ?>
                                    <option value="1">Sim</option>
                                    <option selected value="0">Não</option>
                                <?php } else { ?>
                                    <option selected disabled value="">Selecione uma opção</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="col-lg-5">

                <?php
                if ($campos['active'] == "Ativado") {
                    $checkSituacao1 = "checked";
                    $checkSituacao0 = "";
                } else if ($campos['active'] == "Inativado") {
                    $checkSituacao0 = "checked";
                    $checkSituacao1 = "";
                }


                if ($campos['notify_email'] == "Ativado") {
                    $checkNotifEmail1 = "checked";
                    $checkNotifEmail0 = "";
                } else if ($campos['notify_email'] == "Inativado") {
                    $checkNotifEmail0 = "checked";
                    $checkNotifEmail1 = "";
                }

                ?>

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

                    <div class="col-4">
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
                    <div class="col-4">
                        <label for="notificaEmail" class="form-label">Notificação E-mail</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="notificaEmail" id="notificaEmailAtivo" value="1" <?= $checkNotifEmail1 ?>>
                            <label class="form-check-label" for="notificaEmailAtivo">
                                Ativo
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="notificaEmail" id="notificaEmailInativo" value="0" <?= $checkNotifEmail0 ?>>
                            <label class="form-check-label" for="notificaEmailInativo">
                                Inativo
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