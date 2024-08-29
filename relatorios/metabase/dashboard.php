<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$submenu_id = "73";
$uid = $_SESSION['id'];

$permissions_submenu = "
    SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = :uid AND pp.url_submenu = :submenu_id";
$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->bindParam(':uid', $uid);
$exec_permissions_submenu->bindParam(':submenu_id', $submenu_id);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {
    $token = $_GET['id'];

    // Consulta ao banco de dados para obter a URL com base no token
    $query = "SELECT url, dashboard FROM metabase WHERE token = :token LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $url = $result['url'];
        $dashboard = $result['dashboard'];
    } else {
        $url = "";
    }
?>

    <main id="main" class="main">
        <section class="section">
            <div class="pagetitle">
                <div class="row">
                    <div class="col-10">
                        <h1>Dashboard - <?= htmlspecialchars($dashboard, ENT_QUOTES, 'UTF-8') ?></h1>
                    </div>
                    <div class="col-2">
                        <a href="/relatorios/metabase/index.php">
                            <button style="margin-top: 15px;" class="btn btn-sm btn-danger">Voltar a listagem</button>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Exibe o iframe com a URL obtida do banco de dados -->
            <iframe id="dashboardIframe" src="<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>" title="Conteúdo Externo" width="100%" frameborder="0"></iframe>

            <script>
                function adjustIframeHeight() {
                    var iframe = document.getElementById('dashboardIframe');
                    iframe.style.height = window.innerHeight - iframe.getBoundingClientRect().top + "px";
                }

                // Ajustar altura na carga da página
                window.onload = adjustIframeHeight;

                // Ajustar altura quando a janela for redimensionada
                window.onresize = adjustIframeHeight;
            </script>

        </section>
    </main>

<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>
