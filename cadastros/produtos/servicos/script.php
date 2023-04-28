<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>



<script>
    $(document).ready(function() {
        $('#unidadeHora').hide();
        $('#Unidade').on('change', function() {
            var selectValor = +$(this).val();
            if (selectValor == 1) {
                $('#unidadeHora').show();
            } else {
                $('#unidadeHora').hide();
            }
        })
    })
</script>

<script>
    $("#btnSalvar").click(function() {
        var dados = $("#formNewService").serialize();

        $.post("processa/add.php", dados, function(retorna) {
            $("#msgCadastro").slideDown('slow').html(retorna);

            //Limpar os campos
            $('#formNewService')[0].reset();

            //Apresentar a mensagem leve
            retirarMsg();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsg() {
        setTimeout(function() {
            $("#msgCadastro").slideUp('slow', function() {});
        }, 1700);
    }
</script>

<script>
    $("#btnEditar").click(function() {
        var dados = $("#formEditService").serialize();

        $.post("processa/edit.php", dados, function(retorna) {
            $("#msgEditar").slideDown('slow').html(retorna);

            //Apresentar a mensagem leve
            retirarMsg();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsg() {
        setTimeout(function() {
            $("#msgEditar").slideUp('slow', function() {});
        }, 1700);
    }
</script>