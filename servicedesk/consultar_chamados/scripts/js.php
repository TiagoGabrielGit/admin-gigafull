<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $("#btnSalvarRascunho").click(function() {
        var dadosRascunhoRelato = $("#relatarChamado").serialize();

        $.post("/servicedesk/consultar_chamados/processa/rascunhoRelato.php", dadosRascunhoRelato, function(retornaRascunhoRelato) {
            $("#msgSalvaRascunhoRelato").slideDown('slow').html(retornaRascunhoRelato);

            //Apresentar a mensagem leve
            retirarMsgSalvarRascunhoRelato();
        });
    });


    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgSalvarRascunhoRelato() {
        setTimeout(function() {
            $("#msgSalvaRascunhoRelato").slideUp('slow', function() {});
        }, 1700);
    };
</script>

<script>
    $("#btnRelatar").click(function() {
        var dadosRelatar = $("#relatarChamado").serialize();

        $.post("/servicedesk/consultar_chamados/processa/newRelato.php", dadosRelatar, function(retornaRelatar) {

            if (retornaRelatar.includes("Error")) {
                $("#msgRelatar").slideDown('slow').html(retornaRelatar);
                retirarMsgRelatar();
            } else {
                $("#basicModal").modal('hide');
            }

        });
    });

    function retirarMsgRelatar() {
        setTimeout(function() {
            $("#msgRelatar").slideUp('slow', function() {});
        }, 1700);
    };

    $("#basicModal").on('hidden.bs.modal', function() {
        location.reload();
    });
</script>



<script>
    var chamadoID = document.querySelector("#chamadoID").value;
    var tipoUsuario = document.querySelector("#tipoUsuario").value;
    var startTime = document.querySelector("#startTime").value;

    if (tipoUsuario == 1 && startTime !== "") {
        $.ajax({
            url: "/servicedesk/consultar_chamados/processa/capturaRascunhoRelato.php",
            type: "POST",
            data: {
                chamadoID: chamadoID
            }, // Envie os dados necessários para a consulta
            success: function(retornaConsulta) {
                // Atribua o resultado ao textarea com o ID "novoRelato"
                $("#novoRelato").val(retornaConsulta);
            },
            error: function() {
                // Trate erros, se necessário
                alert("Erro ao consultar o banco de dados.");
            }
        });
    }
</script>