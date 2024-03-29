<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tipoChamadoSelect = document.getElementById('tipoChamado');
        var relatoChamadoTextarea = document.getElementById('relatoChamado');
        var mensagem = "Selecione primeiro o tipo de chamado";

        tipoChamadoSelect.addEventListener('change', function() {
            if (tipoChamadoSelect.value === "") {
                relatoChamadoTextarea.disabled = true;
                relatoChamadoTextarea.value = mensagem;
            } else {
                relatoChamadoTextarea.disabled = false;
                relatoChamadoTextarea.value = "";
            }
        });
    });
</script>


<script>
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
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////    
    $(document).ready(function() {
        $('#empresaChamado').change(function() {
            var empresaId = $(this).val();
            $.ajax({
                url: 'buscar_usuarios.php',
                type: 'POST',
                data: {
                    empresaId: empresaId
                },
                success: function(responseUsuarios) {
                    $('#selectSolicitante').html(responseUsuarios);
                }
            });
        });
    });
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////    
    $(document).ready(function() {
        $('#tipoChamado').change(function() {
            var chamadoID = $(this).val();
            $.ajax({
                url: 'buscar_atendentes.php',
                type: 'POST',
                data: {
                    chamadoID: chamadoID
                },
                success: function(responseAtendentes) {
                    $('#selectAtendente').html(responseAtendentes);
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

<script>
    document.getElementById('tipoChamado').addEventListener('change', function() {
        var select = this;
        var div = document.getElementById('selectDataConclusao');
        var input = div.querySelector('input');

        if (select.value !== '' && select.options[select.selectedIndex].dataset.permiteDataEntrega === '1') {
            div.style.display = 'block';
            input.required = true;
        } else {
            div.style.display = 'none';
            input.required = false;
        }
    });
</script>

<script>
    // Obter o elemento select e o campo de data e hora
    var selectTipoChamado = document.getElementById('tipoChamado');
    var campoDataConclusao = document.getElementById('dataConclusao');

    // Adicionar evento onchange ao select
    selectTipoChamado.addEventListener('change', function() {
        // Obter o tempo permitido para o tipo de chamado selecionado
        var opcaoSelecionada = selectTipoChamado.options[selectTipoChamado.selectedIndex];
        var permiteDataEntrega = opcaoSelecionada.getAttribute('data-permite-data-entrega');
        var horasPrazoEntrega = opcaoSelecionada.getAttribute('data-horas-prazo-entrega');

        // Atualizar o valor mínimo do campo de data e hora
        if (permiteDataEntrega === '1') {
            var dataMinima = new Date();
            dataMinima.setHours(dataMinima.getHours() + parseInt(horasPrazoEntrega));
            var dataMinimaFormatada = dataMinima.toISOString().slice(0, 16);
            campoDataConclusao.min = dataMinimaFormatada;
        } else {
            campoDataConclusao.removeAttribute('min');
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('formAbrirChamado');
        var btnAbrirChamado = document.getElementById('btnAbrirChamado');
        var btnVoltar = document.getElementById('btnVoltar');
        var loadingMessage = document.getElementById('loadingMessage');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            btnAbrirChamado.style.display = 'none';
            btnVoltar.style.display = 'none';
            loadingMessage.style.display = 'block';

            form.submit();
        });
    });
</script>

<script>
    // Função para buscar e preencher a máscara do chamado
    function preencherMascaraChamado() {
        var empresaChamado = document.getElementById('empresaChamado').value;
        var tipoChamado = document.getElementById('tipoChamado').value;

        // Faça uma solicitação AJAX para buscar a máscara do chamado
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'processa/get_mascara.php?empresa=' + empresaChamado + '&tipo=' + tipoChamado, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                var mascara = xhr.responseText;
                document.getElementById('relatoChamado').value = mascara;
            }
        };
        xhr.send();
    }

    // Chame esta função quando o tipo de chamado for selecionado
    document.getElementById('tipoChamado').addEventListener('change', preencherMascaraChamado);
</script>