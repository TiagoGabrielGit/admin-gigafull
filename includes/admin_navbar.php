<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="/index.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">CRM</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/contrato/index.php">
                <i class="bi bi-chevron-contract"></i>
                <span>Contratos</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/empresas/empresas.php">
                <i class="bi bi-person-fill"></i>
                <span>Empresas</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/pessoas/pessoas.php">
                <i class="bi bi-person"></i>
                <span>Pessoas</span>
            </a>
        </li>

        <li class="nav-heading">Cadastros</li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#Localidade-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Localidades</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="Localidade-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/cadastros/localidades/bairros.php">
                        <i class="bi bi-circle"></i><span>Bairros</span>
                    </a>
                </li>

                <li>
                    <a href="/cadastros/localidades/cidades.php">
                        <i class="bi bi-circle"></i><span>Cidades</span>
                    </a>
                </li>

                <li>
                    <a href="/cadastros/localidades/estado.php">
                        <i class="bi bi-circle"></i><span>Estados</span>
                    </a>
                </li>

                <li>
                    <a href="/cadastros/localidades/logradouros.php">
                        <i class="bi bi-circle"></i><span>Logradouros</span>
                    </a>
                </li>

                <li>
                    <a href="/cadastros/localidades/pais.php">
                        <i class="bi bi-circle"></i><span>País</span>
                    </a>
                </li>

            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#Produtos-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Produtos e Serviços</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="Produtos-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                <li>
                    <a href="/cadastros/produtos/fabricantes/fabricantes.php">
                        <i class="bi bi-circle"></i><span>Fabricantes</span>
                    </a>
                </li>

                <li>
                    <a href="/cadastros/produtos/produtos/index.php">
                        <i class="bi bi-circle"></i><span>Produtos</span>
                    </a>
                </li>

                <li>
                    <a href="/cadastros/produtos/servicos/index.php">
                        <i class="bi bi-circle"></i><span>Serviços</span>
                    </a>
                </li>

                <li>
                    <a href="/cadastros/produtos/sistemaoperacional/index.php">
                        <i class="bi bi-circle"></i><span>Sistema Operacional</span>
                    </a>
                </li>

                <li>
                    <a href="/cadastros/produtos/tiposequipamentos/index.php">
                        <i class="bi bi-circle"></i><span>Tipos de Equipamentos</span>
                    </a>
                </li>
            </ul>

        <li class="nav-heading">Service Desk</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/servicedesk/consultar_chamados/index.php">
                <i class="bi bi-file-text"></i>
                <span>Chamados</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/servicedesk/chamados_programados/index.php">
                <i class="bi bi-file-text"></i>
                <span>Chamados Programados</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link collapsed" href="/portal/tipos_chamados/index.php">
                <i class="bi bi-clipboard-plus"></i>
                <span>Tipos de Chamados</span>
            </a>
        </li>

        <li class="nav-heading">Telecom</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/telecom/credenciais/index.php">
                <i class="bi bi-key"></i>
                <span>Guardpass</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/telecom/sitepop/index.php">
                <i class="bi bi-globe"></i>
                <span>POP/Site</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/telecom/equipamentos/index.php">
                <i class="bi bi-hdd-rack"></i>
                <span>Equipamentos</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/telecom/vms/index.php">
                <i class="bi bi-pc-display-horizontal"></i>
                <span>Máquina Virtual - VM</span>
            </a>
        </li>

        <li class="nav-heading">Administração</li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#gerenciamento-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gear"></i><span>Gerenciamento</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="gerenciamento-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                <li>
                    <a href="/gerenciamento/equipes/index.php">
                        <i class="bi bi-circle"></i><span>Equipes</span>
                    </a>
                </li>

                <li>
                    <a href="/gerenciamento/log_acesso/index.php">
                        <i class="bi bi-circle"></i><span>LOG de acesso - Admin</span>
                    </a>
                </li>

                <li>
                    <a href="/gerenciamento/usuarios/usuarios.php">
                        <i class="bi bi-circle"></i><span>Usuários - Admin</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="/portal/usuarios/index.php">
                        <i class="bi bi-person-circle"></i>
                        <span>Usuários - Portal</span>
                    </a>
                </li>

            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#sistema-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-info-circle"></i><span>Sistema</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="sistema-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                <li>
                    <a href="/sistema/changelog.php">
                        <i class="bi bi-circle"></i><span>Changelog</span>
                    </a>
                </li>

            </ul>
        </li>

    </ul>

</aside><!-- End Sidebar-->