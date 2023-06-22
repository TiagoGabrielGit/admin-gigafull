<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $("#btnCriar").click(function() {
        var dadosConsulta = $("#formConsultaSQL").serialize();

        $.post("processa/criar.php", dadosConsulta, function(retornaCadastro) {

            if (retornaCadastro.includes("Error")) {
                $("#msgError").slideDown('slow').html(retornaCadastro);
                retirarMsgError();
            } else {
                window.location.href = 'index.php';
            }
        });
    });

    function retirarMsgError() {
        setTimeout(function() {
            $("#msgError").slideUp('slow', function() {});
        }, 1700);
    };
</script>

<script>
    document.getElementById("btnTestar").addEventListener("click", function() {
        $.ajax({
            url: "processa/testar.php", // Caminho para o script PHP
            type: "POST",
            data: {
                consulta_sql: $("#consulta_sql").val()
            }, // Dados a serem enviados para o script PHP
            success: function(response) {
                // Manipule a resposta do script PHP e exiba-a no textarea "resultado_teste"
                $("#resultado_teste").val(response);
            }
        });
    });
</script>