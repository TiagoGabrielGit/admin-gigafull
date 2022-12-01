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


if ($cont_insert) {
?>
    <script>
        setTimeout(function() {
            window.location.href = "/servicedesk/consultar_chamados/view.php?id=<?= $chamado ?>";
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
