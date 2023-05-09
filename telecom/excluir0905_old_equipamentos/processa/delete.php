<?php
include_once '../../../conexoes/conexao_pdo.php';

$idCadastro = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$cont_insert = false;

$sql = "DELETE FROM equipamentospop WHERE id='$idCadastro'";

$stmt = $pdo->prepare($sql);

if ($stmt->execute()) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}


if ($cont_insert) {
?>
    <script>
        setTimeout(function() {
            window.location.href = "/telecom/equipamentos/index.php";
        });

        alert("Excluido com sucesso!");
    </script>
<?php
} else {
?>
    <script>
        alert("Erro do excluir!");

        setTimeout(function() {
            window.location.href = "/telecom/equipamentos/index.php";
        });
    </script>
<?php
}
