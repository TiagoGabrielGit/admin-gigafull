<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $("#btnSalvar").click(function() {
        var dadosCadastrarCompetencia = $("#cadastraCompetencia").serialize();

        $.post("processa/add.php", dadosCadastrarCompetencia, function(retornaCadastrarCompetencia) {


            if (retornaCadastrarCompetencia.includes("Error")) {
                $("#msgCadastrarCompetencia").slideDown('slow').html(retornaCadastrarCompetencia);
            } else {
                $("#modalNovaCompetencia").modal('hide'); // Fecha o modal com o ID "modalNovaCompetencia"
                location.reload(); // Atualiza a página
            }

            //Apresentar a mensagem leve
            retirarMsgSalvarCompetencia();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgSalvarCompetencia() {
        setTimeout(function() {
            $("#msgCadastrarCompetencia").slideUp('slow', function() {});
        }, 1700);
    }
</script>

<script>
    $("#btnEditar").click(function() {
        var dadosEditarCompetencia = $("#editarCompetencia").serialize();

        $.post("processa/edit.php", dadosEditarCompetencia, function(retornaEditarCompetencia) {
            $("#msgEditarCompetencia1").slideDown('slow').html(retornaEditarCompetencia);
            $("#msgEditarCompetencia2").slideDown('slow').html(retornaEditarCompetencia);

        });

        //Apresentar a mensagem leve
        retirarMsgEditarCompetencia();
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgEditarCompetencia() {
        setTimeout(function() {
            $("#msgEditarCompetencia1").slideUp('slow', function() {});
            $("#msgEditarCompetencia2").slideUp('slow', function() {});
            location.reload(); // Atualiza a página
        }, 1700);
    }
</script>