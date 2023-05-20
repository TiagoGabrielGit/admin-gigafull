<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="/index.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">Service Desk</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="/servicedesk/consultar_chamados/index.php?pagina=1">
                <i class="bi bi-file-text"></i>
                <span>Chamados</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#informativos-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Informativos</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="informativos-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/servicedesk/incidentes/index.php">
                        <i class="bi bi-circle"></i><span>Incidentes</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#redeNeutra-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Rede Neutra</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="redeNeutra-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/redeNeutra/ativacao/index.php">
                        <i class="bi bi-circle"></i><span>Ativação</span>
                    </a>
                </li>
                <li>
                    <a href="/redeNeutra/onus_Provisionadas/index.php">
                        <i class="bi bi-circle"></i><span>ONUs Provisionadas</span>
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