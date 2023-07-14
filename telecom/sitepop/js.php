<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

<script>
    $(document).ready(function() {
        $('#cep').inputmask('99999-999');
    });
</script>

<script>
    function buscarEnderecoPorCep() {
        var cep = document.getElementById('cep').value;

        // Fazer a chamada à API de CEP
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    throw new Error('CEP incorreto');
                }
                preencherCamposEndereco(data);
            })
            .catch(error => exibirErro(error));
    }

    function exibirErro(error) {
        console.error(error);
        var mensagemErro = document.getElementById('mensagem-erro');
        mensagemErro.textContent = 'CEP incorreto. Por favor, verifique o valor digitado.';

        document.getElementById('ibgecode').value = '';
        document.getElementById('logradouro').value = '';
        document.getElementById('bairro').value = '';
        document.getElementById('cidade').value = '';
        document.getElementById('estado').value = '';
        document.getElementById('ibgecode').readOnly = true;
        document.getElementById('logradouro').readOnly = true;
        document.getElementById('bairro').readOnly = true;
        document.getElementById('cidade').readOnly = true;
        document.getElementById('estado').readOnly = true;

        // Remover mensagem de erro após 2 segundos
        setTimeout(() => {
            mensagemErro.textContent = '';
        }, 2000);
    }

    function preencherCamposEndereco(data) {
        if (!data.erro) {
            if (data.logradouro !== '') {
                document.getElementById('logradouro').value = data.logradouro;
                document.getElementById('logradouro').readOnly = true;
            } else {
                document.getElementById('logradouro').value = "";
                document.getElementById('logradouro').readOnly = false;
            }

            if (data.bairro !== '') {
                document.getElementById('bairro').value = data.bairro;
                document.getElementById('bairro').readOnly = true;
            } else {
                document.getElementById('bairro').value = "";
                document.getElementById('bairro').readOnly = false;
            }

            document.getElementById('cidade').value = data.localidade;
            document.getElementById('cidade').readOnly = true;
            document.getElementById('estado').value = data.uf;
            document.getElementById('estado').readOnly = true;
            document.getElementById('ibgecode').value = data.ibge;
            document.getElementById('ibgecode').readOnly = true;
        } else {
            // Desbloquear todos os campos caso o endereço não seja encontrado
            document.getElementById('logradouro').readOnly = false;
            document.getElementById('bairro').readOnly = false;
            document.getElementById('cidade').readOnly = false;
            document.getElementById('estado').readOnly = false;
        }
    }
</script>

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

        $.ajax({
            url: "processa/buscar_vistorias.php",
            method: "POST",
            dataType: "HTML",
            data: {
                data: dataSelecionada
            }
        }).done(function(responseBuscaVistorias) {
            $("#equipamento-select").html(responseBuscaVistorias);
        }).fail(function(responseBuscaVistorias) {
            alert(responseBuscaVistorias)
        });
    }
</script>

<script>
    function buscarDadosEquipamento() {
        var idVistoriaEquipamento = $('#equipamento-select').val();
        // Fazer a solicitação AJAX para buscar os dados no servidor
        $.ajax({
            url: 'processa/buscar_vistoria_equipamento.php', // URL do script PHP que buscará os dados no banco de dados
            type: 'POST',
            data: {
                id: idVistoriaEquipamento
            }, // Enviar a data selecionada como parâmetro
            success: function(responseVistoriaEquipamentos) {
                // Preencher os campos no código HTML com base nos dados retornados
                $('#resultEnergia').val(responseVistoriaEquipamentos.energia);
                $('#resultLimpeza').val(responseVistoriaEquipamentos.limpeza);
                $('#resultFonte').val(responseVistoriaEquipamentos.detalhes_fonte);
                $('#resultObs').val(responseVistoriaEquipamentos.observacao);
            },
            error: function() {
                alert('Erro ao buscar os dados.'); // Exibir mensagem de erro, se ocorrer algum problema
            }
        });
    }
</script>

<script>
    $("#btnSalvarPOP").click(function() {
        var dadosSalvarPOP = $("#cadastraPOP").serialize();

        $.post("processa/criarPOP.php", dadosSalvarPOP, function(retornaSalvarPOP) {
            $("#msgSalvarPOP1").slideDown('slow').html(retornaSalvarPOP);
            $("#msgSalvarPOP2").slideDown('slow').html(retornaSalvarPOP);


            if (retornaSalvarPOP.includes("Error")) {
                // Lógica para tratar o erro, se necessário
            } else {
                // Limpar os campos
                $('#cadastraPOP')[0].reset();
            }

            //Apresentar a mensagem leve
            retirarMsgSalvarPOP();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgSalvarPOP() {
        setTimeout(function() {
            $("#msgSalvarPOP1").slideUp('slow', function() {});
            $("#msgSalvarPOP2").slideUp('slow', function() {});
        }, 1700);
    }
</script>

<script>
    $("#btnEditarPOP").click(function() {
        var dadosEditarPOP = $("#editarPOP").serialize();

        $.post("processa/editarPOP.php", dadosEditarPOP, function(retornaEditarPOP) {
            $("#msgEditarPOP1").slideDown('slow').html(retornaEditarPOP);
            $("#msgEditarPOP2").slideDown('slow').html(retornaEditarPOP);


            //Apresentar a mensagem leve
            retirarMsgEditarPOP();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgEditarPOP() {
        setTimeout(function() {
            $("#msgEditarPOP1").slideUp('slow', function() {});
            $("#msgEditarPOP2").slideUp('slow', function() {});
        }, 1700);
    }
</script>

