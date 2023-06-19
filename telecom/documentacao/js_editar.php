<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script>
    document.getElementById('btnEditar').addEventListener('click', function() {
        var form = document.getElementById('formDocument');
        var formData = new FormData(form);

        // Obter o valor editado do campo de edição
        var editedContent = document.querySelector('.quill-editor-full').innerHTML;
        formData.append('document_content', editedContent);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'processa/editar.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Sucesso no processamento
                var response = xhr.responseText;
                console.log(response);
                $("#msgEditar").slideDown('slow').html(response);
                retirarMsgEditar();
            } else {
                // Erro no processamento
                console.log('Erro: ' + xhr.status);
                $("#msgEditar").slideDown('slow').html(response);
                retirarMsgEditar();
            }
        };

        xhr.send(formData);
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgEditar() {
        setTimeout(function() {
            $("#msgEditar").slideUp('slow', function() {});
        }, 1700);
    };
</script>

<script>
    document.getElementById('btnCriar').addEventListener('click', function() {
        var formNovo = document.getElementById('formNovoDocument');
        var formNovoDocumento = new FormData(formNovo);

        // Obter o valor editado do campo de edição
        var conteudo = document.querySelector('.quill-editor-full').innerHTML;
        formNovoDocumento.append('document_content', conteudo);

        // Obter o valor do campo titleDocumentation
        var titleDocumentationValue = document.getElementById('titleDocumentation').value;
        formNovoDocumento.append('titleDocumentation', titleDocumentationValue);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'processa/criar.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Sucesso no processamento
                var responseNovoDocumento = xhr.responseText;
                console.log(responseNovoDocumento);
            } else {
                // Erro no processamento
                console.log('Erro: ' + xhr.status);
            }
        };

        xhr.send(formNovoDocumento);
    });
</script>