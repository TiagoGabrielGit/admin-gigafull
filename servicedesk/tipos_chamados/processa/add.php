<?php
require "../../../conexoes/conexao_pdo.php";

$tipo = $_POST['tipoChamado'];

$cont_insert1 = false;

$sql = "INSERT INTO tipos_chamados (tipo, active) VALUES (:tipo, 1)";
$stmt1 = $pdo->prepare($sql);
$stmt1->bindParam(':tipo', $tipo);

if ($stmt1->execute()) {
    $cont_insert1 = true;
} else {
    $cont_insert1 = false;
}

if ($cont_insert1) {
    echo "<p style='color:green;'>Cadastrado com Sucesso</p>";
} else {
    echo "<p style='color:red;'>Erro ao cadastrar</p>";
}