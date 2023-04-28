<!-- PARTE DE PESQUISA -->
<script>
    $("#VMempresaPesquisa").change(function() {
        var empresaPesquisa = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_pop.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: empresaPesquisa
            }
        }).done(function(resposta) {
            $("#VMpopPesquisa").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script> 

<script>
    $("#VMpopPesquisa").change(function() {
        var popSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_servidor.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: popSelecionado
            }
        }).done(function(resposta) {
            $("#VMservidorPesquisa").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>