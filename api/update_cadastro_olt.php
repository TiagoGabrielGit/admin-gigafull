<?php
require "../conexoes/conexao_pdo.php";

$idOLT = $_GET['idOLT'];
$olt = $_GET['olt'];
$userOLT = $_GET['userOLT'];
$passOLT = $_GET['passOLT'];

$data = [
    'olt_name' => $olt,
    'olt_username' => $userOLT,
    'olt_password' => $passOLT,
    'id' => $idOLT,
];
$sql = "UPDATE redeneutra_olts SET olt_name=:olt_name, olt_username=:olt_username, olt_password=:olt_password WHERE id=:id";
$stmt= $pdo->prepare($sql);
$stmt->execute($data);