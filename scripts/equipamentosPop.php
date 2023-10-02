<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>



<!-- PARTE DE CADASTROS -->
<script>
    //Procura os tipos de equipamentos atraves do equipamento selecionado
    $("#cadastroEquipamento").change(function() {
        var equipamentoSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_tipos.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: equipamentoSelecionado
            }
        }).done(function(resposta) {
            $("#cadastroTipoEquipamento").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>


<script>
    //Pesquisa os equipamentos atraves do fabricante
    $("#fabricante").change(function() {
        var fabricanteSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_equipamentos.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: fabricanteSelecionado
            }
        }).done(function(resposta) {
            $("#equipamento").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    $("#selecionaEmpresa").change(function() {
        var empresaSelecionada = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_pop.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: empresaSelecionada
            }
        }).done(function(resposta) {
            $("#listaPop").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Pesquisa os equipamentos atraves do fabricante
    $("#cadastroFabricante").change(function() {
        var fabricanteSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_equipamentos.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: fabricanteSelecionado
            }
        }).done(function(resposta) {
            $("#cadastroEquipamento").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
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


<!-- PARTE DE PESQUISAS -->

<script>
    $("#empresaPesquisa").change(function() {
        var empresaSelecionada = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_pop.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: empresaSelecionada
            }
        }).done(function(resposta) {
            $("#popPesquisa").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Pesquisa os equipamentos atraves do fabricante
    $("#fabricantePesquisa").change(function() {
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

<!-- PARTE DE VIEW -->
<script>
    //Pesquisa os equipamentos atraves do fabricante
    $("#inputFabricante").change(function() {
        var fabricanteSelecionadoView = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_equipamentos.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: fabricanteSelecionadoView
            }
        }).done(function(resposta) {
            $("#inputEquipamento").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Procura os tipos de equipamentos atraves do equipamento selecionado
    $("#inputEquipamento").change(function() {
        var equipamentoSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_tipos.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: equipamentoSelecionado
            }
        }).done(function(resposta) {
            $("#inputTipoEquipamento").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Procura os racks de acordo com o POP selecionado
    $("#editEquipamentoPop").change(function() {
        var popSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_racks.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: popSelecionado
            }
        }).done(function(resposta) {
            $("#editEquipamentoRack1").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Procura os pop de acordo com a emresa selecionada
    $("#inputEmpresa").change(function() {
        var empresaSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_pop.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: empresaSelecionado
            }
        }).done(function(resposta) {
            $("#editEquipamentoPop").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Procura os rack's de acordo com pop selecionado
    $("#cadastroPop").change(function() {
        var popSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_racks.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: popSelecionado
            }
        }).done(function(resposta) {
            $("#rackPop").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>


<script>
    $("#btnSalvar").click(function() {
        var dados = $("#cadastraSenhaEquipamento").serialize();

        $.post("processa/addNovaSenha.php", dados, function(retorna) {

            if (retorna.includes("Error")) {
                $("#msgAlertCad").slideDown('slow').html(retorna);
                retirarMsg();
            } else {
                var idRegistroCriado = retorna; // O ID do registro retornado pelo servidor
                window.location.href = '/telecom/credentials/equipamentos/credenciais/view.php?id=' + idRegistroCriado;
            }
        });
    });

    // Retirar a mensagem após 1700 milissegundos
    function retirarMsg() {
        setTimeout(function() {
            $("#msgAlertCad").slideUp('slow', function() {});
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