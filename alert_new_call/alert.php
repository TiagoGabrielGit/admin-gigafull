<audio id="alertSound">
    <source src="/alert_new_call/novo_chamado.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>

<script>
    function playAlertSound() {
        var audio = document.getElementById("alertSound");
        audio.play();
    }

    function handleUserInteraction() {
        playAlertSound();
    }
</script>

<script>
    function checkForNewCalls() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "/alert_new_call/check_new_calls.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var newCallsCount = parseInt(xhr.responseText);
                if (newCallsCount > 0) {
                    playAlertSound();
                }
            }
        };
        xhr.send();
    }

    // Verifique a cada 30 segundos se há novos chamados
    setInterval(checkForNewCalls, 30000);
</script>

<button onclick="handleUserInteraction()">Reproduzir Alerta Sonoro</button>
