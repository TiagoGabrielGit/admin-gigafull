<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $("#btnEditarTransceiver").click(function() {
        var dadosEditar = $("#transceiverEditarForm").serialize();

        $.post("processa/editar_transceiver.php", dadosEditar, function(retornaEditar) {
            $("#msgEditarTransceiver").slideDown('slow').html(retornaEditar);

            //Apresentar a mensagem leve
            retirarMsgEditarTransceiver();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgEditarTransceiver() {
        setTimeout(function() {
            $("#msgEditarTransceiver").slideUp('slow', function() {});
        }, 1700);
    }
</script>

<script>
    // Obtém o elemento de input do patrimônio
    const patrimonioInput = document.getElementById("patrimonioTransceiver");

    // Define o prefixo do patrimônio como "PATR_T"
    const prefixoPatrimonio = "PATR_T";

    // Função para verificar se o patrimônio está em uso
    function verificarPatrimonio(patrimonio) {
        const url = patrimonioInput.getAttribute("data-check-url");

        // Faz uma requisição AJAX para verificar o patrimônio
        // Neste exemplo, estou usando jQuery para simplificar o código AJAX
        $.ajax({
            url: url,
            type: "POST",
            data: {
                patrimonio: patrimonio
            },
            success: function(response) {
                if (response === "em_uso") {
                    gerarNovoPatrimonio();
                } else {
                    patrimonioInput.value = patrimonio;
                    patrimonioInput.readOnly = true;
                }
            },
            error: function() {
                console.log("Erro na verificação do patrimônio");
            }
        });
    }

    // Função para gerar um novo patrimônio
    function gerarNovoPatrimonio() {
        // Gera um código aleatório de 6 dígitos
        const codigoAleatorio = Math.floor(Math.random() * 1000000).toString().padStart(6, "0");

        // Combina o prefixo com o código aleatório
        const patrimonioCompleto = prefixoPatrimonio + codigoAleatorio;

        // Verifica se o novo patrimônio está em uso
        verificarPatrimonio(patrimonioCompleto);
    }

    // Inicia o processo de geração do patrimônio
    gerarNovoPatrimonio();
</script>