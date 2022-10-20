<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    document.getElementById("buttonCadastraParceiro").addEventListener("click", eventoFuncaoCadastraParceiro);

    function eventoFuncaoCadastraParceiro() {
        let obg = {}
        obg.parceiro = document.getElementById("parceiro").value;
        obg.codigoParceiro = document.getElementById("codigoParceiro").value;

        funcaoCadastraOLT('/api/insert_cadastra_parceiro.php', 'GET', obg)
    }

    function funcaoCadastraOLT(url, metodo, obg) {
        $.ajax({
            url: url,
            method: metodo,
            dataType: "HTML",
            data: obg,
        })
        window.location.replace("/redeNeutra/parceiros/index.php");
    }
</script>