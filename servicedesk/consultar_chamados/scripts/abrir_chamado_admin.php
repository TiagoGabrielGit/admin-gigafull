<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>


<script>
    //$("#btnSalvar").click(function() {
    //var dados = $("#abrirChamado").serialize();

    //$.post("/servicedesk/consultar_chamados/processa/add.php", dados, function(retorna) {
    //$("#msg").slideDown('slow').html(retorna);


    //if (retorna.includes("Error")) {
    // Lógica para tratar o erro, se necessário
    //} else {
    //Limpar os campos
    //$('#abrirChamado')[0].reset();
    //}
    //Apresentar a mensagem leve
    //retirarMsg();
    //});
    //});

    //Retirar a mensagem após 1700 milissegundos
    //function retirarMsg() {
    //setTimeout(function() {
    //$("#msg").slideUp('slow', function() {});
    //}, 1700);
    //};
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).ready(function() {
        $('#empresaChamado').change(function() {
            var empresaId = $(this).val();
            $.ajax({
                url: 'buscar_servicos.php',
                type: 'POST',
                data: {
                    empresaId: empresaId
                },
                success: function(response) {
                    $('#selectService').html(response);
                }
            });
        });
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////    
    $(document).ready(function() {
        $('#selectService').change(function() {
            var serviceID = $(this).val();
            $.ajax({
                url: 'buscar_itens.php',
                type: 'POST',
                data: {
                    serviceID: serviceID
                },
                success: function(responseItens) {
                    $('#selectIten').html(responseItens);
                }
            });
        });
    });
</script>

<script>
    document.getElementById('tipoChamado').addEventListener('change', function() {
        var tipoChamadoId = this.value; // Obtém o ID do tipo de chamado selecionado

        // Fazer a requisição AJAX para buscar as competências necessárias
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/servicedesk/consultar_chamados/processa/buscar_competencias.php?tipoChamadoId=' + tipoChamadoId, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var competencias = JSON.parse(xhr.responseText); // Obter as competências retornadas pela requisição

                // Armazenar os IDs das competências selecionadas automaticamente
                var competenciasAutomaticas = competencias;

                // Desmarcar todos os checkboxes
                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });

                // Marcar os checkboxes correspondentes às competências
                competencias.forEach(function(competenciaId) {
                    var checkbox = document.getElementById('competencia' + competenciaId);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });

                // Adicionar event listener para impedir desmarcar as competências selecionadas automaticamente
                checkboxes.forEach(function(checkbox) {
                    checkbox.addEventListener('click', function(event) {
                        var checkboxId = checkbox.getAttribute('id');
                        var competenciaId = checkboxId.replace('competencia', '');

                        if (competenciasAutomaticas.includes(competenciaId)) {
                            event.preventDefault(); // Impede que a ação padrão de clique seja executada
                            checkbox.checked = true; // Mantém o checkbox marcado
                        }
                    });
                });
            }
        };
        xhr.send();
    });
</script>