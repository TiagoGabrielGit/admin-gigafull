<h5 class="card-title">Usuário: <?= $campos['nome']; ?></h5>
<form method="POST" action="processa/edita_user_permissao.php">
    <input type="Text" name="permissionIdUser" id="permissionIdUser" value="<?= $campos['id']; ?>" readonly hidden>

    <div class="col-lg-12">


        <hr class="sidebar-divider">

        <div class="pagetitle">
            <h3>Service Desk</h3>
        </div>

        <div class="row mb-3">
            <label for="permite_abrir_chamados_outras_empresas" class="col-sm-5 col-form-label">Permite abrir chamados para outras empresas</label>
            <div class="col-sm-6">
                <select name="permite_abrir_chamados_outras_empresas" id="permite_abrir_chamados_outras_empresas" class="form-select" required>
                    <?php
                    if ($campos['permite_abrir_chamados_outras_empresas'] == 1) { ?>
                        <option selected value="1">Sim</option>
                        <option value="0">Não</option>
                    <?php } else if ($campos['permite_abrir_chamados_outras_empresas'] == 0) { ?>
                        <option value="1">Sim</option>
                        <option selected value="0">Não</option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="permite_atender_chamados" class="col-sm-5 col-form-label">Permite atender chamados</label>
            <div class="col-sm-6">
                <select name="permite_atender_chamados" id="permite_atender_chamados" class="form-select" required>
                    <?php
                    if ($campos['permite_atender_chamados'] == 1) { ?>
                        <option selected value="1">Sim</option>
                        <option value="0">Não</option>
                    <?php } else if ($campos['permite_atender_chamados'] == 0) { ?>
                        <option value="1">Sim</option>
                        <option selected value="0">Não</option>
                    <?php } ?>
                </select>
            </div>

        </div>
        <div class="row mb-3">
            <label for="permite_atender_chamados_outras_empresas" class="col-sm-5 col-form-label">Permite atender chamados de outras empresas</label>
            <div class="col-sm-6">
                <select name="permite_atender_chamados_outras_empresas" id="permite_atender_chamados_outras_empresas" class="form-select" required>
                    <?php
                    if ($campos['permite_atender_chamados_outras_empresas'] == 1) { ?>
                        <option selected value="1">Sim</option>
                        <option value="0">Não</option>
                    <?php } else if ($campos['permite_atender_chamados_outras_empresas'] == 0) { ?>
                        <option value="1">Sim</option>
                        <option selected value="0">Não</option>
                    <?php } ?>
                </select>
            </div>

        </div>

        <div class="row mb-3">
            <label for="permite_interagir_chamados" class="col-sm-5 col-form-label">Permite interagir em chamados</label>
            <div class="col-sm-6">
                <select name="permite_interagir_chamados" id="permite_interagir_chamados" class="form-select" required>
                    <?php
                    if ($campos['permite_interagir_chamados'] == 1) { ?>
                        <option selected value="1">Permite interagir nos chamados da empresa do usuário</option>
                        <option value="2">Permite interagir nos chamados da equipe do usuário</option>
                        <option value="3">Permite interagir em qualquer chamado</option>
                        <option value="0">Não</option>
                    <?php } else if ($campos['permite_interagir_chamados'] == 2) {  ?>
                        <option value="1">Permite interagir nos chamados da empresa do usuário</option>
                        <option selected value="2">Permite interagir nos chamados da equipe do usuário</option>
                        <option value="3">Permite interagir em qualquer chamado</option>
                        <option value="0">Não</option>
                    <?php } else if ($campos['permite_interagir_chamados'] == 3) { ?>
                        <option value="1">Permite interagir nos chamados da empresa do usuário</option>
                        <option value="2">Permite interagir nos chamados da equipe do usuário</option>
                        <option selected value="3">Permite interagir em qualquer chamado</option>
                        <option  value="0">Não</option>
                    <?php } else if ($campos['permite_interagir_chamados'] == 0) { ?>
                        <option value="1">Permite interagir nos chamados da empresa do usuário</option>
                        <option value="2">Permite interagir nos chamados da equipe do usuário</option>
                        <option value="3">Permite interagir em qualquer chamado</option>
                        <option selected value="0">Não</option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">

            <label for="permite_encaminhar_chamados" class="col-sm-5 col-form-label">Permite encaminhar chamados</label>
            <div class="col-sm-6">
                <select name="permite_encaminhar_chamados" id="permite_encaminhar_chamados" class="form-select" required>
                    <?php
                    if ($campos['permite_encaminhar_chamados'] == 1) { ?>
                        <option selected value="1">Sim</option>
                        <option value="0">Não</option>
                    <?php } else if ($campos['permite_encaminhar_chamados'] == 0) { ?>
                        <option value="1">Sim</option>
                        <option selected value="0">Não</option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="permite_gerenciar_interessados" class="col-sm-5 col-form-label">Permite incluir/remover interessados</label>
            <div class="col-sm-6">
                <select name="permite_gerenciar_interessados" id="permite_gerenciar_interessados" class="form-select" required>
                    <?php
                    if ($campos['permite_gerenciar_interessados'] == 1) { ?>
                        <option selected value="1">Sim</option>
                        <option value="0">Não</option>
                    <?php } else if ($campos['permite_gerenciar_interessados'] == 0) { ?>
                        <option value="1">Sim</option>
                        <option selected value="0">Não</option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="permite_selecionar_competencias_abertura_chamado" class="col-sm-5 col-form-label">Permite selecionar competências na abertura do chamado</label>
            <div class="col-sm-6">
                <select name="permite_selecionar_competencias_abertura_chamado" id="permite_selecionar_competencias_abertura_chamado" class="form-select" required>
                    <?php
                    if ($campos['permite_selecionar_competencias_abertura_chamado'] == 1) { ?>
                        <option selected value="1">Sim</option>
                        <option value="0">Não</option>
                    <?php } else if ($campos['permite_selecionar_competencias_abertura_chamado'] == 0) { ?>
                        <option value="1">Sim</option>
                        <option selected value="0">Não</option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="permite_selecionar_solicitantes_abertura_chamado" class="col-sm-5 col-form-label">Permite selecionar solicitante na abertura do chamado</label>
            <div class="col-sm-6">
                <select name="permite_selecionar_solicitantes_abertura_chamado" id="permite_selecionar_solicitantes_abertura_chamado" class="form-select" required>
                    <?php
                    if ($campos['permite_selecionar_solicitantes_abertura_chamado'] == 1) { ?>
                        <option selected value="1">Sim</option>
                        <option value="0">Não</option>
                    <?php } else if ($campos['permite_selecionar_solicitantes_abertura_chamado'] == 0) { ?>
                        <option value="1">Sim</option>
                        <option selected value="0">Não</option>
                    <?php } ?>
                </select>
            </div>
        </div>



        <div class="row mb-3">
            <label for="permite_selecionar_atendente_abertura_chamado" class="col-sm-5 col-form-label">Permite selecionar atendente na abertura do chamado</label>
            <div class="col-sm-6">
                <select name="permite_selecionar_atendente_abertura_chamado" id="permite_selecionar_atendente_abertura_chamado" class="form-select" required>
                    <?php
                    if ($campos['permite_selecionar_atendente_abertura_chamado'] == 1) { ?>
                        <option selected value="1">Sim</option>
                        <option value="0">Não</option>
                    <?php } else if ($campos['permite_selecionar_atendente_abertura_chamado'] == 0) { ?>
                        <option value="1">Sim</option>
                        <option selected value="0">Não</option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="permite_alterar_configuracoes_chamado" class="col-sm-5 col-form-label">Permite alterar configurações do chamado</label>
            <div class="col-sm-6">
                <select name="permite_alterar_configuracoes_chamado" id="permite_alterar_configuracoes_chamado" class="form-select" required>
                    <?php
                    if ($campos['permite_alterar_configuracoes_chamado'] == 1) { ?>
                        <option selected value="1">Sim</option>
                        <option value="0">Não</option>
                    <?php } else if ($campos['permite_alterar_configuracoes_chamado'] == 0) { ?>
                        <option value="1">Sim</option>
                        <option selected value="0">Não</option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="permite_gerenciar_incidente" class="col-sm-5 col-form-label">Permite gerenciar incidentes</label>
            <div class="col-sm-6">
                <select name="permite_gerenciar_incidente" id="permite_gerenciar_incidente" class="form-select" required>
                    <?php
                    if ($campos['permite_gerenciar_incidente'] == 1) { ?>
                        <option selected value="1">Sim</option>
                        <option value="0">Não</option>
                    <?php } else if ($campos['permite_gerenciar_incidente'] == 0) { ?>
                        <option value="1">Sim</option>
                        <option selected value="0">Não</option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="permite_visualizar_protocolo_erp" class="col-sm-5 col-form-label">Permite Visualizar Protocolo do ERP</label>
            <div class="col-sm-6">
                <select name="permite_visualizar_protocolo_erp" id="permite_visualizar_protocolo_erp" class="form-select" required>
                    <option disabled value="" <?php echo ($campos['permite_visualizar_protocolo_erp'] === null) ? 'selected' : ''; ?>>Selecione uma opção</option>
                    <option value="1" <?php echo ($campos['permite_visualizar_protocolo_erp'] == 1) ? 'selected' : ''; ?>>Sim</option>
                    <option value="0" <?php echo ($campos['permite_visualizar_protocolo_erp'] == 0) ? 'selected' : ''; ?>>Não</option>
                </select>
            </div>
        </div>
    </div>

    <hr class="sidebar-divider">
    <div class="pagetitle">
        <h3>Telecom</h3>
    </div>

    <div class="row mb-3">
        <label for="permite_configurar_privacidade_credenciais" class="col-sm-4 col-form-label">Permite configurar privacidade credenciais</label>
        <div class="col-sm-6">
            <select name="permite_configurar_privacidade_credenciais" id="permite_configurar_privacidade_credenciais" class="form-select" required>
                <?php
                if ($campos['permite_configurar_privacidade_credenciais'] == 1) { ?>
                    <option selected value="1">Sim</option>
                    <option value="0">Não</option>
                <?php } else if ($campos['permite_configurar_privacidade_credenciais'] == 0) { ?>
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