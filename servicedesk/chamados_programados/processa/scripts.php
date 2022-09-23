<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    document.getElementById("buttonAgendarChamado").addEventListener("click", eventoFuncaoAgendaChamado);

    function eventoFuncaoAgendaChamado() {
        let obg = {}
        obg.nameEvent = document.getElementById("nameEvent").value;
        obg.descEvent = document.getElementById("descEvent").value;
        obg.tipoAgendamento = document.getElementById("tipoAgendamento").value;
        obg.intervaloAgendamento = document.getElementById("intervaloAgendamento").value;
        obg.inicioAgendamento = document.getElementById("inicioAgendamento").value;
        obg.fimAgendamento = document.getElementById("fimAgendamento").value;
        obg.solicitante = document.getElementById("solicitante").value;
        obg.empresaChamado = document.getElementById("empresaChamado").value;
        obg.tipoChamado = document.getElementById("tipoChamado").value;
        obg.assuntoChamado = document.getElementById("assuntoChamado").value;
        obg.relatoChamado = document.getElementById("relatoChamado").value;
        funcaoAgendaChamado('/api/insert_programar_chamado.php', 'GET', obg)
    }

    function funcaoAgendaChamado(url, metodo, obg) {
        $.ajax({
            url: url,
            method: metodo,
            dataType: "HTML",
            data: obg,
        })
        window.location.replace("/servicedesk/chamados_programados/index.php");
    }
</script>