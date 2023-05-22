<?php
require "../conexoes/conexao_pdo.php";

$id = $_GET['id'];
$perfil = $_GET['perfil'];
$lineprofile = $_GET['lineprofile'];
$srvprofile = $_GET['srvprofile'];
$situacao = $_GET['situacao'];

if ($situacao == "true") {
    $situacao = "1";
} else if ($situacao == "false") {
    $situacao = "0";
}


$data = [
    'perfil' => $perfil,
    'line_profile_id' => $lineprofile,
    'srv_profile_id' => $srvprofile,
    'active' => $situacao,
    'id' => $id,
];
$sql = "UPDATE redeneutra_profile_parceiro SET perfil=:perfil, line_profile_id=:line_profile_id, srv_profile_id=:srv_profile_id, active=:active WHERE id=:id";
$stmt = $pdo->prepare($sql);
$stmt->execute($data);