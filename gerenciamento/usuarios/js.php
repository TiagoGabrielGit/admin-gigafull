<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>


<script>
    $("#nomeUsuario").change(function() {
        var pessoaSelecionada = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_email.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: pessoaSelecionada
            }
        }).done(function(resposta) {
            document.getElementById("inputEmail").value = '';
            document.getElementById("inputEmail").value = resposta;
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>


<script>
    function mostrarOcultarSelect() {
        var tipoAcessoAdmin = document.getElementById("tipoAcessoAdmin");
        var selectPerfil = document.getElementById("controlaPerfil");

        if (tipoAcessoAdmin.checked) {
            selectPerfil.style.display = "block"; // Mostra o select
        } else {
            selectPerfil.style.display = "none"; // Oculta o select
        }
    }

    // Chamada inicial para garantir que o estado do select esteja correto ao carregar a página
    mostrarOcultarSelect();
</script>

<script>
    function mostrarOcultarSelect() {
        var tipoAcessoSmart = document.getElementById("inviteAcessoSmart");
        var selectPerfil = document.getElementById("inviteControlaPerfil");

        if (tipoAcessoSmart.checked) {
            selectPerfil.style.display = "block"; // Mostra o select
        } else {
            selectPerfil.style.display = "none"; // Oculta o select
        }
    }

    // Chamada inicial para garantir que o estado do select esteja correto ao carregar a página
    mostrarOcultarSelect();
</script>

<script>
    $("#btnSalvarUsuario").click(function() {
        var senhaProvisoria = gerarSenhaProvisoria();
        var dadosCadastrarUsuario = $("#formNovoUsuario").serialize();

        // Enviar dados via AJAX
        $.ajax({
            url: "processa/add.php", // Substitua pelo caminho correto para o arquivo que salvará no banco de dados
            type: "POST",
            data: dadosCadastrarUsuario + "&senha=" + senhaProvisoria,
            success: function(responseSalvarUsuario) {

                if (responseSalvarUsuario.includes("Error")) {
                    $("#msgSalvarUsuario1").slideDown('slow').html(responseSalvarUsuario);
                    $("#msgSalvarUsuario2").slideDown('slow').html(responseSalvarUsuario);
                    retirarMsgSalvarUsuario();
                } else {
                    document.querySelector("#btnSalvarUsuario").hidden = true;
                    $("#msgSalvarUsuario2").slideDown('slow').html(responseSalvarUsuario);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $("#msgSalvarUsuario1").slideDown('slow').html(responseSalvarUsuario);
                $("#msgSalvarUsuario2").slideDown('slow').html(responseSalvarUsuario);
                retirarMsgSalvarUsuario();
            }
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgSalvarUsuario() {
        setTimeout(function() {
            $("#msgSalvarUsuario1").slideUp('slow', function() {});
            $("#msgSalvarUsuario2").slideUp('slow', function() {});
        }, 1700);
    }
</script>

<script>
    function incluirCompetencia(idCompetencia, idUsuario, nomeUsuario, competencia) {
        document.querySelector("#idIncluirCompetencia").value = idCompetencia;
        document.querySelector("#idUsuarioCompetencia").value = idUsuario;

        let mensagemConfirmCompetencia = ` 
                     
        Deseja atribuir a competência <b> ${competencia} </b> ao usuário  <b> ${nomeUsuario} </b>?`
        document.querySelector("#msgConfirmCompetencia").innerHTML = mensagemConfirmCompetencia
    }
</script>

<script>
    function retirarCompetencia(idUC, nomeUsuario2, competencia2) {
        document.querySelector("#idUC").value = idUC;

        let mensagemRetirarCompetencia = ` 
                     
        Deseja retirar a competência <b> ${competencia2} </b> do usuário  <b> ${nomeUsuario2} </b>?`
        document.querySelector("#msgRetirarCompetencia").innerHTML = mensagemRetirarCompetencia
    }
</script>

<script>
    $("#btnConfirmCompetencia").click(function() {
        var dadosIncluiCompetencia = $("#formIncluiCompetencia").serialize();

        $.post("processa/incluiCompetencia.php", dadosIncluiCompetencia, function(retornaIncluiCompetencia) {
            location.reload();

        });
    });
</script>

<script>
    $("#btnRetirarCompetencia").click(function() {
        var dadosRetirarCompetencia = $("#formRetirarCompetencia").serialize();

        $.post("processa/retiraCompetencia.php", dadosRetirarCompetencia, function(retornaRetirarCompetencia) {
            location.reload();

        });
    });
</script>

<script>
    $("#btnReset").click(function() {
        var senhaProvisoria = gerarSenhaProvisoria();
        var dadosFormulario = $("#resetarSenha").serialize();

        // Enviar dados via AJAX
        $.ajax({
            url: "processa/alterarSenha.php", // Substitua pelo caminho correto para o arquivo que salvará no banco de dados
            type: "POST",
            data: dadosFormulario + "&senha=" + senhaProvisoria,
            success: function(response) {
                document.querySelector("#msgConfirmacao").hidden = true;
                document.querySelector("#btnReset").hidden = true;
                $("#msgSenhaGerada").slideDown('slow').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $("#msgSenhaGerada").slideDown('slow').html(response);
            }
        });
    });
</script>

<script>
    function gerarSenhaProvisoria() {
        var caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()";
        var senha = "";
        var comprimentoSenha = 15; // Define o comprimento da senha (pode ser ajustado conforme necessário)

        for (var i = 0; i < comprimentoSenha; i++) {
            var indiceAleatorio = Math.floor(Math.random() * caracteres.length);
            senha += caracteres.charAt(indiceAleatorio);
        }

        return senha;
    };
</script>

<script>
    $("#btnHorarioTrabalho").click(function() {
        var dadosHorarioTrabalho = $("#formHorarioTrabalho").serialize();

        // Enviar dados via AJAX
        $.ajax({
            url: "processa_colaborador/horario_trabalho.php",
            type: "POST",
            data: dadosHorarioTrabalho,
            success: function(responseHorarioTrabalho) {
                $("#msgHorarioTrabalho").slideDown('slow').html(responseHorarioTrabalho);

                // Aguardar 1 segundo e depois ocultar a mensagem
                setTimeout(function() {
                    $("#msgHorarioTrabalho").slideUp('slow');
                    location.reload();
                }, 1000);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $("#msgHorarioTrabalho").slideDown('slow').html(responseHorarioTrabalho);

                // Aguardar 1 segundo e depois ocultar a mensagem
                setTimeout(function() {
                    $("#msgHorarioTrabalho").slideUp('slow');
                    location.reload();
                }, 1000);
            }
        });
    });
</script>

<script>
    $("#btnGerencia").click(function() {
        var dadosGerencia = $("#formGerencia").serialize();

        // Enviar dados via AJAX
        $.ajax({
            url: "processa_colaborador/gerencia.php",
            type: "POST",
            data: dadosGerencia,
            success: function(responseGerencia) {
                $("#msgGerencia").slideDown('slow').html(responseGerencia);

                // Aguardar 1 segundo e depois ocultar a mensagem
                setTimeout(function() {
                    $("#msgGerencia").slideUp('slow');
                    location.reload();
                }, 1000);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $("#msgGerencia").slideDown('slow').html(responseGerencia);

                // Aguardar 1 segundo e depois ocultar a mensagem
                setTimeout(function() {
                    $("#msgGerencia").slideUp('slow');
                    location.reload();
                }, 1000);
            }
        });
    });
</script>

<script>
    $("#btnGerarInvite").click(function() {
        var dadosInvite = $("#formInvite").serialize();

        // Enviar dados via AJAX
        $.ajax({
            url: "processa/invite.php",
            type: "POST",
            data: dadosInvite,
            success: function(responseInvite) {
                if (responseInvite.includes("Error")) {
                    $("#msgInvite").slideDown('slow').html(responseInvite);
                    setTimeout(function() {
                        $("#msgInvite").slideUp('slow');
                    }, 1000);
                } else {
                    $("#btnGerarInvite").hide(); // Esconder o botão "Gerar Invite"


                    $("#msgInvite").slideDown('slow').html(responseInvite);


                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $("#msgInvite").slideDown('slow').html(responseInvite);

                // Aguardar 1 segundo e depois ocultar a mensagem
                setTimeout(function() {
                    $("#msgInvite").slideUp('slow');
                    location.reload();
                }, 1000);
            }
        });
    });
</script>