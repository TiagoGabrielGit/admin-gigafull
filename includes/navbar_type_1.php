<?php
$perfil_id = $_SESSION['perfil'];
require "validaPermissoesMenu.php";
require "validaPermissoesSubmenu.php";
require "validaRotina.php";
?>

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="/index.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <?php if ($c_valida_CRM['c'] > 0) { ?>
            <li class="nav-heading">CRM</li>
        <?php } ?>

        <?php if ($c_nav_contrato['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/contrato/index.php">
                    <i class="bi bi-chevron-contract"></i>
                    <span>Contratos</span>
                </a>
            </li>
        <?php } ?>

        <?php if ($c_nav_empresas['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/empresas/empresas.php">
                    <i class="bi bi-person-fill"></i>
                    <span>Empresas</span>
                </a>
            </li>
        <?php } ?>

        <?php if ($c_nav_pessoas['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/pessoas/pessoas.php">
                    <i class="bi bi-person"></i>
                    <span>Pessoas</span>
                </a>
            </li>
        <?php } ?>


        <?php if ($c_ecommerce['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#ecommerce-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>E-commerce</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="ecommerce-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                    <?php if ($c_nav_sub_produtos_ecommerce['c'] == 1) { ?>
                        <li>
                            <a href="/ecommerce/produtos_ecommerce/index.php">
                                <i class="bi bi-circle"></i><span>Produtos (e-commerce)</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_ecommerce_venda['c'] == 1) { ?>
                        <li>
                            <a href="/ecommerce/venda/index.php">
                                <i class="bi bi-circle"></i><span>Novo Pedido</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_ecommerce_pedidos['c'] == 1) { ?>
                        <li>
                            <a href="/ecommerce/pedidos/index.php">
                                <i class="bi bi-circle"></i><span>Pedidos</span>
                            </a>
                        </li>
                    <?php } ?>


                </ul>
            </li>
        <?php } ?>





        <?php if ($c_valida_cadastros['c'] > 0) { ?>
            <li class="nav-heading">Cadastros</li>
        <?php } ?>

        <?php if ($c_nav_produtosServicos['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#Produtos-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Produtos e Serviços</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="Produtos-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                    <?php if ($c_nav_sub_fabricantes['c'] == 1) { ?>
                        <li>
                            <a href="/cadastros/produtos/fabricantes/fabricantes.php">
                                <i class="bi bi-circle"></i><span>Fabricantes</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_produtos['c'] == 1) { ?>
                        <li>
                            <a href="/cadastros/produtos/produtos/index.php">
                                <i class="bi bi-circle"></i><span>Produtos</span>
                            </a>
                        </li>
                    <?php } ?>



                    <?php if ($c_nav_sub_servicos['c'] == 1) { ?>
                        <li>
                            <a href="/cadastros/produtos/servicos/index.php">
                                <i class="bi bi-circle"></i><span>Serviços</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_sistemaOperacional['c'] == 1) { ?>
                        <li>
                            <a href="/cadastros/produtos/sistemaoperacional/index.php">
                                <i class="bi bi-circle"></i><span>Sistema Operacional</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_tiposEquipamentos['c'] == 1) { ?>
                        <li>
                            <a href="/cadastros/produtos/tiposequipamentos/index.php">
                                <i class="bi bi-circle"></i><span>Tipos de Equipamentos</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if ($c_valida_service_desk['c'] > 0) { ?>
            <li class="nav-heading">Service Desk</li>
        <?php } ?>

        <?php if ($c_nav_chamados['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#chamados-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Chamados</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="chamados-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                    <?php if ($c_sub_novo_chamado['c'] == 1) { ?>
                        <li>
                            <a href="/servicedesk/novo_chamado/index.php">
                                <i class="bi bi-circle"></i><span>Novo Chamado</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_sub_consultar_chamado['c'] == 1) { ?>
                        <li>
                            <a href="/servicedesk/chamados/consultar_chamados.php">
                                <i class="bi bi-circle"></i><span>Consultar Chamados</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if ($c_nav_chamadosProgramados['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/servicedesk/chamados_programados/index.php">
                    <i class="bi bi-file-text"></i>
                    <span>Chamados Programados</span>
                </a>
            </li>
        <?php } ?>


        <?php if ($c_comunicacao['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#comunicacao-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Comunicação</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="comunicacao-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                    <?php if ($c_sub_comunicar['c'] == 1) { ?>
                        <li>
                            <a href="/comunicacao/comunicar/index.php">
                                <i class="bi bi-circle"></i><span>Nova Comunicação</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_sub_gerenciar_comunicados['c'] == 1) { ?>
                        <li>
                            <a href="/comunicacao/gerenciar_comunicados/index.php">
                                <i class="bi bi-circle"></i><span>Gerenciar Comunicados</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_sub_templates_comunicacao['c'] == 1) { ?>
                        <li>
                            <a href="/comunicacao/templates/index.php">
                                <i class="bi bi-circle"></i><span>Templates</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if ($c_nav_diagnosticos['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/diagnostico/index.php">
                    <i class="bi bi-file-text"></i>
                    <span>Diagnósticos</span>
                </a>
            </li>
        <?php } ?>

        <?php if ($c_nav_informativos['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#informativos-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Informativos</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="informativos-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">



                    <?php if ($c_nav_sub_atualizacao_massa['c'] == 1) { ?>
                        <li>
                            <a href="/servicedesk/incidentes/atualizacao_massa/index.php">
                                <i class="bi bi-circle"></i><span>Atualização em Massa</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_informativos_incidentes['c'] == 1) { ?>
                        <li>
                            <a href="/servicedesk/incidentes/informativos/informativos.php">
                                <i class="bi bi-circle"></i><span>Informativos de Incidentes</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_novo_incidente['c'] == 1) { ?>
                        <li>
                            <a href="/servicedesk/incidentes/new_incident/index.php">
                                <i class="bi bi-circle"></i><span>Novo Incidente</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_configuracoes_incidentes['c'] == 1) { ?>
                        <li>
                            <a href="/servicedesk/incidentes/configuracoes/index.php">
                                <i class="bi bi-circle"></i><span>Configurações</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_iframe_incidentes['c'] == 1) { ?>
                        <li>
                            <a href="/servicedesk/incidentes/iframe/index.php">
                                <i class="bi bi-circle"></i><span>Iframe</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if ($c_nav_man_programada['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#manutencaoProgramada-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Manutenção Programada</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="manutencaoProgramada-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                    <?php if ($c_nav_sub_agendar_manutencao['c'] == 1) { ?>
                        <li>
                            <a href="/servicedesk/manutencao_programada/agendar_manutencao/index.php">
                                <i class="bi bi-circle"></i><span>Agendar Manutenção</span>
                            </a>
                        </li>
                    <?php } ?>

                </ul>
                <ul id="manutencaoProgramada-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                    <?php if ($c_nav_sub_manutencoes_programadas['c'] == 1) { ?>
                        <li>
                            <a href="/servicedesk/manutencao_programada/manutencoes_programadas/index.php">
                                <i class="bi bi-circle"></i><span>Manutenções Programadas</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <ul id="manutencaoProgramada-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                    <?php if ($c_nav_sub_responsaveis_aceite['c'] == 1) { ?>
                        <li>
                            <a href="/servicedesk/manutencao_programada/responsaveis_aceite/index.php">
                                <i class="bi bi-circle"></i><span>Responsáveis por Aceite</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if ($c_nav_quadros_tarefas['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/tarefas/index.php">
                    <i class="bi bi-file-text"></i>
                    <span>Quadros e Tarefas</span>
                </a>
            </li>
        <?php } ?>

        <?php if ($c_nav_reunioes_atas['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#reunioesAtas-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Reuniões / Atas</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="reunioesAtas-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                    <?php if ($c_nav_sub_nova_reuniao['c'] == 1) { ?>
                        <li>
                            <a href="/servicedesk/reuniao_ata/nova_reuniao/index.php">
                                <i class="bi bi-circle"></i><span>Nova Reunião</span>
                            </a>
                        </li>
                    <?php } ?>

                </ul>
                <ul id="reunioesAtas-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                    <?php if ($c_nav_sub_atas['c'] == 1) { ?>
                        <li>
                            <a href="/servicedesk/reuniao_ata/reunioes/index.php">
                                <i class="bi bi-circle"></i><span>Reuniões / Atas</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>



        <?php if ($c_tipos_chamados['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tiposChamados-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Tipos de Chamados</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tiposChamados-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <?php if ($c_sub_mascaras_chamados['c'] == 1) { ?>
                        <li>
                            <a href="/servicedesk/tipos_chamados/mascaras/index.php">
                                <i class="bi bi-circle"></i><span>Mascaras</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_sub_status_chamados['c'] == 1) { ?>
                        <li>
                            <a href="/servicedesk/tipos_chamados/status/index.php">
                                <i class="bi bi-circle"></i><span>Status de Chamados</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_sub_tipos_chamados['c'] == 1) { ?>
                        <li>
                            <a href="/servicedesk/tipos_chamados/tipos/index.php">
                                <i class="bi bi-circle"></i><span>Tipos</span>
                            </a>
                        </li>
                    <?php } ?>


                </ul>
            </li>
        <?php } ?>

        <?php if ($c_valida_telecom['c'] > 0) { ?>
            <li class="nav-heading">Telecom</li>
        <?php } ?>

        <?php if ($c_nav_credenciais['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/telecom/credentials/index.php">
                    <i class="bi bi-key"></i>
                    <span>Credenciais</span>
                </a>
            </li>
        <?php } ?>

        <?php if ($c_nav_documentation['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/telecom/documentacao/index.php">
                    <i class="bi bi-file-text"></i>
                    <span>Documentação</span>
                </a>
            </li>
        <?php } ?>


        <?php if ($c_nav_popSite['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/telecom/sitepop/index.php">
                    <i class="bi bi-globe"></i>
                    <span>POP/Site</span>
                </a>
            </li>
        <?php } ?>

        <?php if ($c_nav_equipamentos['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/telecom/equipamentos/index.php">
                    <i class="bi bi-hdd-rack"></i>
                    <span>Equipamentos</span>
                </a>
            </li>
        <?php } ?>

        <?php if ($c_nav_maquinaVirtual['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/telecom/vms/index.php">
                    <i class="bi bi-pc-display-horizontal"></i>
                    <span>Máquina Virtual - VM</span>
                </a>
            </li>
        <?php } ?>

        <?php if ($c_nav_rede['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#rede-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Rede</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="rede-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <?php if ($c_nav_sub_gpon['c'] == 1) { ?>
                        <li>
                            <a href="/rede/gpon/index.php">
                                <i class="bi bi-circle"></i><span>GPON</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>

                <ul id="rede-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <?php if ($c_nav_sub_ctos['c'] == 1) { ?>
                        <li>
                            <a href="/rede/ctos/index.php">
                                <i class="bi bi-circle"></i><span>CTOs</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>

                <ul id="rede-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <?php if ($c_nav_sub_rotasFibra['c'] == 1) { ?>
                        <li>
                            <a href="/rede/rotas_de_fibra/index.php">
                                <i class="bi bi-circle"></i><span>Rotas de Fibra</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if ($c_nav_redeNeutra['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#redeNeutra-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Rede Neutra</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="redeNeutra-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <?php if ($c_nav_sub_auditoria['c'] == 1) { ?>
                        <li>
                            <a href="/redeNeutra/auditoria/index.php">
                                <i class="bi bi-circle"></i><span>Auditoria</span>
                            </a>
                        </li>
                    <?php } ?>


                    <?php if ($c_nav_sub_ativacao['c'] == 1) { ?>
                        <li>
                            <a href="/redeNeutra/ativacao/index.php">
                                <i class="bi bi-circle"></i><span>Ativação</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_olts['c'] == 1) { ?>
                        <li>
                            <a href="/redeNeutra/olts/index.php">
                                <i class="bi bi-circle"></i><span>OLTs</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_onusProvisionadas['c'] == 1) { ?>
                        <li>
                            <a href="/redeNeutra/onus_Provisionadas/index.php">
                                <i class="bi bi-circle"></i><span>ONUs Provisionadas</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_parceiros['c'] == 1) { ?>
                        <li>
                            <a href="/redeNeutra/parceiros/index.php">
                                <i class="bi bi-circle"></i><span>Parceiros</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if ($c_valida_administracao['c'] > 0) { ?>
            <li class="nav-heading">Administração</li>
        <?php } ?>

        <?php if ($c_nav_gerenciamento['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#gerenciamento-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-gear"></i><span>Gerenciamento</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="gerenciamento-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                    <?php if ($c_nav_sub_configuracoes['c'] == 1) { ?>
                        <li>
                            <a href="/gerenciamento/configuracao/index.php">
                                <i class="bi bi-circle"></i><span>Configurações</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_competencias['c'] == 1) { ?>
                        <li>
                            <a href="/gerenciamento/competencias/index.php">
                                <i class="bi bi-circle"></i><span>Competências</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_equipes['c'] == 1) { ?>
                        <li>
                            <a href="/gerenciamento/equipes/index.php">
                                <i class="bi bi-circle"></i><span>Equipes</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_perfil['c'] == 1) { ?>
                        <li>
                            <a href="/gerenciamento/perfil/index.php">
                                <i class="bi bi-circle"></i><span>Perfil</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_usuarios['c'] == 1) { ?>
                        <li>
                            <a href="/gerenciamento/usuarios/usuarios.php">
                                <i class="bi bi-circle"></i><span>Usuários</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if ($c_nav_gerenciamento_api['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/gerenciamento_api/index.php">
                    <i class="bi bi-gear"></i>
                    <span>Gerenciamento de API</span>
                </a>
            </li>
        <?php } ?>

        <?php if ($c_nav_relatorio['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#relatorio-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-info-circle"></i><span>Relatório</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="relatorio-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <?php if ($c_nav_sub_cadastroConsulta['c'] == 1) { ?>
                        <li>
                            <a href="/relatorios/cadastro/index.php">
                                <i class="bi bi-circle"></i><span>Cadastro Consultas</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_consultas['c'] == 1) { ?>
                        <li>
                            <a href="/relatorios/consulta/index.php">
                                <i class="bi bi-circle"></i><span>Consultas</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if ($c_nav_sistema['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#sistema-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-info-circle"></i><span>Sistema</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="sistema-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <?php if ($c_nav_sub_docAPI['c'] == 1) { ?>
                        <li>
                            <a href="/sistema/api/doc_api.php">
                                <i class="bi bi-circle"></i><span>APIs</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_changelog['c'] == 1) { ?>
                        <li>
                            <a href="/sistema/changelog.php">
                                <i class="bi bi-circle"></i><span>Changelog</span>
                            </a>
                        </li>
                    <?php } ?>


                    <?php if ($c_nav_sub_logAdmin['c'] == 1) { ?>
                        <li>
                            <a href="/sistema/log_acesso/index.php">
                                <i class="bi bi-circle"></i><span>LOG de acesso - Admin</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if ($c_nav_integracao['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#integracao-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-info-circle"></i><span>Integrações</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="integracao-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                    <?php if ($c_sub_ozmap['c'] == 1) { ?>
                        <li>
                            <a href="/integracao/ozmap/index.php">
                                <i class="bi bi-circle"></i><span>OZ Map</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_sub_telegram['c'] == 1) { ?>
                        <li>
                            <a href="/integracao/telegram/index.php">
                                <i class="bi bi-circle"></i><span>Telegram</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_sub_voalle['c'] == 1) { ?>
                        <li>
                            <a href="/integracao/voalle/index.php">
                                <i class="bi bi-circle"></i><span>Voalle</span>
                            </a>
                        </li>
                    <?php } ?>


                    <?php if ($c_sub_wr_gateway['c'] == 1) { ?>
                        <li>
                            <a href="/integracao/wr_gateway/index.php">
                                <i class="bi bi-circle"></i><span>WR Gateway</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_intZabbix['c'] == 1) { ?>
                        <li>
                            <a href="/integracao/zabbix/index.php">
                                <i class="bi bi-circle"></i><span>Zabbix</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        <?php } ?>
    </ul>

</aside>