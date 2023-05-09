<?php
include_once '../../../conexoes/conexao_pdo.php';

$idCadastro = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$idEquipamento = filter_input(INPUT_GET, 'idEquipamento');
$parametro = filter_input(INPUT_GET, 'parametro');

$cont_insert = false;

$sql = "UPDATE credenciais_equipamento SET active=? WHERE id=?";
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
            window.location.href = "/telecom/equipamentos/view.php?id=<?=$idEquipamento?>";
        });

        alert("Inativado com sucesso!");
    </script>
<?php
} else {
?>
    <script>
        alert("Erro do inativar!");

        setTimeout(function() {
            window.location.href = "/telecom/equipamentos/view.php?id=<?=$idEquipamento?>";
        });
    </script>
<?php
}


