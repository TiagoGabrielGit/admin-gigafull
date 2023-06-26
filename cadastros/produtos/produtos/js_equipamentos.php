<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    function capturaID(id_eq) {
        return document.querySelector(`#atributo${id_eq}`).checked
    }

    function salvaAtributos(id_equipamento, id_tipoequipamento, checked) {
        console.log(id_equipamento, id_tipoequipamento, checked)

        if (checked) {
            checked = 1;
        } else {
            checked = 0;
        }

        var settings = {
            "url": "processa/api.php",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            "data": {
                "id_equipamento": id_equipamento,
                "id_tipoequipamento": id_tipoequipamento,
                "active": checked
            },
        };

        $.ajax(settings).done(function(response) {
            console.log(response);
        });
    }
</script>

<script>
    $("#btnEditarEquipamento").click(function() {
        var dadosEditar = $("#formEditarEquipamento").serialize();

        $.post("processa/editar_equipamento.php", dadosEditar, function(retornaEditar) {
            $("#msgEditarEquipamento").slideDown('slow').html(retornaEditar);

            //Apresentar a mensagem leve
            retirarMsgEditarEquipamento();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgEditarEquipamento() {
        setTimeout(function() {
            $("#msgEditarEquipamento").slideUp('slow', function() {});
        }, 1700);
    }
</script>