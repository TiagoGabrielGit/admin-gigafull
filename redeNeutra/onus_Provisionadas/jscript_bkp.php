<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", eventoDiagONU());

    async function eventoDiagONU() {
        document.querySelector("#loadingDiagONU").hidden = false

        let diag = {}
        diag.idOLT = document.getElementById("idOLT").value;
        diag.slotOLT = document.getElementById("slotOLT").value;
        diag.ponOLT = document.getElementById("ponOLT").value;
        diag.idONU = document.getElementById("idONU").value;

        const retornoDiag = await funcaoDiagONU('scripts/diag_onu.php', 'GET', diag)

        document.querySelector("#loadingDiagONU").hidden = true
        document.querySelector("#diagONU").hidden = false

        document.querySelector("#descONU").value = retornoDiag.descricao
        document.querySelector("#serialONU").value = retornoDiag.serial

        if (retornoDiag.estado == "online") {
            document.querySelector("#statusONUOnline").hidden = false
            document.querySelector("#statusONUOnline").value = retornoDiag.estado
            document.querySelector("#infosConexao").hidden = false
            document.querySelector("#sinalONU").value = retornoDiag.sinalONU
            document.querySelector("#sinalOLT").value = retornoDiag.sinalOLT
            document.querySelector("#temperaturaONU").value = retornoDiag.temperaturaONU

            let obg = {}
            obg.id_onu = document.getElementById("provID").value;

            obg.signal = "Sinal RX da ONU coletado através da consulta de ONU. Sinal " + await retornoDiag.sinalONU;

            funcaoRegisterLOG('/api/insert_register_log_onu.php', 'GET', obg)

            function funcaoRegisterLOG(url, metodo, obg) {
                $.ajax({
                    url: url,
                    method: metodo,
                    dataType: "HTML",
                    data: obg,
                })
            }

        } else if (retornoDiag.estado == "offline") {
            document.querySelector("#statusONUOffline").hidden = false
            document.querySelector("#statusONUOffline").value = retornoDiag.estado
        }

        if (retornoDiag.estado == "offline") {
            document.querySelector("#causeONU").value = retornoDiag.cause
            document.querySelector("#causeTime").value = retornoDiag.causeTime
            document.querySelector("#infosDesconexao").hidden = false
        }

    }

    async function funcaoDiagONU(url, metodo, diag) {
        return $.ajax({
            url: url,
            method: metodo,
            dataType: "json",
            data: diag,
        })
    }
</script>

