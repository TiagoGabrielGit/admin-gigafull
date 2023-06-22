<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>


<script>
    $(document).ready(function() {

        $('#cadastroTipo').on('change', function() {

            var selectValor = '#' + $(this).val();
            //alert(selectValor);
            $('#formularioCredenciais').children('div').hide();
            $('#formularioCredenciais').children(selectValor).show();
            $(selectValor).children('div').show();

        })
    })
</script>

<script>
    $("#add-campo").click(function() {
        $("#portal").append(`
                <br><br>

                <hr class="sidebar-divider">

                <div class="col-6" style="display: inline-block;">
                <label for="portalDescricao" class="form-label">DescriÃ§Ã£o</label>
                <input name="portalDescricao[]" type="text" class="form-control" id="portalDescricao" required>
                </div>

                <br>
             
                <div class="col-4" style="display: inline-block;">
                <label for="portalUsuarioSenha" class="form-label">UsuÃ¡rio</label>
                <input name="portalUsuario[]" type="text" class="form-control" id="portalUsuario" required>
                </div>

                <div class="col-4" style="display: inline-block;">
                <label for="portalSenha" class="form-label">Senha</label>
                <input name="portalSenha[]" type="text" class="form-control" id="portalSenha" required>
                </div>

                `);
    });
</script>


<script>
    $("#cadastroEmpresa").change(function() {
        var empresaSelecionada = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_equipamentos_via_empresa.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: empresaSelecionada
            }
        }).done(function(resposta) {
            $("#equipamentoEquipamento").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>


<script>
    $("#cadastroEmpresa").change(function() {
        var empresaSelecionada = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_vms_via_empresa.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: empresaSelecionada
            }
        }).done(function(resposta) {
            $("#vmVm").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>


<script>
    $("#btnSalvar").click(function() {
        var dados = $("#addCredenciais").serialize();

        $.post("portal/processa/add.php", dados, function(retorna) {
            $("#msg").slideDown('slow').html(retorna);

            //Limpar os campos
            $('#addCredenciais')[0].reset();

            //Apresentar a mensagem leve
            retirarMsg();
        });
    });

    //Retirar a mensagem apÃ³s 1700 milissegundos
    function retirarMsg() {
        setTimeout(function() {
            $("#msg").slideUp('slow', function() {});
        }, 1700);
    }
</script>

<script>
    $("#editEmpresa").change(function() {
        var empresaSelecionada = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_vms_via_empresa.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: empresaSelecionada
            }
        }).done(function(resposta) {
            $("#editVM").html(resposta);
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    $("#btnSalvarEdit").click(function() {
        var dados = $("#editCredenciais").serialize();

        $.post("processa/edit.php", dados, function(retorna) {

            $("#msg").slideDown('slow').html(retorna);

            //Apresentar a mensagem leve
            retirarMsg();
        });
    });

    //Retirar a mensagem apÃ³s 1700 milissegundos
    function retirarMsg() {

        setTimeout(function() {

            location.reload();
            $("#msg").slideUp('slow', function() {});

        }, 1700);
    }
</script>