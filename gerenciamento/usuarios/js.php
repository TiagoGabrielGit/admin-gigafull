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
        var dadosCadastrarUsuario = $("#formNovoUsuario").serialize();

        $.post("processa/add.php", dadosCadastrarUsuario, function(retornaCadastrarUsuario) {
            $("#msgSalvarUsuario1").slideDown('slow').html(retornaCadastrarUsuario);
            $("#msgSalvarUsuario2").slideDown('slow').html(retornaCadastrarUsuario);

            if (retornaCadastrarUsuario.includes("Error")) {
                // Lógica para tratar o erro, se necessário
            } else {
                // Limpar os campos
                $('#formNovoUsuario')[0].reset();
            }

            //Apresentar a mensagem leve
            retirarMsgCadastrarUsuario();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgCadastrarUsuario() {
        setTimeout(function() {
            $("#msgSalvarUsuario1").slideUp('slow', function() {});
            $("#msgSalvarUsuario2").slideUp('slow', function() {});
        }, 1700);
    }
</script>