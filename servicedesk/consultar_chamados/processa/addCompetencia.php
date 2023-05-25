<?php
require "../../../conexoes/conexao_pdo.php";


$competencia = filter_input(INPUT_GET, 'competencia', FILTER_SANITIZE_NUMBER_INT);
$chamado = filter_input(INPUT_GET, 'chamado', FILTER_SANITIZE_NUMBER_INT);

$cont_insert = false;

$sql = 
"INSERT INTO chamados_competencias (chamado_id, competencia_id) VALUES (:chamado_id, :competencia_id)";
$stmt1 = $pdo->prepare($sql);

$stmt1->bindParam(':chamado_id', $chamado);
$stmt1->bindParam(':competencia_id', $competencia);

if ($stmt1->execute()) {
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
        alert("Erro ao adicionar!");

        setTimeout(function() {
            window.location.href = "/servicedesk/consultar_chamados/view.php?id=<?= $chamado ?>";
        });
    </script>
<?php
}
