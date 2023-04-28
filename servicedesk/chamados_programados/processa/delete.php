<?php
include_once '../../../conexoes/conexao_pdo.php';

$idEvent = $_GET["idEvent"];

$sql = "DROP EVENT `$idEvent`";
$stmt = $pdo->prepare($sql);

$sql1 = "DELETE FROM event_scheduler WHERE id = $idEvent";
$stmt1 = $pdo->prepare($sql1);

if ($stmt->execute() && $stmt1->execute()) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}

if ($cont_insert) {
?>
    <script>
        setTimeout(function() {
            window.location.href = "/servicedesk/chamados_programados/index.php";
        });

        alert("Excluido com sucesso!");
    </script>
<?php
} else {
?>
    <script>
        alert("Erro do excluir!");

        setTimeout(function() {
            window.location.href = "/servicedesk/chamados_programados/index.php";
        });
    </script>
<?php
}


