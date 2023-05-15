<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<!-- PARTE DE CADASTROS -->
<script>
    let cadastroIP = document.querySelector("#cadastroIPAddress");
    cadastroIP.addEventListener("keydown", function(e) {
        if (e.key >= "0" && e.key <= "9" || e.key == "." || e.key == "Backspace") {

        } else {
            e.preventDefault();
        }
    });
</script>

<script>
    $("#cadastroEmpresa").change(function() {
        var empresaSelecionada = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_pop.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: empresaSelecionada
            }
        }).done(function(resposta) {
            $("#cadastroPop").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>


<script>
    $("#cadastroPop").change(function() {
        var popSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_servidor.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: popSelecionado
            }
        }).done(function(resposta) {
            $("#cadastroServidor").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<!-- PARTE DE PESQUISA -->
<script>
    $("#empresaPesquisa").change(function() {
        var empresaPesquisa = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_pop.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: empresaPesquisa
            }
        }).done(function(resposta) {
            $("#popPesquisa").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    $("#popPesquisa").change(function() {
        var popSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_servidor.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: popSelecionado
            }
        }).done(function(resposta) {
            $("#servidorPesquisa").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<!-- PARTE DE VIEW/EDIT -->
<script>
    $("#editEmpresa").change(function() {
        var empresaView = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_pop.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: empresaView
            }
        }).done(function(resposta) {
            $("#editPOP").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    $("#editPOP").change(function() {
        var popSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_servidor.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: popSelecionado
            }
        }).done(function(resposta) {
            $("#editServidor").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    let EditIP = document.querySelector("#editIPAddress");
    EditIP.addEventListener("keydown", function(e) {
        if (e.key >= "0" && e.key <= "9" || e.key == "." || e.key == "Backspace") {

        } else {
            e.preventDefault();
        }
    });
</script>

<script>
    $("#btnSalvar").click(function() {
        var dados = $("#cadastraSenhaVM").serialize();

        $.post("processa/addNovaSenha.php", dados, function(retorna) {
            $("#msg").slideDown('slow').html(retorna);

            //Limpar os campos
            $('#cadastraSenhaVM')[0].reset();

            //Apresentar a mensagem leve
            retirarMsg();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsg() {
        setTimeout(function() {
            $("#msg").slideUp('slow', function() {});
        }, 1700);
    }
</script>

<script>
    function copyToClipboard(inputId) {
        var inputElement = document.getElementById(inputId);
        var fieldValue = inputElement.value;

        // Cria um elemento de texto temporário
        var tempElement = document.createElement('textarea');
        tempElement.value = fieldValue;
        document.body.appendChild(tempElement);

        // Seleciona o texto no elemento de texto temporário
        tempElement.select();
        tempElement.setSelectionRange(0, 99999); /* Para dispositivos móveis */

        // Copia o texto selecionado para a área de transferência usando a API Clipboard
        navigator.clipboard.writeText(tempElement.value)
            .then(function() {
                // Copiado com sucesso
                console.log("Texto copiado para a área de transferência: " + tempElement.value);
                var btnCopiado = `#hbtn_${inputId}`;
                var btnCopiar = `#btn_${inputId}`;
                document.querySelector(btnCopiar).hidden = true;
                document.querySelector(btnCopiado).hidden = false;

                // Desaparecer após 2 segundos
                setTimeout(function() {
                    document.querySelector(btnCopiado).hidden = true;
                    document.querySelector(btnCopiar).hidden = false;

                }, 1000);

            })
            .catch(function(error) {
                // Ocorreu um erro ao copiar
                console.error("Erro ao copiar o texto para a área de transferência: " + error);
            })
            .finally(function() {
                // Remove o elemento de texto temporário
                document.body.removeChild(tempElement);

                // Deseleciona o campo de entrada
                inputElement.blur();
            });
    }
</script>