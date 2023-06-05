<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $("#btnSalvar").click(function() {
        var dadosAdicionaServidor = $("#formAdicionarServidor").serialize();

        $.post("processa/add.php", dadosAdicionaServidor, function(retornaAdicionaServidor) {
            $("#msgAdicionarServidor").slideDown('slow').html(retornaAdicionaServidor);

            if (retornaAdicionaServidor.includes("Error")) {
                // Lógica para tratar o erro, se necessário
            } else {
                // Limpar os campos
                $('#formAdicionarServidor')[0].reset();
            }

            //Apresentar a mensagem leve
            retirarMsgAdicionaServidor();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgAdicionaServidor() {
        setTimeout(function() {
            $("#msgAdicionarServidor").slideUp('slow', function() {});
        }, 1700);
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Seleciona o elemento select
        var selectServidores = document.getElementById('select-servidores');

        // Adiciona um evento de mudança ao select
        selectServidores.addEventListener('change', function() {
            // Obtém o valor selecionado
            var selectedServerId = selectServidores.value;

            // Faz uma requisição AJAX para buscar os dados do servidor selecionado
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var serverData = JSON.parse(xhr.responseText);

                        // Preenche os campos do formulário com os dados retornados 
                        document.getElementById('formTestarEnvio').elements['serverID'].value = serverData.serverID;
                        document.getElementById('formTestarEnvio').elements['servidorID'].value = serverData.serverID;
                        document.getElementById('formEditServidor').elements['servidor'].value = serverData.server;
                        document.getElementById('formEditServidor').elements['status'].value = serverData.status;
                        document.getElementById('formEditServidor').elements['nome_remetente'].value = serverData.nome_remetente;
                        document.getElementById('formEditServidor').elements['conta_envio'].value = serverData.conta_envio;
                        document.getElementById('formEditServidor').elements['senha_conta_envio'].value = serverData.senha_conta_envio;
                        document.getElementById('formEditServidor').elements['servidor_smtp'].value = serverData.servidor_smtp;
                        document.getElementById('formEditServidor').elements['porta_smtp'].value = serverData.porta_smtp;
                        document.getElementById('formEditServidor').elements['seguranca_smtp'].value = serverData.seguranca_smtp;
                    } else {
                        console.error('Erro na requisição: ' + xhr.status);
                    }
                }
            };

            xhr.open('GET', 'processa/buscar_dados_servidor.php?id=' + selectedServerId, true);
            xhr.send();
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#btnTestarEnvio').click(function() {
            var formTestarEnvio = $('#formTestarEnvio').serialize(); // Serializar os dados do formulário

            $.ajax({
                type: 'POST',
                url: '/mail/sendmail.php',
                data: formTestarEnvio,
                success: function(responseTesteEnvio) {
                    if (responseTesteEnvio.includes("Error")) {
                        $("#msgTestarEnvio").slideDown('slow').html(responseTesteEnvio);
                        retirarMsgTesteEnvio();
                    } else {
                        $("#msgTestarEnvio").slideDown('slow').html(responseTesteEnvio);
                        retirarMsgTesteEnvio();
                        $('#formTestarEnvio')[0].reset();
                    }
                },
                error: function(xhr, status, error) {
                    // Lidar com erros de requisição, se ocorrerem
                    console.log(error);
                }
            });
        });

        //Retirar a mensagem após 1700 milissegundos
        function retirarMsgTesteEnvio() {
            setTimeout(function() {
                $("#msgTestarEnvio").slideUp('slow', function() {});
            }, 1700);
        }

    });
</script>

<script>
    document.getElementById('btnConfigSend').addEventListener('click', function() {
        // Obtenha o valor do checkbox e do select para a primeira notificação
        var checkbox1 = document.getElementById('flexSwitchCheckChecked1');
        var select1 = document.querySelector('#notificacao1_servidor');

        // Obtenha o valor do checkbox e do select para a segunda notificação
        var checkbox2 = document.getElementById('flexSwitchCheckChecked2');
        var select2 = document.querySelector('#notificacao2_servidor');

        // Obtenha o valor do checkbox e do select para a notificação 3
        var checkbox3 = document.getElementById('flexSwitchCheckChecked3');
        var select3 = document.querySelector('#notificacao3_servidor');

        // Obtenha o valor do checkbox e do select para a notificação 4
        var checkbox4 = document.getElementById('flexSwitchCheckChecked4');
        var select4 = document.querySelector('#notificacao4_servidor');

        // Crie um objeto FormData para enviar os dados para o PHP
        var formData = new FormData();
        formData.append('notificacao1_ativo', checkbox1.checked);
        formData.append('notificacao1_servidor', select1.value);
        formData.append('notificacao2_ativo', checkbox2.checked);
        formData.append('notificacao2_servidor', select2.value);
        formData.append('notificacao3_ativo', checkbox3.checked);
        formData.append('notificacao3_servidor', select3.value);
        formData.append('notificacao4_ativo', checkbox4.checked);
        formData.append('notificacao4_servidor', select4.value);

        // Envie os dados para o PHP usando XMLHttpRequest
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'processa/configSendMail.php', true);
        xhr.onload = function() {
            // Verifique a resposta do servidor
            if (xhr.status === 200) {
                var retornaNotificaEmail = xhr.responseText; // Obtém a resposta do servidor
                $("#msgConfigNotEmail").slideDown('slow').html(retornaNotificaEmail);
                retirarMsgConfigNotificacao();
            } else {
                var retornaNotificaEmail = 'Erro ao processar a solicitação';
                $("#msgConfigNotEmail").slideDown('slow').html(retornaNotificaEmail);
                retirarMsgConfigNotificacao();
            }
        };
        xhr.send(formData);

        function retirarMsgConfigNotificacao() {
            setTimeout(function() {
                $("#msgConfigNotEmail").slideUp('slow', function() {

                });
            }, 1700);
        }
    });
</script>