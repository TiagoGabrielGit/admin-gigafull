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