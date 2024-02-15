<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $("#btnRelatar").click(function() {
        document.querySelector("#btnRelatar").hidden = true;
        document.querySelector("#relatarLoading").hidden = false;
        var dadosRelatar = $("#relatarChamado").serialize();

        $.post("/servicedesk/consultar_chamados/processa/newRelato.php", dadosRelatar, function(retornaRelatar) {
            if (retornaRelatar.includes("Error")) {
                $("#msgRelatar").slideDown('slow').html(retornaRelatar);
                document.querySelector("#btnRelatar").hidden = false;
                document.querySelector("#relatarLoading").hidden = true;
                salvaRascunho();
                retirarMsgRelatar();
            } else if (retornaRelatar.includes("Success")) {
                var dadosEnviarEmail = document.querySelector("#chamadoID").value;

                // Enviar o comando POST para notify_mail.php
                $.post("/notificacao/mail/relato_chamado.php", {
                    id_chamado: dadosEnviarEmail
                }, function(responseNotifyMail) {
                    if (responseNotifyMail.includes("Success")) {
                        // Agora envie para o script do Telegram
                        $.post("/notificacao/telegram/relato_chamado.php", {
                            id_chamado: dadosEnviarEmail
                        }, function(responseTelegram) {
                            if (responseTelegram.includes("Success")) {
                                excluiRascunho();
                                $('#relatarChamado')[0].reset();
                                $("#basicModal").modal('hide');
                                recarregarPagina();
                            }
                        });
                    }
                });
            }
        });

    });

    function retirarMsgRelatar() {
        setTimeout(function() {
            $("#msgRelatar").slideUp('slow', function() {});
        }, 1700);
    };
</script>

<script>
    function recarregarPagina() {
        location.reload();
    }
</script>

<script>
    function excluiRascunho() {
        var dadosRascunhoRelatoExcluir = $("#relatarChamado").serialize();
        $.post("/servicedesk/consultar_chamados/processa/excluirRascunhoRelato.php", dadosRascunhoRelatoExcluir);
    };
</script>

<script>
    $("#basicModal").on('hidden.bs.modal', function() {
        if (tipoUsuario == 1 && startTime !== "") {
            salvaRascunho();
        }
    });

    function salvaRascunho() {
        var dadosRascunhoRelato = $("#relatarChamado").serialize();
        $.post("/servicedesk/consultar_chamados/processa/rascunhoRelato.php", dadosRascunhoRelato);
    };
</script>

<script>
    var chamadoID = document.querySelector("#chamadoID").value;
    var tipoUsuario = document.querySelector("#tipoUsuario").value;
    var startTime = document.querySelector("#startTime").value;

    if (tipoUsuario == 1 && startTime !== "") {
        $.ajax({
            url: "/servicedesk/consultar_chamados/processa/capturaRascunhoRelato.php",
            type: "POST",
            data: {
                chamadoID: chamadoID
            }, // Envie os dados necessários para a consulta
            success: function(retornaConsulta) {
                // Atribua o resultado ao textarea com o ID "novoRelato"
                $("#novoRelato").val(retornaConsulta);
            },
            error: function() {
                // Trate erros, se necessário
                alert("Erro ao consultar o banco de dados.");
            }
        });
    }
</script>

<script>
    // Função para remover os parâmetros 'success' e 'error' da URL
    function removeParameters() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('success') || urlParams.has('error')) {
            urlParams.delete('success');
            urlParams.delete('error');
            const newUrl = window.location.pathname + '?' + urlParams.toString();
            history.replaceState({}, '', newUrl);
        }
    }

    // Chame a função quando a página for carregada
    window.addEventListener('load', removeParameters);
</script>

<script>
    function confirmarCancelarRelato() {
        if (confirm("Tem certeza que deseja cancelar a execução do chamado?")) {
            // O usuário clicou em 'OK', prosseguir com o cancelamento do relato
            return true;
        } else {
            // O usuário clicou em 'Cancelar', cancelar a ação
            return false;
        }
    }
</script>