<script>
    $("#btnSalvarNovoEmail").click(function() {
        var dados = $("#addCredenciaisEmail").serialize();

        $.post("email/processa/add.php", dados, function(retornaEmail) {
            $("#msgNewEmail").slideDown('slow').html(retornaEmail);

            //Limpar os campos
            $('#addCredenciaisEmail')[0].reset();

            //Apresentar a mensagem leve
            retirarMsgNewEmail();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgNewEmail() {
        setTimeout(function() {
            $("#msgNewEmail").slideUp('slow', function() {});
        }, 1700);
    }
</script>