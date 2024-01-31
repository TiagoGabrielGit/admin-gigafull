

<script>
    $("#btnEditEquipe").click(function() {
        var dados = $("#formEditEquipe").serialize();

        $.post("processa/edit.php", dados, function(retorna) {
            location.href = "/gerenciamento/equipes/view.php?id=<?= $id_equipe?>";

        });
    });

</script>