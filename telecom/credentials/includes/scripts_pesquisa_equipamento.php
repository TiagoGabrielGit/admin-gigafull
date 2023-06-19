<script>
    $(document).ready(function() {
        $("#EquipamentoEmpresaPesquisa").change(function() {
            var empresaSelecionada = $(this).val();

            if (empresaSelecionada) {
                $.ajax({
                    url: "/api/pesquisa_pop.php",
                    method: "GET",
                    dataType: "html",
                    data: {
                        id: empresaSelecionada
                    }
                }).done(function(resposta) {
                    $("#popPesquisa").html(resposta);
                }).fail(function(resposta) {
                    alert(resposta);
                });
            }
        });
    });
</script>


<script>
    //Pesquisa os equipamentos atraves do fabricante
    $("#EquipamentoFabricantePesquisa").change(function() {
        var fabricanteSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_equipamentos.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: fabricanteSelecionado
            }
        }).done(function(resposta) {
            $("#equipamentoPesquisa").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>