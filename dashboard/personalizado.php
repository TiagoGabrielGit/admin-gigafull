<section class="section dashboard">
    <iframe id="dashboardIframe" src="<?= htmlspecialchars($_SESSION['url_dashboard'], ENT_QUOTES, 'UTF-8') ?>" title="Conteúdo Externo" width="100%" frameborder="0"></iframe>
</section>

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