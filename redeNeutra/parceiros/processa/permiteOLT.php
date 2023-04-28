<?php
require "../../../conexoes/conexao_pdo.php";

$idOLT = $_POST['idOLT'];
$idParceiroNeutra = $_POST['idParceiroNeutra'];



$insert_permissao = "INSERT INTO redeneutra_parceiro_olt (parceiro_id, olt_id, active) VALUES (:parceiro_id, :olt_id, '1')";
$stmt1 = $pdo->prepare($insert_permissao);
$stmt1->bindParam(':parceiro_id', $idParceiroNeutra);
$stmt1->bindParam(':olt_id', $idOLT);

$stmt1->execute();