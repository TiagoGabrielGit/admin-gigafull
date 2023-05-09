<?php
session_start();
include_once '../../../conexoes/conexao_pdo.php';

$idCadastro = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$tipo = filter_input(INPUT_GET, 'tipo');
$cont_insert = false;

if ($tipo == "email") {
    $tabela = "credenciais_email";
}

if ($tipo == "equipamento") {
    $tabela = "credenciais_equipamento";
}

if ($tipo == "portal") {
    $tabela = "credenciais_portal";
}

if ($tipo == "vm") {
    $tabela = "credenciais_vms";
}

$sql = "DELETE FROM $tabela WHERE id='$idCadastro'";

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
            window.location.href = "/telecom/credenciais/index.php";
        });

        alert("Excluido com sucesso!");
    </script>
<?php
} else {
?>
    <script>
        alert("Erro do excluir!");

        setTimeout(function() {
            window.location.href = "/telecom/credenciais/index.php";
        });
    </script>
<?php
}
