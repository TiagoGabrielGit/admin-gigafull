<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    function mostrarFormulario() {
        var select = document.getElementById("inputRequisicao");
        var opcaoSelecionada = select.value;

        // Oculta todos os formulários
        var formularios = document.querySelectorAll("[id^='form-']");
        formularios.forEach(function(formulario) {
            formulario.style.display = "none";
        });

        // Mostra o formulário correspondente à opção selecionada
        var formulario = document.getElementById("form-" + opcaoSelecionada);
        formulario.style.display = "block";
    }
</script>

<script>
    $(document).ready(function() {
        $("#btnSolicitarPlantao").click(function() {
            var dadosPlantao = $("#formPlantao").serialize();

            // Enviar dados via AJAX
            $.ajax({
                url: "processa_colaborador/plantao.php",
                type: "POST",
                data: dadosPlantao,
                success: function(responsePlantao) {
                    if (responsePlantao.includes("Error")) {
                        $("#msgSolicitarPlantao").slideDown('slow').html(responsePlantao);
                    } else {
                        $("#msgSolicitarPlantao").slideDown('slow').html(responsePlantao);
                    }

                    // Retirar a mensagem após 1700 milissegundos
                    setTimeout(function() {
                        $("#msgSolicitarPlantao").slideUp('slow', function() {});
                    }, 1700);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#msgSolicitarPlantao").slideDown('slow').html(errorThrown);

                    // Retirar a mensagem após 1700 milissegundos
                    setTimeout(function() {
                        $("#msgSolicitarPlantao").slideUp('slow', function() {});
                    }, 1700);
                }
            });
        });
    });
</script>
