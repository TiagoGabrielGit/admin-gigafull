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
                </div>
            </div>
        </div>

        <hr class="sidebar-divider">

        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-12">
                        <label for="permissaoAberturaChamado" class="form-label"><b>Tipos de chamados permitidos abertura</b></label>
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
                            <label for="permissaoVisualizaChamado" class="form-label"><b>Permissão para visualização de chamado</b></label>
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
                            <label for="permissaoAbrirChamado" class="form-label"><b>Pode abrir chamados para outras empresas</b></label>
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
                            <label for="permissaoApropriarChamados" class="form-label"><b>Pode se apropriar de chamados</b></label>
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
                            <label for="permissaoEncaminharChamados" class="form-label"><b>Pode encaminhar chamados</b></label>
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
                            <label for="permissaoInteressadosChamados" class="form-label"><b>Pode incluir/remover interessados</b></label>
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
                            <label for="permissaoSelecionarCompetencias" class="form-label"><b>Pode selecionar competências na abertura do chamado</b></label>
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
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-12">
                        <label for="notificaEmail" class="form-label"><b>Ativar notificação por e-mail</b></label>
                        <select name="notificaEmail" id="notificaEmail" class="form-select" required onchange="exibirOcultarDivConfsEmail()">
                            <?php
                            if ($campos['notify_email'] == "Ativado") { ?>
                                <option selected value="1">Sim</option>
                                <option value="0">Não</option>
                            <?php } else if ($campos['notify_email'] == "Inativado") { ?>
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

                <div id="confsNotificacaoChamadosEmail" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <label for="notificaEmailAbertura" class="form-label"><b>Recebe e-mail na abertura de chamados</b></label>
                            <select name="notificaEmailAbertura" id="notificaEmailAbertura" class="form-select" required>
                                <?php
                                if ($campos['notify_email_abertura'] == 2) { ?>
                                    <option selected value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option value="1">Recebe e-mail de qualquer chamado aberto</option>
                                    <option value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php } else if ($campos['notify_email_abertura'] == 1) { ?>
                                    <option value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option selected value="1">Recebe e-mail de qualquer chamado aberto</option>
                                    <option value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php } else if ($campos['notify_email_abertura'] == 0) { ?>
                                    <option value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option value="1">Recebe e-mail de qualquer chamado aberto</option>
                                    <option selected value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php } else { ?>
                                    <option selected disabled value="">Selecione uma opção</option>
                                    <option value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option value="1">Recebe e-mail de qualquer chamado aberto</option>
                                    <option value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="notificaEmailEncaminhamento" class="form-label"><b>Recebe e-mail no encaminhamento de chamados</b></label>
                            <select name="notificaEmailEncaminhamento" id="notificaEmailEncaminhamento" class="form-select" required>
                                <?php
                                if ($campos['notify_email_encaminhamento'] == 2) { ?>
                                    <option selected value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option value="1">Recebe e-mail de qualquer chamado aberto</option>
                                    <option value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php } else if ($campos['notify_email_encaminhamento'] == 1) { ?>
                                    <option value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option selected value="1">Recebe e-mail de qualquer chamado</option>
                                    <option value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php } else if ($campos['notify_email_encaminhamento'] == 0) { ?>
                                    <option value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option value="1">Recebe e-mail de qualquer chamado</option>
                                    <option selected value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php } else { ?>
                                    <option selected disabled value="">Selecione uma opção</option>
                                    <option value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option value="1">Recebe e-mail de qualquer chamado</option>
                                    <option value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="notificaEmailRelatos" class="form-label"><b>Recebe e-mail de relatos de chamados</b></label>
                            <select name="notificaEmailRelatos" id="notificaEmailRelatos" class="form-select" required>
                                <?php
                                if ($campos['notify_email_relatos'] == 2) { ?>
                                    <option selected value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option value="1">Recebe e-mail de qualquer chamado aberto</option>
                                    <option value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php } else if ($campos['notify_email_relatos'] == 1) { ?>
                                    <option value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option selected value="1">Recebe e-mail de qualquer chamado</option>
                                    <option value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php } else if ($campos['notify_email_relatos'] == 0) { ?>
                                    <option value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option value="1">Recebe e-mail de qualquer chamado</option>
                                    <option selected value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php } else { ?>
                                    <option selected disabled value="">Selecione uma opção</option>
                                    <option value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option value="1">Recebe e-mail de qualquer chamado</option>
                                    <option value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="notificaEmailApropriação" class="form-label"><b>Recebe e-mail na apropriação de chamados</b></label>
                            <select name="notificaEmailApropriação" id="notificaEmailApropriação" class="form-select" required>
                                <?php
                                if ($campos['notify_email_apropriacao'] == 2) { ?>
                                    <option selected value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option value="1">Recebe e-mail de qualquer chamado</option>
                                    <option value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php } else if ($campos['notify_email_apropriacao'] == 1) { ?>
                                    <option value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option selected value="1">Recebe e-mail de qualquer chamado</option>
                                    <option value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php } else if ($campos['notify_email_apropriacao'] == 0) { ?>
                                    <option value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option value="1">Recebe e-mail de qualquer chamado</option>
                                    <option selected value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php } else { ?>
                                    <option selected disabled value="">Selecione uma opção</option>
                                    <option value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option value="1">Recebe e-mail de qualquer chamado</option>
                                    <option value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="notificaEmailExecucao" class="form-label"><b>Recebe e-mail na execução de chamados</b></label>
                            <select name="notificaEmailExecucao" id="notificaEmailExecucao" class="form-select" required>
                                <?php
                                if ($campos['notify_email_execucao'] == 2) { ?>
                                    <option selected value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option value="1">Recebe e-mail de qualquer chamado</option>
                                    <option value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php } else if ($campos['notify_email_execucao'] == 1) { ?>
                                    <option value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option selected value="1">Recebe e-mail de qualquer chamado</option>
                                    <option value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php } else if ($campos['notify_email_execucao'] == 0) { ?>
                                    <option value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option value="1">Recebe e-mail de qualquer chamado</option>
                                    <option selected value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php } else { ?>
                                    <option selected disabled value="">Selecione uma opção</option>
                                    <option value="2">Recebe e-mail de chamados aberto por usuários da mesma equipe</option>
                                    <option value="1">Recebe e-mail de qualquer chamado</option>
                                    <option value="0">Não recebe e-mail de nenhum chamado</option>
                                <?php }
                                ?>
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