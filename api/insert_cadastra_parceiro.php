<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

$codigoParceiro = $_GET["codigoParceiro"];
$parceiro = $_GET["parceiro"];

//Cria evento na tabela auxiliar
$sql_insert_olt =
    "INSERT INTO redeneutra_parceiro (codigo, empresa_id, active)
VALUES (:codigo, :empresa_id, '1')";
$stmt = $pdo->prepare($sql_insert_olt);
$stmt->bindParam(':codigo', $codigoParceiro);
$stmt->bindParam(':empresa_id', $parceiro);


$stmt->execute();
?>