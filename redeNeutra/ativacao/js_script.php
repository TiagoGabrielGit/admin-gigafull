<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $("#olt").change(function() {
        var oltSelecionada = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/captura_dados_olt.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: oltSelecionada
            }
        }).done(function(resposta) {
            document.getElementById("ipOLT").value = (resposta);
            document.getElementById("userOLT").value = (resposta);
            document.getElementById("passOLT").value = (resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    document.getElementById("buttonExecutaScript").addEventListener("click", eventoExecutaScript);

    function eventoExecutaScript() {
        let obg = {}
        obg.ipOLT = document.getElementById("ipOLT").value;
        obg.userOLT = document.getElementById("userOLT").value;
        obg.passOLT = document.getElementById("passOLT").value;
        funcaoAgendaChamado('/api/executa_script.php', 'GET', obg)
    }

    function funcaoAgendaChamado(url, metodo, obg) {
        $.ajax({
            url: url,
            method: metodo,
            dataType: "HTML",
            data: obg,
        })
    }
</script>