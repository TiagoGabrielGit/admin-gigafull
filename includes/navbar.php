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
        </li><!-- End Dashboard Nav -->

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

        <?php if ($c_valida_cadastros['c'] > 0) { ?>
            <li class="nav-heading">Cadastros</li>
        <?php } ?>

        <?php if ($c_nav_localidades['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#Localidade-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Localidades</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="Localidade-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <?php if ($c_nav_sub_bairros['c'] == 1) { ?>
                        <li>
                            <a href="/cadastros/localidades/bairros.php">
                                <i class="bi bi-circle"></i><span>Bairros</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_cidades['c'] == 1) { ?>
                        <li>
                            <a href="/cadastros/localidades/cidades.php">
                                <i class="bi bi-circle"></i><span>Cidades</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_estados['c'] == 1) { ?>
                        <li>
                            <a href="/cadastros/localidades/estado.php">
                                <i class="bi bi-circle"></i><span>Estados</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_logradouros['c'] == 1) { ?>
                        <li>
                            <a href="/cadastros/localidades/logradouros.php">
                                <i class="bi bi-circle"></i><span>Logradouros</span>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ($c_nav_sub_pais['c'] == 1) { ?>
                        <li>
                            <a href="/cadastros/localidades/pais.php">
                                <i class="bi bi-circle"></i><span>País</span>
                            </a>
                        </li>
                    <?php } ?>

                </ul>
            </li>
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
                <a class="nav-link collapsed" href="/servicedesk/consultar_chamados/index.php?pagina=1">
                    <i class="bi bi-file-text"></i>
                    <span>Chamados</span>
                </a>
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

        <?php if ($c_nav_informativos['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#informativos-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Informativos</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="informativos-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                    <?php if ($c_nav_sub_incidentes['c'] == 1) { ?>
                        <li>
                            <a href="/servicedesk/incidentes/index.php">
                                <i class="bi bi-circle"></i><span>Incidentes</span>
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

                </ul>
            </li>
        <?php } ?>

        <?php if ($c_nav_tiposChamados['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/portal/tipos_chamados/index.php">
                    <i class="bi bi-clipboard-plus"></i>
                    <span>Tipos de Chamados</span>
                </a>
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

        <?php if ($c_nav_guardpass['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/telecom/credenciais/index.php">
                    <i class="bi bi-key"></i>
                    <span>Guardpass</span>
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

                    <?php if ($c_nav_sub_incidentes['c'] == 1) { ?>
                        <li>
                            <a href="/redeNeutra/incidentes/index.php">
                                <i class="bi bi-circle"></i><span>Incidentes</span>
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

        <?php if ($c_nav_sistema['c'] == 1) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#sistema-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-info-circle"></i><span>Sistema</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="sistema-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

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
    </ul>

</aside><!-- End Sidebar-->