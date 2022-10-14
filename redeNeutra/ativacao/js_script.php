<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $("#parceiro").change(function() {
        var parceiroSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/captura_olts_liberadas.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: parceiroSelecionado
            }
        }).done(function(resposta) {
            $("#olt").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    $("#olt").change(function() {
        var oltSelecionada = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/captura_dados_olt.php",
            method: "GET",
            dataType: "JSON",
            data: {
                id: oltSelecionada
            }
        }).done(function(resposta) {
            document.getElementById("ipOLT").value = '';
            document.getElementById("userOLT").value = '';
            document.getElementById("passOLT").value = '';

            document.getElementById("ipOLT").value = (resposta.ipOLT);
            document.getElementById("userOLT").value = (resposta.userOLT);
            document.getElementById("passOLT").value = (resposta.passOLT);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    $("#olt").change(function() {
        var oltSelecionada = $("#olt").children("option:selected").val();
        var parceiroSelecionado = $("#parceiro").children("option:selected").val();

        $.ajax({
            url: "/api/captura_dados_profile.php",
            method: "GET",
            dataType: "JSON",
            data: {
                idOLT: oltSelecionada,
                idParceiro: parceiroSelecionado
            }

        }).done(function(resposta) {
            document.getElementById("line_profile_id").value = '';
            document.getElementById("srv_profile_id").value = '';
            document.getElementById("CVLAN").value = '';
            document.getElementById("SVLAN").value = '';

            document.getElementById("line_profile_id").value = (resposta.line_profile_id);
            document.getElementById("srv_profile_id").value = (resposta.srv_profile_id);
            document.getElementById("CVLAN").value = (resposta.CVLAN);
            document.getElementById("SVLAN").value = (resposta.SVLAN);
            document.getElementById("GEMPORT").value = (resposta.GEMPORT);

        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    $("#parceiro").change(function() {
        var parceiroSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/captura_codigo_parceiro.php",
            method: "GET",
            dataType: "JSON",
            data: {
                id: parceiroSelecionado
            }
        }).done(function(resposta) {
            document.getElementById("codigoParceiro").value = '';
            document.getElementById("codigoParceiro").value = (resposta.codigoParceiro);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    document.getElementById("buttonExecutaScript").addEventListener("click", eventoExecutaScript);

    async function eventoExecutaScript() {
        document.querySelector("#buttonExecutaScript").hidden = true;
        document.querySelector("#buttonExecutandoScript").hidden = false;

        let obg = {}
        obg.ipOLT = document.getElementById("ipOLT").value;
        obg.userOLT = document.getElementById("userOLT").value;
        obg.passOLT = document.getElementById("passOLT").value;
        obg.slotOLT = document.getElementById("slotOLT").value;
        obg.ponOLT = document.getElementById("ponOLT").value;
        obg.CVLAN = document.getElementById("CVLAN").value;
        obg.SVLAN = document.getElementById("SVLAN").value;
        obg.GEMPORT = document.getElementById("GEMPORT").value;
        obg.line_profile_id = document.getElementById("line_profile_id").value;
        obg.srv_profile_id = document.getElementById("srv_profile_id").value;
        obg.codigoParceiro = document.getElementById("codigoParceiro").value;
        obg.codigoReserva = document.getElementById("codigoReserva").value;
        obg.serialONU = document.getElementById("serialONU").value;
        obg.parceiro = document.getElementById("parceiro").value;
        obg.olt = document.getElementById("olt").value;

        const retorno = await funcaoExecutaScript('executa_script.php', 'GET', obg)

        document.querySelector("#buttonExecutaScript").hidden = false;
        document.querySelector("#buttonExecutandoScript").hidden = true;
        document.querySelector("#loadingProvisionamento").hidden = false;
        document.querySelector("#resultScript > textarea").value = retorno;
        document.querySelector("#loadingProvisionamento").hidden = true;
        document.querySelector("#timer").hidden = true;
        document.querySelector("#spanMensagem").textContent = "PROVISIONADA COM SUCESSO"
        document.querySelector("#irParaONU").hidden = false;
        document.querySelector("#okProvisionamento").hidden = false;
    }

    async function funcaoExecutaScript(url, metodo, obg) {
        return $.ajax({
            url: url,
            method: metodo,
            dataType: "HTML",
            data: obg,
        })
    }
</script>

<script>
    document.getElementById("buttonExecutaScript").addEventListener("click", funcaoContador);

    function startTimer(duration, display) {
        var timer = duration,
            minutes, seconds;

        const intervalo = setInterval(function() {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;
            display.textContent = seconds + "s";
            if (--timer < 0) {
                clearInterval(intervalo);
                document.querySelector("#loadingProvisionamento").hidden = true;
                document.querySelector("#buttonExecutaScript").hidden = false;
                document.querySelector("#buttonExecutandoScript").hidden = true;
                document.getElementById("timer").innerHTML = "FALHA AO PROVISIONAR";
                document.querySelector("#okProvisionamento").hidden = false;
            }
        }, 1000);
    }

    function funcaoContador() {
        var duration = 30 * 1; // Converter para segundos
        display = document.querySelector('#timer'); // selecionando o timer
        startTimer(duration, display); // iniciando o timer
    };
</script>