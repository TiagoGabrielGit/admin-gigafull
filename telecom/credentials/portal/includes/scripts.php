<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>


<script>
    $("#btnSalvarEdit").click(function() {
        var dados = $("#editCredenciais").serialize();

        $.post("processa/edit.php", dados, function(retorna) {
            $("#msgEditar").slideDown('slow').html(retorna);

            //Apresentar a mensagem leve
            retirarMsgEditar();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgEditar() {
        setTimeout(function() {
            $("#msgEditar").slideUp('slow', function() {});
            location.reload();
        }, 1700);
    }
</script>

<script>
    function addPermissaoEquipe(idEquipe, idCredencial, tipoCredencial) {
        $.ajax({
            url: "/api/insert_permissao_credencial_equipe.php",
            method: "GET",
            dataType: "HTML",
            data: {
                idEquipe: idEquipe,
                idCredencial: idCredencial,
                tipoCredencial: tipoCredencial
            }
        })
    }

    function deletaPermissaoEquipe(idCadastroCredencialEquipe) {
        $.ajax({
            url: "/api/deleta_permissao_credencial_equipe.php",
            method: "GET",
            dataType: "HTML",
            data: {
                idCadastroCredencialEquipe: idCadastroCredencialEquipe
            }
        })
    }

    function addPermissaoUsuario(idUsuario, idCredencial, tipoCredencial) {
        $.ajax({
            url: "/api/insert_permissao_credencial_usuario.php",
            method: "GET",
            dataType: "HTML",
            data: {
                idUsuario: idUsuario,
                idCredencial: idCredencial,
                tipoCredencial: tipoCredencial
            }
        })
    }

    function deletaPermissaoUsuario(idCadastroCredencialUsuario) {
        $.ajax({
            url: "/api/deleta_permissao_credencial_usuario.php",
            method: "GET",
            dataType: "HTML",
            data: {
                idCadastroCredencialUsuario: idCadastroCredencialUsuario
            }
        })
    }
</script>