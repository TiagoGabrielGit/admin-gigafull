<?php
require "../conexoes/conexao_pdo.php";

$idOLT = $_GET['idOLT'];
$olt = $_GET['olt'];
$ipOLT = $_GET['ipOLT'];
$userOLT = $_GET['userOLT'];
$passOLT = $_GET['passOLT'];

$sql = "UPDATE redeneutra_olts SET olt_name=?, olt_ipAddress=?, olt_username=?, olt_password=? WHERE id=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$olt, $ipOLT, $userOLT, $passOLT,  $idOLT]);
