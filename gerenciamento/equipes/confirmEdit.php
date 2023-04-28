<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>


<script>
    $("#btnEditEquipe").click(function() {
        var dados = $("#formEditEquipe").serialize();

        $.post("processa/edit.php", dados, function(retorna) {
            location.href = "/gerenciamento/equipes/view.php?id=<?= $id_equipe?>";

        });
    });

</script>