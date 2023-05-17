<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

<script>
    $("#btnSalvar").click(function() {
        var dadosCadastrarPessoa = $("#cadastraPessoa").serialize();

        $.post("processa/add.php", dadosCadastrarPessoa, function(retornaCadastrarPessoa) {
            $("#msgSalvarPessoa1").slideDown('slow').html(retornaCadastrarPessoa);
            $("#msgSalvarPessoa2").slideDown('slow').html(retornaCadastrarPessoa);

            if (retornaCadastrarPessoa.includes("Error")) {
                // Lógica para tratar o erro, se necessário
            } else {
                // Limpar os campos
                $('#cadastraPessoa')[0].reset();
            }

            //Apresentar a mensagem leve
            retirarMsgCadastrarPessoa();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgCadastrarPessoa() {
        setTimeout(function() {
            $("#msgSalvarPessoa1").slideUp('slow', function() {});
            $("#msgSalvarPessoa2").slideUp('slow', function() {});
        }, 1700);
    }
</script>

<script>
    $("#btnEditar").click(function() {
        var dadosEditarPessoa = $("#editarPessoa").serialize();

        $.post("processa/edit.php", dadosEditarPessoa, function(retornaEditarPessoa) {
            $("#msgEditarPessoa1").slideDown('slow').html(retornaEditarPessoa);
            $("#msgEditarPessoa2").slideDown('slow').html(retornaEditarPessoa);

            //Apresentar a mensagem leve
            retirarMsgEditarPessoa();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgEditarPessoa() {
        setTimeout(function() {
            $("#msgEditarPessoa1").slideUp('slow', function() {});
            $("#msgEditarPessoa2").slideUp('slow', function() {});
        }, 1700);
    }
</script>

<script>
    $(document).ready(function() {
        $('#cpf').inputmask('999.999.999-99');
        $('#cnpj').inputmask('99.999.999/9999-99');
        $('#telefone').inputmask('(99) 9999-9999');
        $('#celular').inputmask('(99) 99999-9999');
        $('#cep').inputmask('99999-999');
    });
</script>

<script>
 function buscarEnderecoPorCep() {
        var cep = document.getElementById('cep').value;

        // Fazer a chamada à API de CEP
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    throw new Error('CEP incorreto');
                }
                preencherCamposEndereco(data);
            })
            .catch(error => exibirErro(error));
    }

    function exibirErro(error) {
        console.error(error);
        var mensagemErro = document.getElementById('mensagem-erro');
        mensagemErro.textContent = 'CEP incorreto. Por favor, verifique o valor digitado.';

        document.getElementById('ibgecode').value = '';
        document.getElementById('logradouro').value = '';
        document.getElementById('bairro').value = '';
        document.getElementById('cidade').value = '';
        document.getElementById('estado').value = '';
        document.getElementById('ibgecode').readOnly = true;
        document.getElementById('logradouro').readOnly = true;
        document.getElementById('bairro').readOnly = true;
        document.getElementById('cidade').readOnly = true;
        document.getElementById('estado').readOnly = true;

        // Remover mensagem de erro após 2 segundos
        setTimeout(() => {
            mensagemErro.textContent = '';
        }, 2000);
    }

    function preencherCamposEndereco(data) {
        if (!data.erro) {
            if (data.logradouro !== '') {
                document.getElementById('logradouro').value = data.logradouro;
                document.getElementById('logradouro').readOnly = true;
            } else {
                document.getElementById('logradouro').value = "";
                document.getElementById('logradouro').readOnly = false;
            }

            if (data.bairro !== '') {
                document.getElementById('bairro').value = data.bairro;
                document.getElementById('bairro').readOnly = true;
            } else {
                document.getElementById('bairro').value = "";
                document.getElementById('bairro').readOnly = false;
            }

            document.getElementById('cidade').value = data.localidade;
            document.getElementById('cidade').readOnly = true;
            document.getElementById('estado').value = data.uf;
            document.getElementById('estado').readOnly = true;
            document.getElementById('ibgecode').value = data.ibge;
            document.getElementById('ibgecode').readOnly = true;
        } else {
            // Desbloquear todos os campos caso o endereço não seja encontrado
            document.getElementById('logradouro').readOnly = false;
            document.getElementById('bairro').readOnly = false;
            document.getElementById('cidade').readOnly = false;
            document.getElementById('estado').readOnly = false;
        }
    }
</script>