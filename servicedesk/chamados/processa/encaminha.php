<?php
session_start();
if (isset($_SESSION['id'])) {
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
                fetch('/notificacao/mail/encaminha_chamado.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id_chamado=' + chamadoId
                }).then(function(response) {
                    if (response.ok) {
                        window.location.href = "/servicedesk/chamados/visualizar_chamado.php?id=<?= $chamado ?>";
                    } else {
                        window.location.href = "/servicedesk/chamados/visualizar_chamado.php?id=<?= $chamado ?>";
                    }
                }).catch(function(error) {
                    console.error('Erro na requisição:', error);
                });
            });
        </script>
<?php
    } else {
    }
} else {
    header("Location: /index.php");
    exit();
}
