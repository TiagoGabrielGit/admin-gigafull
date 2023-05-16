<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $("#cnpj").keypress(function() {
        $(this).mask('00.000.000/0000-00');
    });
</script>

<script>
    $("#telefone").keypress(function() {
        $(this).mask('(00)0000-0000');
    });
</script>

<script>
    $("#celular").keypress(function() {
        $(this).mask('(00)00000-0000');
    });
</script>

<script>
    //Pesquisa os estados passando ID do país
    $("#pais").change(function() {
        var paisselecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_estado.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: paisselecionado
            }
        }).done(function(resposta) {
            $("#estado").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Pesquisa as cidades passando ID do estado
    $("#estado").change(function() {
        var estadoSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_cidade.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: estadoSelecionado
            }
        }).done(function(resposta) {
            $("#cidade").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Pesquisa os bairros passando ID da cidade
    $("#cidade").change(function() {
        var cidadeSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_bairro.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: cidadeSelecionado
            }
        }).done(function(resposta) {
            $("#bairro").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Pesquisa os logradouros passando ID do bairro
    $("#bairro").change(function() {
        var bairroSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_logradouro.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: bairroSelecionado
            }
        }).done(function(resposta) {
            $("#logradouro").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    //Pesquisa o CEP passando ID do logradouro
    $("#logradouro").change(function() {
        var logradouroSelecionado = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_cep.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: logradouroSelecionado
            }
        }).done(function(resposta) {
            $("#cep").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    function buscarEnderecoPorCep() {
        var cep = document.getElementById('cep').value;

        // Fazer a chamada à API de CEP
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => preencherCamposEndereco(data))
            .catch(error => console.error(error));
    }

    function preencherCamposEndereco(data) {
        if (!data.erro) {
            if (data.logradouro !== '') {
                document.getElementById('logradouro').value = data.logradouro;
                document.getElementById('logradouro').readOnly = true;
            } else {
                document.getElementById('logradouro').readOnly = false;
            }

            if (data.bairro !== '') {
                document.getElementById('bairro').value = data.bairro;
                document.getElementById('bairro').readOnly = true;
            } else {
                document.getElementById('bairro').readOnly = false;
            }

            document.getElementById('cidade').value = data.localidade;
            document.getElementById('cidade').readOnly = true;
            document.getElementById('estado').value = data.uf;
            document.getElementById('estado').readOnly = true;
        } else {
            // Desbloquear todos os campos caso o endereço não seja encontrado
            document.getElementById('logradouro').readOnly = false;
            document.getElementById('bairro').readOnly = false;
            document.getElementById('cidade').readOnly = false;
            document.getElementById('estado').readOnly = false;
        }
    }
</script>