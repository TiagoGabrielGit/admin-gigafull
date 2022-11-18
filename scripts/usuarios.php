<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $("#inputNome").change(function() {
        var pessoaSelecionada = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_email.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: pessoaSelecionada
            }
        }).done(function(resposta) {
            document.getElementById("inputEmail").value = '';
            document.getElementById("inputEmail").value = resposta;
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>


<script>
    $("#inputNome").change(function() {
        var pessoaSelecionada = $(this).children("option:selected").val();

        $.ajax({
            url: "/api/pesquisa_email.php",
            method: "GET",
            dataType: "HTML",
            data: {
                id: pessoaSelecionada
            }
        }).done(function(resposta) {
            document.getElementById("inputEmailHidden").value = '';
            document.getElementById("inputEmailHidden").value = resposta;
        }).fail(function(resposta) {
            alert(resposta)
        });
    });
</script>

<script>
    $(document).ready(function() {
        //Esconde label parceiro
        $('#parceiroLabel').hide();
        $('#parceiroSelect').hide();

        //Inicialmente desmarca o CheckBox
        $('#tipoAcessoPortalRN').removeAttr('checked');

        $('#tipoAcessoPortalRN').change(function() {
            if (this.checked) {
                $('#parceiroLabel').show();
                $('#parceiroSelect').show();
            }
        });

        $('#tipoAcessoAdmin').change(function() {
            if (this.checked) {
                $('#parceiroLabel').hide();
                $('#parceiroSelect').hide();
            }
        });

        $('#tipoAcessoPortal').change(function() {
            if (this.checked) {
                $('#parceiroLabel').hide();
                $('#parceiroSelect').hide();
            }
        });
    });
</script>