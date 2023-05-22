<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $("#btnLogin").click(function() {
        var dadosLogin = $("#formLogin").serialize();
        $.post("login_sql.php", dadosLogin, function(retornaLogin) {

            if (retornaLogin.includes("Error")) {
                $("#msgLogin").slideDown('slow').html(retornaLogin);
            } else if (retornaLogin.includes("Code002")) {
                // Mostrar o elemento carregandoLogin
                document.querySelector("#carregandoLogin").hidden = false;
                document.querySelector("#btnLogin").hidden = true;
                // Aguardar 2 segundos e redirecionar para index.php
                setTimeout(function() {
                    window.location.href = "reset_password.php";

                }, 1000);
            } else {
                // Mostrar o elemento carregandoLogin
                document.querySelector("#carregandoLogin").hidden = false;
                document.querySelector("#btnLogin").hidden = true;
                // Aguardar 2 segundos e redirecionar para index.php
                setTimeout(function() {
                    window.location.href = "index.php";

                }, 1000);
            }
            //Apresentar a mensagem leve
            retirarMsgLogin();
        });
    });
    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgLogin() {
        setTimeout(function() {
            $("#msgLogin").slideUp('slow', function() {});
        }, 2000);
    }
</script>