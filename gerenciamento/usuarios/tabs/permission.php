<h5 class="card-title">Usuário: <?= $campos['nome']; ?></h5>
<form method="POST" action="processa/edita_user_permissao.php">
    <input type="Text" name="permissionIdUser" id="permissionIdUser" value="<?= $campos['id']; ?>" readonly hidden>

    <div class="col-lg-12">

 
        <hr class="sidebar-divider">

        <div class="pagetitle">
            <h3>Service Desk</h3>
        </div>

        <div class="row mb-3">
            <label for="permissaoAberturaChamado" class="col-sm-4 col-form-label">Tipos de chamados permitidos abertura</label>
            <div class="col-sm-6">
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


            <label for="permissaoVisualizaChamado" class="col-sm-4 col-form-label">Permissão para visualização de chamado</label>
            <div class="col-sm-6">
                <select name="permissaoVisualizaChamado" id="permissaoVisualizaChamado" class="form-select" required>
                    <?php
                    if ($campos['permissao_visualiza_chamado'] == 1) { ?>
                        <option selected value="1">Visualiza somente os chamados da empresa do usuário</option>
                        <option value="2">Visualiza somente os chamados abertos por membros da mesma equipe</option>
                        <option value="3">Visualiza todos</option>
                    <?php } else if ($campos['permissao_visualiza_chamado'] == 2) { ?>
                        <option value="1">Visualiza somente os chamados da empresa do usuário</option>
                        <option selected value="2">Visualiza somente os chamados abertos por membros da mesma equipe</option>
                        <option value="3">Visualiza todos</option>
                    <?php } else if ($campos['permissao_visualiza_chamado'] == 3) { ?>
                        <option value="1">Visualiza somente os chamados da empresa do usuário</option>
                        <option value="2">Visualiza somente os chamados abertos por membros da mesma equipe</option>
                        <option selected value="3">Visualiza todos</option>
                    <?php } else { ?>
                        <option selected disabled value="">Selecione uma opção</option>
                        <option value="1">Visualiza somente os chamados da empresa do usuário</option>
                        <option value="2">Visualiza somente os chamados abertos por membros da mesma equipe</option>
                        <option value="3">Visualiza todos</option>
                    <?php }
                    ?>
                </select>
            </div>

            <label for="permissaoAbrirChamado" class="col-sm-4 col-form-label">Pode abrir chamados para outras empresas</label>
            <div class="col-sm-6">
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

            <label for="permissaoApropriarChamados" class="col-sm-4 col-form-label">Pode se apropriar de chamados</label>
            <div class="col-sm-6">
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

            <label for="permissaoEncaminharChamados" class="col-sm-4 col-form-label">Pode encaminhar chamados</label>
            <div class="col-sm-6">
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

            <label for="permissaoInteressadosChamados" class="col-sm-4 col-form-label">Pode incluir/remover interessados</label>
            <div class="col-sm-6">
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

            <label for="permissaoSelecionarCompetencias" class="col-sm-4 col-form-label">Pode selecionar competências na abertura do chamado</label>
            <div class="col-sm-6">
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

            <label for="permissaoSelecionaSolicitante" class="col-sm-4 col-form-label">Permite selecionar solicitante na abertura de um chamado</label>
            <div class="col-sm-6">
                <select name="permissaoSelecionaSolicitante" id="permissaoSelecionaSolicitante" class="form-select" required>
                    <?php
                    if ($campos['permissao_selecionar_solicitante'] == 1) { ?>
                        <option selected value="1">Sim</option>
                        <option value="0">Não</option>
                    <?php } else if ($campos['permissao_selecionar_solicitante'] == 0) { ?>
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

            <label for="permissaoSelecionaAtendente" class="col-sm-4 col-form-label">Permite selecionar atentende na abertura de um chamado</label>
            <div class="col-sm-6">
                <select name="permissaoSelecionaAtendente" id="permissaoSelecionaAtendente" class="form-select" required>
                    <?php
                    if ($campos['permissao_selecionar_atendente'] == 1) { ?>
                        <option selected value="1">Sim</option>
                        <option value="0">Não</option>
                    <?php } else if ($campos['permissao_selecionar_atendente'] == 0) { ?>
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

            <label for="permissaoAlterarConfiguracoes" class="col-sm-4 col-form-label">Permite Alterar Configurações do Chamado</label>
            <div class="col-sm-6">
                <select name="permissaoAlterarConfiguracoes" id="permissaoAlterarConfiguracoes" class="form-select" required>
                    <option disabled value="" <?php echo ($campos['permissao_configuracoes_chamados'] === null) ? 'selected' : ''; ?>>Selecione uma opção</option>
                    <option value="1" <?php echo ($campos['permissao_configuracoes_chamados'] == 1) ? 'selected' : ''; ?>>Sim</option>
                    <option value="0" <?php echo ($campos['permissao_configuracoes_chamados'] == 0) ? 'selected' : ''; ?>>Não</option>
                </select>
            </div>

            <label for="permissaoGerenciarIncidentes" class="col-sm-4 col-form-label">Permite Gerenciar Incidente</label>
            <div class="col-sm-6">
                <select name="permissaoGerenciarIncidentes" id="permissaoGerenciarIncidentes" class="form-select" required>
                    <option disabled value="" <?php echo ($campos['permissao_gerenciar_incidentes'] === null) ? 'selected' : ''; ?>>Selecione uma opção</option>
                    <option value="1" <?php echo ($campos['permissao_gerenciar_incidentes'] == 1) ? 'selected' : ''; ?>>Sim</option>
                    <option value="0" <?php echo ($campos['permissao_gerenciar_incidentes'] == 0) ? 'selected' : ''; ?>>Não</option>
                </select>
            </div>

            <label for="permissaoProtocoloERP" class="col-sm-4 col-form-label">Permite Visualizar Protocolo do ERP</label>
            <div class="col-sm-6">
                <select name="permissaoProtocoloERP" id="permissaoProtocoloERP" class="form-select" required>
                    <option disabled value="" <?php echo ($campos['permissao_protocolo_erp'] === null) ? 'selected' : ''; ?>>Selecione uma opção</option>
                    <option value="1" <?php echo ($campos['permissao_protocolo_erp'] == 1) ? 'selected' : ''; ?>>Sim</option>
                    <option value="0" <?php echo ($campos['permissao_protocolo_erp'] == 0) ? 'selected' : ''; ?>>Não</option>
                </select>
            </div>

        </div>
    </div>

    <hr class="sidebar-divider">
    <div class="pagetitle">
        <h3>Telecom</h3>
    </div>

    <div class="row mb-3">
        <label for="permissaoPrivacidadeCredenciais" class="col-sm-4 col-form-label">Permissão Configurar Privacidade Credenciais</label>
        <div class="col-sm-6">
            <select name="permissaoPrivacidadeCredenciais" id="permissaoPrivacidadeCredenciais" class="form-select" required>
                <?php
                if ($campos['permissao_privacidade_credenciais'] == 1) { ?>
                    <option selected value="1">Sim</option>
                    <option value="0">Não</option>
                <?php } else if ($campos['permissao_privacidade_credenciais'] == 0) { ?>
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
    <hr class="sidebar-divider">

    <div class="col-12" style="text-align: center;">
        <button class="btn btn-sm btn-danger" type="submit">Aplicar Alterações</button>
        <a class="btn btn-sm btn-secondary" href="/gerenciamento/usuarios/usuarios.php">Voltar</a>
    </div>
</form>