<section class="section dashboard" style="min-height: 100vh; background-color: #ffffff;">
    <iframe id="dashboardIframe" src="<?= htmlspecialchars($_SESSION['url_dashboard'], ENT_QUOTES, 'UTF-8') ?>" title="Conteúdo Externo" width="100%" frameborder="0" style="height: 100%;"></iframe>
</section>

<script>
    function adjustIframeHeight() {
        var iframe = document.getElementById('dashboardIframe');
        var section = document.querySelector('.section.dashboard');

        // Calcular altura disponível para o iframe
        var availableHeight = window.innerHeight - iframe.getBoundingClientRect().top;
        iframe.style.height = availableHeight + "px";

        // Ajustar a altura mínima da seção para garantir que o fundo cubra a tela inteira
        section.style.minHeight = window.innerHeight + "px";
    }

    // Ajustar altura na carga da página
    window.onload = adjustIframeHeight;

    // Ajustar altura quando a janela for redimensionada
    window.onresize = adjustIframeHeight;
</script>
