<?php
require "../../../conexoes/conexao_pdo.php";


$idCadastro = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$parametro = "0";
$cont_insert = false;

$sql = "UPDATE redeneutra_onu_provisionadas SET active=? WHERE id=?";
$stmt = $pdo->prepare($sql);
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
            window.location.href = "/redeNeutra/onus_Provisionadas/index.php";
        });

    </script>
<?php
} else {
?>
    <script>
        alert("Erro do excluir!");

        setTimeout(function() {
            window.location.href = "/redeNeutra/onus_Provisionadas/view.php?idProvisionamento=<?= $idCadastro ?>";
        });
    </script>
<?php
}
