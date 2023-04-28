<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

$id_onu = $_GET["id_onu"];
$register_log = $_GET["signal"];

$sql_register =
    "INSERT INTO redeneutra_onu_log (onu_id, register_log, created )
VALUES (:onu_id, :register_log, NOW())";
$stmt = $pdo->prepare($sql_register);
$stmt->bindParam(':onu_id', $id_onu);
$stmt->bindParam(':register_log', $register_log);


$stmt->execute();
?>