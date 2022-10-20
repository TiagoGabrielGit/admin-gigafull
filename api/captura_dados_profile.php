<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$idParceiro = $_GET["idParceiro"];
$idOLT = $_GET["idOLT"];

$sql = 
    "SELECT
    rnpp.CVLAN as CVLAN,
    rnpp.SVLAN as SVLAN,
    rnpp.GEMPORT as GEMPORT,
    rnpp.line_profile_id as line_profile_id,
    rnpp.srv_profile_id as srv_profile_id
FROM
    redeneutra_profile_parceiro as rnpp
WHERE
    rnpp.redeneutra_parceiro_id = $idParceiro
    and
    rnpp.redeneutra_olt_id = $idOLT
";

$consulta = mysqli_query($mysqli, $sql);


$result = mysqli_fetch_assoc($consulta);
echo json_encode($result);