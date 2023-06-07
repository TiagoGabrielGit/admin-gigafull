<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).on('click', '#buttonAnalisarGPON', function() {
    // Código do incidente
    var codigoIncidente = <?= json_encode($id_incidente) ?>;
    var incidente = <?= json_encode($descIncidente) ?>;

    // Referência ao modal
    var modal = $('#modalAnalisarGPON');

    // Chamada AJAX para o arquivo ont_summary_info.php
    $.ajax({
      url: '/api/ont_summary_info.php',
      type: 'POST',
      data: {
        codigoIncidente: codigoIncidente,
        incidente: incidente,
      },
      success: function(response) {
        // Tratar a resposta, se necessário
        console.log(response);

        // Fechar o modal
        setTimeout(function() {
          modal.modal('hide');
          //window.location.reload(); // Atualizar a página atual

        }, 1000);
      },
      error: function(xhr, status, error) {
        // Tratar erros, se necessário
        console.log(error);
      }
    });
  });
</script>