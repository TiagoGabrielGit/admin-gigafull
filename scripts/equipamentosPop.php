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
            $("#msgAlertCad").slideDown('slow').html(retorna); 

            //Limpar os campos
            document.getElementById('equipamentoDescricao').value='';
            document.getElementById('equipamentoUsuario').value='';
            document.getElementById('equipamentoSenha').value='';


            //Apresentar a mensagem leve
            retirarMsg();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsg() {
        setTimeout(function() {
            $("#msgAlertCad").slideUp('slow', function() {});
        }, 1700);
    }
</script>