<script>
    document.getElementById("btnConsultaConfiguracoes").addEventListener("click", eventoConsultaConfig);

    async function eventoConsultaConfig() {
        document.querySelector("#btnConsultaConfiguracoes").hidden = true;
        document.querySelector("#btnConsultandoConfiguracoes").hidden = false;

        let obg = {}
        obg.idOLT = document.getElementById("idOLT").value;
        obg.slotOLT = document.getElementById("slotOLT").value;
        obg.ponOLT = document.getElementById("ponOLT").value;
        obg.idONU = document.getElementById("idONU").value;

        const retorno = await funcaoExecutaScript('scripts/currentConfigONU.php', 'GET', obg)

        document.querySelector("#btnConsultaConfiguracoes").hidden = false;
        document.querySelector("#btnConsultandoConfiguracoes").hidden = true;

        document.querySelector("#resultadoScripts").value = retorno
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

<!--HOMOLOGAÇÃO-->
<script>
    document.getElementById("confirmarModalReiniciar").addEventListener("click", eventoReiniciar);
    document.querySelector("#msgModalReiniciar").hidden = false;


    async function eventoReiniciar() {
        document.querySelector("#confirmarModalReiniciar").hidden = true;
        document.querySelector("#voltarModalReiniciar").hidden = true;
        document.querySelector("#msgModalReiniciar").hidden = true;
        document.querySelector("#msgModalReiniciando").hidden = false;

        let obg = {}
        obg.idOLT = document.getElementById("idOLT").value;
        obg.slotOLT = document.getElementById("slotOLT").value;
        obg.ponOLT = document.getElementById("ponOLT").value;
        obg.idONU = document.getElementById("idONU").value;

        const retorno = await funcaoResetar('scripts/reiniciarONU.php', 'GET', obg)
        document.querySelector("#msgReiniciar").textContent = "Operação concluida.";
        document.querySelector("#msgModalReiniciando").hidden = true;
        document.querySelector("#okModalReiniciar").hidden = false;

        document.querySelector("#resultadoScripts").value = retorno
    }

    async function funcaoResetar(url, metodo, obg) {
        return $.ajax({
            url: url,
            method: metodo,
            dataType: "HTML",
            data: obg,
        })
    }
</script>
<!--HOMOLOGAÇÃO-->

<script>
    document.getElementById("confirmarModalResetar").addEventListener("click", eventoResetar);
    document.querySelector("#msgModalResetar").hidden = false;


    async function eventoResetar() {
        document.querySelector("#confirmarModalResetar").hidden = true;
        document.querySelector("#voltarModalResetar").hidden = true;
        document.querySelector("#msgModalResetar").hidden = true;
        document.querySelector("#msgModalResetando").hidden = false;

        let obg = {}
        obg.idOLT = document.getElementById("idOLT").value;
        obg.slotOLT = document.getElementById("slotOLT").value;
        obg.ponOLT = document.getElementById("ponOLT").value;
        obg.idONU = document.getElementById("idONU").value;

        const retorno = await funcaoResetar('scripts/resetONU.php', 'GET', obg)
        document.querySelector("#msgResetar").textContent = "Operação concluida.";
        document.querySelector("#msgModalResetando").hidden = true;
        document.querySelector("#okModalResetar").hidden = false;

        document.querySelector("#resultadoScripts").value = retorno
    }

    async function funcaoResetar(url, metodo, obg) {
        return $.ajax({
            url: url,
            method: metodo,
            dataType: "HTML",
            data: obg,
        })
    }
</script>




<script>
    idProvisionamento = document.getElementById("idProvisionamento").value;
    document.querySelector("#msgModalDesprovisionar").hidden = false;

    async function desprovisionar() {
        document.querySelector("#confirmarModalDesprovisionar").hidden = true;
        document.querySelector("#voltarModalDesprovisionar").hidden = true;
        document.querySelector("#msgModalDesprovisionar").hidden = true;
        document.querySelector("#msgModalDesprovisionando").hidden = false;

        let desp = {}
        desp.idOLT = document.getElementById("idOLT").value;
        desp.slotOLT = document.getElementById("slotOLT").value;
        desp.ponOLT = document.getElementById("ponOLT").value;
        desp.idONU = document.getElementById("idONU").value;

        const retornoDesp = await funcaoDesprovisionar('scripts/desprovisionar.php', 'GET', desp)

        if (retornoDesp == "sucesso") {
            document.querySelector("#msgModalDesprovisionando").hidden = true;
            document.querySelector("#msgDesprovisionamento").textContent = "Desprovisionado com sucesso.";
            document.querySelector("#okModalDesprovisionar").hidden = false;
            funcaoAtualizaCadasatro('inativaProvisionamento.php', 'GET', idProvisionamento)
        } else if (retornoDesp == "falha") {
            document.querySelector("#msgModalDesprovisionando").hidden = true;
            document.querySelector("#voltarModalDesprovisionar").hidden = false;
            document.querySelector("#msgDesprovisionamento").textContent = "Erro ao desprovisionar.";
        } else if (retornoDesp == "falhafalha") {
            document.querySelector("#msgModalDesprovisionando").hidden = true;
            document.querySelector("#voltarModalDesprovisionar").hidden = false;
            document.querySelector("#msgDesprovisionamento").textContent = "Erro ao desprovisionar.";
        }
    }

    async function funcaoDesprovisionar(url, metodo, desp) {
        return $.ajax({
            url: url,
            method: metodo,
            dataType: "HTML",
            data: desp,
        })
    }

    function funcaoAtualizaCadasatro(url, metodo, idProvisionamento) {
        return $.ajax({
            url: url,
            method: metodo,
            dataType: "HTML",
            data: {
                id: idProvisionamento
            }
        })
    }
</script>

<script>
    document.getElementById("btnConsultaPortasLAN").addEventListener("click", eventoPortasLAN);

    async function eventoPortasLAN() {
        document.querySelector("#btnConsultaPortasLAN").hidden = true;
        document.querySelector("#btnConsultandoPortasLAN").hidden = false;

        let obg = {}
        obg.idOLT = document.getElementById("idOLT").value;
        obg.slotOLT = document.getElementById("slotOLT").value;
        obg.ponOLT = document.getElementById("ponOLT").value;
        obg.idONU = document.getElementById("idONU").value;

        const retorno = await funcaoPortasLAN('scripts/consultaPortasLAN.php', 'GET', obg)

        document.querySelector("#btnConsultaPortasLAN").hidden = false;
        document.querySelector("#btnConsultandoPortasLAN").hidden = true;

        document.querySelector("#resultadoScripts").value = retorno
    }


    async function funcaoPortasLAN(url, metodo, obg) {
        return $.ajax({
            url: url,
            method: metodo,
            dataType: "HTML",
            data: obg,
        })
    }
</script>

<script>
    document.getElementById("btnConsultaUltimosLogs").addEventListener("click", eventoUltimosLOGs);

    async function eventoUltimosLOGs() {
        document.querySelector("#btnConsultaUltimosLogs").hidden = true;
        document.querySelector("#btnConsultandoUltimosLogs").hidden = false;

        let obg = {}
        obg.idOLT = document.getElementById("idOLT").value;
        obg.slotOLT = document.getElementById("slotOLT").value;
        obg.ponOLT = document.getElementById("ponOLT").value;
        obg.idONU = document.getElementById("idONU").value;

        const retorno = await funcaoUltimosLOGs('scripts/consultaUltimosLOGs.php', 'GET', obg)

        document.querySelector("#btnConsultaUltimosLogs").hidden = false;
        document.querySelector("#btnConsultandoUltimosLogs").hidden = true;
        document.querySelector("#resultadoScripts").value = retorno
    }

    async function funcaoUltimosLOGs(url, metodo, obg) {
        return $.ajax({
            url: url,
            method: metodo,
            dataType: "HTML",
            data: obg,
        })
    }
</script>

<script>
    document.getElementById("buttonExecutaTAG").addEventListener("click", eventoExecutaTAG);

    async function eventoExecutaTAG() {
        document.querySelector("#buttonExecutaTAG").hidden = true;
        document.querySelector("#buttonExecutandoTAG").hidden = false;

        let obg = {}
        obg.idOLT = document.getElementById("idOLT").value;
        obg.slotOLT = document.getElementById("slotOLT").value;
        obg.ponOLT = document.getElementById("ponOLT").value;
        obg.idONU = document.getElementById("idONU").value;
        obg.tipoVLAN = document.getElementById("tipoVLAN").value;
        obg.VLAN = document.getElementById("VLAN").value;

        obg.LAN1 = document.getElementById("LAN1")
        obg.LAN2 = document.getElementById("LAN2")
        obg.LAN3 = document.getElementById("LAN3")
        obg.LAN4 = document.getElementById("LAN4")

        if (obg.LAN1.checked == true && obg.tipoVLAN == 2) {
            obg.LAN1 = `ont port native-vlan ${obg.ponOLT} ${obg.idONU} eth 1 vlan ${obg.VLAN} priority 0`
        } else if (obg.LAN1.checked == true && obg.tipoVLAN == 1) {
            obg.LAN1 = `ont port  vlan ${obg.ponOLT} ${obg.idONU} eth 1 translation ${obg.VLAN} user-vlan ${obg.VLAN}`
        } else {
            obg.LAN1 = ""
        }

        if (obg.LAN2.checked == true && obg.tipoVLAN == 2) {
            obg.LAN2 = `ont port native-vlan ${obg.ponOLT} ${obg.idONU} eth 2 vlan ${obg.VLAN} priority 0`
        } else if (obg.LAN2.checked == true && obg.tipoVLAN == 1) {
            obg.LAN2 = `ont port  vlan ${obg.ponOLT} ${obg.idONU} eth 2 translation ${obg.VLAN} user-vlan ${obg.VLAN}`
        } else {
            obg.LAN2 = ""
        }

        if (obg.LAN3.checked == true && obg.tipoVLAN == 2) {
            obg.LAN3 = `ont port native-vlan ${obg.ponOLT} ${obg.idONU} eth 3 vlan ${obg.VLAN} priority 0`
        } else if (obg.LAN3.checked == true && obg.tipoVLAN == 1) {
            obg.LAN3 = `ont port  vlan ${obg.ponOLT} ${obg.idONU} eth 3 translation ${obg.VLAN} user-vlan ${obg.VLAN}`
        } else {
            obg.LAN3 = ""
        }

        if (obg.LAN4.checked == true && obg.tipoVLAN == 2) {
            obg.LAN4 = `ont port native-vlan ${obg.ponOLT} ${obg.idONU} eth 4 vlan ${obg.VLAN} priority 0`
        } else if (obg.LAN4.checked == true && obg.tipoVLAN == 1) {
            obg.LAN4 = `ont port  vlan ${obg.ponOLT} ${obg.idONU} eth 4 translation ${obg.VLAN} user-vlan ${obg.VLAN}`
        } else {
            obg.LAN4 = ""
        }
        const retorno = await funcaoExecutaTAG('scripts/addTAG.php', 'GET', obg)

        document.querySelector("#buttonExecutandoTAG").hidden = true;
        document.querySelector("#buttonExecutadoTAG").hidden = false;
    }

    async function funcaoExecutaTAG(url, metodo, obg) {
        return $.ajax({
            url: url,
            method: metodo,
            dataType: "HTML",
            data: obg,
        })
    }
</script>