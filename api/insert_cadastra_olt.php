<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

$nomeOLT = $_GET["nomeOLT"];
$ipOLT = $_GET["ipOLT"];
$usuarioOLT = $_GET["usuarioOLT"];
$senhaOLT = $_GET["senhaOLT"];

$sql_insert_olt =
    "INSERT INTO redeneutra_olts (olt_name, olt_ipAddress, olt_username, olt_password, active)
VALUES (:olt_name, :olt_ipAddress, :olt_username, :olt_password, '1')";
$stmt = $pdo->prepare($sql_insert_olt);
$stmt->bindParam(':olt_name', $nomeOLT);
$stmt->bindParam(':olt_ipAddress', $ipOLT);
$stmt->bindParam(':olt_username', $usuarioOLT);
$stmt->bindParam(':olt_password', $senhaOLT);


$stmt->execute();
?>