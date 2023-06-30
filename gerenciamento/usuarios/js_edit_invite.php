<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    // Obtém uma referência ao formulário
    const statusForm = document.getElementById('statusForm');

    // Adiciona um ouvinte de eventos ao formulário
    statusForm.addEventListener('change', function(event) {
        // Verifica se o elemento clicado é um radio button
        if (event.target.type === 'radio' && event.target.name === 'status') {
            // Envia o formulário
            statusForm.submit();
        }
    });
</script> 

<script>
    document.getElementById("copiarURL").addEventListener("click", function(event) {
        event.preventDefault();

        var token = "<?= $result['token'] ?>";
        var protocol = window.location.protocol;
        var domain = "<?= $_SERVER['HTTP_HOST'] ?>";
        var url = protocol + "//" + domain + "/invite.php?token=" + token;
        var input = document.createElement("input");
        input.value = url;
        document.body.appendChild(input);
        input.select();
        document.execCommand("copy");
        document.body.removeChild(input);

        alert("URL copiada com sucesso!");
    });
</script>