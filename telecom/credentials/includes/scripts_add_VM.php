<!-- PARTE DE CADASTROS -->
<script>
    let cadastroIP = document.querySelector("#VMcadastroIPAddress");
    cadastroIP.addEventListener("keydown", function(e) {
        if (e.key >= "0" && e.key <= "9" || e.key == "." || e.key == "Backspace") {

        } else {
            e.preventDefault();
        }
    });
</script>

<script>
    $("#VMcadastroEmpresa").change(function() {
        var empresaSelecionada = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_pop.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: empresaSelecionada
            }
        }).done(function(resposta) {
            $("#VMcadastroPop").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>


<script>
    $("#VMcadastroPop").change(function() {
        var popSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_servidor.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: popSelecionado
            }
        }).done(function(resposta) {
            $("#VMcadastroServidor").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>