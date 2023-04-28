
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $("#cpf").keypress(function() {
        $(this).mask('000.000.000-00');
    });
</script>

<script>
    $("#telefone").keypress(function() {
        $(this).mask('(00)0000-0000');
    });
</script>

<script>
    $("#celular").keypress(function() {
        $(this).mask('(00)00000-0000');
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