<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    document.getElementById("buttonCadastraOLT").addEventListener("click", eventoFuncaoCadastraOLT);

    function eventoFuncaoCadastraOLT() {
        let obg = {}
        obg.nomeOLT = document.getElementById("nomeOLT").value;
        obg.ipOLT = document.getElementById("ipOLT").value;
        obg.usuarioOLT = document.getElementById("usuarioOLT").value;
        obg.senhaOLT = document.getElementById("senhaOLT").value;
        funcaoCadastraOLT('/api/insert_cadastra_olt.php', 'GET', obg)
    }

    function funcaoCadastraOLT(url, metodo, obg) {
        $.ajax({
            url: url,
            method: metodo,
            dataType: "HTML",
            data: obg,
        })
        window.location.replace("/redeNeutra/olts/index.php");
    }
</script>