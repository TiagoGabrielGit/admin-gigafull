<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $("#cep").keypress(function() {
        $(this).mask('00.000-000');
    });
</script>

<script>
    //Pesquisa os estados passando ID do país
    $("#pais").change(function() {
        var paisselecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_estado.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: paisselecionado
            }
        }).done(function(resposta) {
            $("#estado").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Pesquisa as cidades passando ID do estado
    $("#estado").change(function() {
        var estadoSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_cidade.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: estadoSelecionado
            }
        }).done(function(resposta) {
            $("#cidade").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

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