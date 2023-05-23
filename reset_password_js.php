<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $("#btnReset").click(function() {
        var dadosReset = $("#formResetPassword").serialize();
        $.post("reset_password_sql.php", dadosReset, function(retornaReset) {
            if (retornaReset.includes("Error")) {
                $("#msgReset").slideDown('slow').html(retornaReset);
            } else if (retornaReset.includes("Success")) {
                window.location.href = "index.php";
            }
        });
        //Apresentar a mensagem leve
        retirarMsgLogin();

    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgLogin() {
        setTimeout(function() {
            $("#msgReset").slideUp('slow', function() {});
        }, 2000);
    }
</script>