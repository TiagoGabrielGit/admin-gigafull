<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    document.getElementById('gerar-relatorio-csv-btn').addEventListener('click', function() {
        var selectElement = document.getElementById('consulta-select');
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var consultaId = selectedOption.getAttribute('data-id');

        // Verifica se uma opção válida foi selecionada
        if (consultaId) {
            // Envia a solicitação AJAX para o servidor
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'processa/gerar_relatorio.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Sucesso na solicitação AJAX
                        if (xhr.responseText === 'error') {
                            alert('Não há resultados para a consulta selecionada.');
                        } else {
                            // Criar um link temporário e fazer o download do arquivo
                            var downloadLink = document.createElement('a');
                            downloadLink.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(xhr.responseText);
                            downloadLink.download = 'relatorio.csv';
                            downloadLink.style.display = 'none';
                            document.body.appendChild(downloadLink);
                            downloadLink.click();
                            document.body.removeChild(downloadLink);

                            // Atualizar a página
                            window.location.reload();
                        }
                    } else {
                        // Erro na solicitação AJAX
                        alert('Ocorreu um erro durante o processamento. Tente novamente mais tarde.');
                    }
                }
            };
            xhr.send('consulta_id=' + consultaId);
        } else {
            alert('Selecione uma consulta válida.');
        }
    });
</script>