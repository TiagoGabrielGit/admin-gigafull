<?php
require "../../../conexoes/conexao_pdo.php";


$user = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_NUMBER_INT);
$chamado = filter_input(INPUT_GET, 'chamado', FILTER_SANITIZE_NUMBER_INT);

$cont_insert = false;

$sql = "UPDATE chamados SET atendente_id=? WHERE id=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user, $chamado]);

if ($stmt->execute()) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}


if ($cont_insert) { ?>
    <script>
        setTimeout(function() {
            var chamadoId = <?= $chamado ?>;
            fetch('../notify/encaminha_mail.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id_chamado=' + chamadoId
            }).then(function(response) {
                if (response.ok) {
                    // Lógica após o envio bem-sucedido da requisição
                    window.location.href = "/servicedesk/consultar_chamados/view.php?id=<?= $chamado ?>";
                } else {
                    console.error('Erro na requisição. Status:', response.status);
                }
            }).catch(function(error) {
                console.error('Erro na requisição:', error);
            });
        });
    </script>
<?php
} else {
?>
    <script>
        alert("Erro do excluir!");

        setTimeout(function() {
            window.location.href = "/servicedesk/consultar_chamados/view.php?id=<?= $chamado ?>";
        });
    </script>
<?php
}
