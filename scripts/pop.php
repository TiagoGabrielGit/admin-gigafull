<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>


<script>
    //Pesquisa os bairros passando ID da cidade
    $("#cidade").change(function() {
        var cidadeSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_bairro.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: cidadeSelecionado
            }
        }).done(function(resposta) {
            $("#bairro").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>


<script>
    //Pesquisa os logradouros passando ID do bairro
    $("#bairro").change(function() {
        var bairroSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_logradouro.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: bairroSelecionado
            }
        }).done(function(resposta) {
            $("#logradouro").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Pesquisa o CEP passando ID do logradouro
    $("#logradouro").change(function() {
        var logradouroSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_cep.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: logradouroSelecionado
            }
        }).done(function(resposta) {
            $("#cep").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>