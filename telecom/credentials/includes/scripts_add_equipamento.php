<script>
    $("#EquipamentocadastroEmpresa").change(function() {
        var empresaSelecionada = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_pop.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: empresaSelecionada
            }
        }).done(function(resposta) {
            $("#EquipamentoCadastroPop").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Procura os rack's de acordo com pop selecionado
    $("#EquipamentoCadastroPop").change(function() {
        var popSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_racks.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: popSelecionado
            }
        }).done(function(resposta) {
            $("#EquipamentoCadastroRackPop").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Pesquisa os equipamentos atraves do fabricante
    $("#EquipamentoCadastroFabricante").change(function() {
        var fabricanteSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_equipamentos.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: fabricanteSelecionado
            }
        }).done(function(resposta) {
            $("#EquipamentocadastroEquipamento").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Procura os tipos de equipamentos atraves do equipamento selecionado
    $("#EquipamentocadastroEquipamento").change(function() {
        var equipamentoSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_tipos.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: equipamentoSelecionado
            }
        }).done(function(resposta) {
            $("#EquipamentoCadastroTipoEquipamento").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    let cadastroIP = document.querySelector("#EquipamentoCadastroIPAddress");
    cadastroIP.addEventListener("keydown", function(e) {
        if (e.key >= "0" && e.key <= "9" || e.key == "." || e.key == "Backspace") {

        } else {
            e.preventDefault();
        }
    });
</script>