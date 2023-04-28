<?php
require "../../conexoes/conexao_pdo.php";


$idProvisionamento = $_GET['id'];

$sql = "UPDATE redeneutra_onu_provisionadas SET active=? WHERE id=?";
$stmt = $pdo->prepare($sql);
$stmt->execute(["0", $idProvisionamento]);
