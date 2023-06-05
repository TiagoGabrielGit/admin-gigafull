<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $("#btnRelatar").click(function() {
        var dadosRelatar = $("#relatarChamado").serialize();

        $.post("/servicedesk/consultar_chamados/processa/newRelato.php", dadosRelatar, function(retornaRelatar) {

            if (retornaRelatar.includes("Error")) {
                $("#msgRelatar").slideDown('slow').html(retornaRelatar);
                salvaRascunho();
                retirarMsgRelatar();
            } else {
                $("#msgRelatar").slideDown('slow').html(retornaRelatar); //Isso faz o email ser enviado
                excluiRascunho();
                $('#relatarChamado')[0].reset();
                $("#basicModal").modal('hide');
                //setTimeout(function() {
                //    recarregarPagina();
                //}, 2500); // Delay de 2.5 segundos (2500 milissegundos) antes de chamar recarregarPagina()


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

<script>
    function excluiRascunho() {
        var dadosRascunhoRelatoExcluir = $("#relatarChamado").serialize();
        $.post("/servicedesk/consultar_chamados/processa/excluirRascunhoRelato.php", dadosRascunhoRelatoExcluir);
    };
</script>

<script>
    $("#basicModal").on('hidden.bs.modal', function() {
        if (tipoUsuario == 1 && startTime !== "") {
            salvaRascunho();
        }
    });


    function salvaRascunho() {
        var dadosRascunhoRelato = $("#relatarChamado").serialize();
        $.post("/servicedesk/consultar_chamados/processa/rascunhoRelato.php", dadosRascunhoRelato);
    };
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