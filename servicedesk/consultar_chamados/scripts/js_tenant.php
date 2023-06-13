<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $("#btnRelatar").click(function() {
        var dadosRelatar = $("#relatarChamado").serialize();

        $.post("/servicedesk/consultar_chamados/processa/newRelato.php", dadosRelatar, function(retornaRelatar) {

            if (retornaRelatar.includes("Error")) {
                $("#msgRelatar").slideDown('slow').html(retornaRelatar);

                retirarMsgRelatar();
            } else {
                var dadosEnviarEmail = document.querySelector("#chamadoID").value;

                // Enviar o comando POST para notify_mail.php
                $.post("/notificacao/mail/relato_chamado.php", {
                    id_chamado: dadosEnviarEmail
                }, function(responseNotifyMail) {
                    if (retornaRelatar.includes("Success")) {
                        $('#relatarChamado')[0].reset();
                        $("#basicModal").modal('hide');
                        recarregarPagina();
                    }
                });
            }
        });
    });
 
    function retirarMsgRelatar() {
        setTimeout(function() {
            $("#msgRelatar").slideUp('slow', function() {});
        }, 1700);
    };
</script>

<script>
    function recarregarPagina() {
        location.reload();
    }
</script>