<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $("#btnSalvarVistoria").click(function() {
        var dadosSalvarVistoria = $("#salvarVistoria").serialize();

        $.post("/telecom/sitepop/processa/criarVistoria.php", dadosSalvarVistoria, function(retornaSalvarVistoria) {
            $("#msgSalvarVistoria").slideDown('slow').html(retornaSalvarVistoria);


            //Limpar os campos
            $('#salvarVistoria')[0].reset();

            //Apresentar a mensagem leve
            retirarMsgSalvarVistoria();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgSalvarVistoria() {
        setTimeout(function() {
            $("#msgSalvarVistoria").slideUp('slow', function() {});
        }, 1700);
    }
</script>

<script>
    function buscarDados() {
        var dataSelecionada = $('#data-select').val(); // Obter o valor selecionado no <select>

        // Fazer a solicitação AJAX para buscar os dados no servidor
        $.ajax({
            url: 'processa/buscar_dados.php', // URL do script PHP que buscará os dados no banco de dados
            type: 'POST',
            data: {
                data: dataSelecionada
            }, // Enviar a data selecionada como parâmetro
            success: function(responseBuscaDados) {
                // Preencher os campos no código HTML com base nos dados retornados
                $('#buscaLimpezaVistoria').val(responseBuscaDados.buscaLimpezaVistoria);
                $('#buscaOrganizacaoVistoria').val(responseBuscaDados.buscaOrganizacaoVistoria);
                $('#buscaResponsavelVistoria').val(responseBuscaDados.buscaResponsavelVistoria);
                $('#buscaObsGeralVistoria').val(responseBuscaDados.buscaObsGeralVistoria);
            },
            error: function() {
                alert('Erro ao buscar os dados.'); // Exibir mensagem de erro, se ocorrer algum problema
            }
        });
    }
</script>