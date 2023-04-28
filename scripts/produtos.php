<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    $(document).ready(function() {
        $('#inputTamanhoDiv').hide();
        $('#equipamentoRack').on('change', function() {
            var selectValor = +$(this).val();
            if (selectValor == 1) {
                $('#inputTamanhoDiv').show();
            } else {
                $('#inputTamanhoDiv').hide();
            }
        })
    })
</script>