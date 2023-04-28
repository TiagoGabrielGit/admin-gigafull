<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $("#inputNome").change(function() {
        var nomeSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_email_user_portal.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: nomeSelecionado
            }
        }).done(function(resposta) {
            document.getElementById("inputEmail").value = (resposta);
            document.getElementById("inputEmailHidden").value = (resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    $("#btnSalvar").click(function() {
        var dados = $("#cadastraUsuarioPortal").serialize();

        $.post("processa/add.php", dados, function(retorna) {
            $("#msg").slideDown('slow').html(retorna);

            //Limpar os campos
            $('#cadastraUsuarioPortal')[0].reset();

            //Apresentar a mensagem leve
            retirarMsg();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsg() {
        setTimeout(function() {
            $("#msg").slideUp('slow', function() {});
        }, 1700);
    }
</script>