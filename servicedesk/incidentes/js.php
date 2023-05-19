<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>


<script>
    function showEquipamentos(value) {
        var equipamentosContainer = document.getElementById('equipamentosContainer');

        if (value === 'sim') {
            equipamentosContainer.style.display = 'block';
        } else {
            equipamentosContainer.style.display = 'none';
        }
    }
</script>

<script>
    $("#btnAbrirIncidente").click(function() {
        var dadosCadastrarIncidente = $("#cadastraIncidente").serialize();

        $.post("processa/add.php", dadosCadastrarIncidente, function(retornaCadastrarIncidente) {
            $("#msgCadastrarIncidente1").slideDown('slow').html(retornaCadastrarIncidente);
            $("#msgCadastrarIncidente2").slideDown('slow').html(retornaCadastrarIncidente);

            if (retornaCadastrarIncidente.includes("Error")) {
                // Lógica para tratar o erro, se necessário
            } else {
                // Limpar os campos
                $('#cadastraIncidente')[0].reset();
            }

            //Apresentar a mensagem leve
            retirarMsgCadastrarIncidente();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgCadastrarIncidente() {
        setTimeout(function() {
            $("#msgCadastrarIncidente1").slideUp('slow', function() {});
            $("#msgCadastrarIncidente2").slideUp('slow', function() {});
        }, 1700);
    }
</script>