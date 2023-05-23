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
                // Aguardar 2 segundos e redirecionar para reset_password.php
                setTimeout(function() {
                    // Criar um formulário dinamicamente
                    var form = document.createElement("form");
                    form.method = "POST";
                    form.action = "reset_password.php";
                    
                    // Criar um input oculto com os dados do formulário
                    var inputDadosLogin = document.createElement("input");
                    inputDadosLogin.type = "hidden";
                    inputDadosLogin.name = "dadosLogin";
                    inputDadosLogin.value = dadosLogin;
                    form.appendChild(inputDadosLogin);

                    // Adicionar o formulário à página e submetê-lo
                    document.body.appendChild(form);
                    form.submit();
                }, 2000);
            } else {
                // Mostrar o elemento carregandoLogin
                document.querySelector("#carregandoLogin").hidden = false;
                document.querySelector("#btnLogin").hidden = true;
                // Aguardar 2 segundos e redirecionar para index.php
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 2000);
            }
            // Apresentar a mensagem leve
            retirarMsgLogin();
        });
    });

    // Retirar a mensagem após 1700 milissegundos
    function retirarMsgLogin() {
        setTimeout(function() {
            $("#msgLogin").slideUp('slow', function() {});
        }, 2000);
    }
</script>
