<script>
    $("#btnSalvarNovoPortal").click(function() {
        var dados = $("#addCredenciaisPortal").serialize();

        $.post("portal/processa/add.php", dados, function(retornaPortal) {
            $("#msgNewPortal").slideDown('slow').html(retornaPortal);

            //Limpar os campos
            $('#addCredenciaisPortal')[0].reset();

            //Apresentar a mensagem leve
            retirarMsgNewPortal();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgNewPortal() {
        setTimeout(function() {
            $("#msgNewPortal").slideUp('slow', function() {});
        }, 1700);
    }
</script>