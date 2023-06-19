<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    document.getElementById('btnCriar').addEventListener('click', function() {
        var formNovo = document.getElementById('formNovoDocument');
        var formNovoDocumento = new FormData(formNovo);

        var conteudo = document.querySelector('.quill-editor-full').innerHTML;
        formNovoDocumento.append('document_content', conteudo);

        var titleDocumentationValue = document.getElementById('titleDocumentation').value;
        formNovoDocumento.append('titleDocumentation', titleDocumentationValue);

        var idUsuarioValue = document.getElementById('idUsuario').value;
        formNovoDocumento.append('idUsuario', idUsuarioValue);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'processa/criar.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Sucesso no processamento
                var responseNovoDocumento = xhr.responseText;
                console.log(responseNovoDocumento);

                // Redirecionamento
                var idRegistroCriado = responseNovoDocumento; // O ID do registro retornado pelo servidor
                window.location.href = '/telecom/documentacao/document_edit.php?id=' + idRegistroCriado;
            } else {
                // Erro no processamento
                console.log('Erro: ' + xhr.status);
            }
        };

        xhr.send(formNovoDocumento);
    });
</script>