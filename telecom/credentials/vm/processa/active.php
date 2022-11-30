<?php
include_once '../../../conexoes/conexao_pdo.php';

$idCadastro = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$idVM = filter_input(INPUT_GET, 'idVM');
$parametro = filter_input(INPUT_GET, 'parametro');

$cont_insert = false;

$sql = "UPDATE credenciais_vms SET active=? WHERE id=?";
$stmt= $pdo->prepare($sql);
$stmt->execute([$parametro, $idCadastro]);

if ($stmt->execute()) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}


if ($cont_insert) {
?>
    <script>
        setTimeout(function() {
            window.location.href = "/telecom/vms/view.php?id=<?=$idVM?>";
        });

        alert("Inativado com sucesso!");
    </script>
<?php
} else {
?>
    <script>
        alert("Erro do inativar!");

        setTimeout(function() {
            window.location.href = "/telecom/vms/view.php?id=<?=$idVM?>";
        });
    </script>
<?php
}


