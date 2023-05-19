
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $(document).ready(function() {
        $('.btn-editar').click(function() {
            var idServico = $(this).data('id');
            var service = $(this).data('service');
            var descricao = $(this).data('descricao');
            var itemService = $(this).data('item-service');
            var active = $(this).data('active');

            $('#serviceID').val(idServico);
            $('#servicoEditar').val(service);
            $('#descricaoEditar').val(descricao);
            $('#itemEdit').val(itemService);
            $('#activeEditar').val(active === 'Ativo' ? '1' : '0');

        });
    });
</script>


<script>
    $("#btnEditarServico").click(function() {
        var dados1 = $("#editarService").serialize();
        $.post("processa/edit.php", dados1, function(retorna1) {
            $("#msgEditar").slideDown('slow').html(retorna1);

            //Apresentar a mensagem leve
            retirarMsgEditar();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgEditar() {
        setTimeout(function() {
            $("#msgEditar").slideUp('slow', function() {});
        }, 1700);
    };
</script>


<script>
    $("#btnSalvarService").click(function() {
        var dados = $("#formNewService").serialize();

        $.post("processa/add.php", dados, function(retorna) {
            $("#msgCadastro").slideDown('slow').html(retorna);

            //Limpar os campos
            $('#formNewService')[0].reset();

            //Apresentar a mensagem leve
            retirarMsgCadastro();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgCadastro() {
        setTimeout(function() {
            $("#msgCadastro").slideUp('slow', function() {});
        }, 1700);
    };
</script>


<script>
    $("#btnSalvarItem").click(function() {
        var dados2 = $("#formNewItem").serialize();

        $.post("processa/addItem.php", dados2, function(retorna2) {
            $("#msgCadastroItem").slideDown('slow').html(retorna2);

            //Limpar os campos
            $('#formNewItem')[0].reset();

            //Apresentar a mensagem leve
            retirarMsgItem();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgItem() {
        setTimeout(function() {
            $("#msgCadastroItem").slideUp('slow', function() {});
        }, 1700);
    };
</script>


<script>
    $("#btnEditarItem").click(function() {
        var dados3 = $("#editarItem").serialize();
        $.post("processa/ediItem.php", dados3, function(retorna3) {
            $("#msgEditarItem").slideDown('slow').html(retorna3);

            //Apresentar a mensagem leve
            retirarMsgEditarItem();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgEditarItem() {
        setTimeout(function() {
            $("#msgEditarItem").slideUp('slow', function() {});
        }, 1700);
    }
</script>

<script>
    $(document).ready(function() {
        $('.btn-editarItem').click(function() {
            var idItem = $(this).data('id');
            var item = $(this).data('item');
            var description = $(this).data('description');
            var intCode = $(this).data('intcode');
            var active = $(this).data('active');

            $('#itemID').val(idItem);
            $('#itemEditar').val(item);
            $('#descricaoItemEdit').val(description);
            $('#codIntEditar').val(intCode);
            $('#activeEditarItem').val(active === 'Ativo' ? '1' : '0');

        });
    });
</script>
