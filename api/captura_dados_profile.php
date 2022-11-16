<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$idProfile = $_GET["idProfile"];

$sql =
    "SELECT
    rnps.cvlan as CVLAN,
    rnps.svlan as SVLAN,
    rnps.gemport as GEMPORT,
    rnpp.line_profile_id as line_profile_id,
    rnpp.srv_profile_id as srv_profile_id,
    rno.olt_username as userOLT,
    rno.olt_password as passOLT,
    eqp.ipaddress as ipOLT
FROM
    redeneutra_profile_parceiro as rnpp
LEFT JOIN
	redeneutra_profile_service as rnps
ON
	rnpp.id = rnps.profile_id
LEFT JOIN
	redeneutra_olts as rno
ON
	rno.id = rnpp.redeneutra_olt_id
LEFT JOIN
equipamentospop as eqp
ON
eqp.id = rno.equipamento_id
WHERE
    rnpp.id = $idProfile
";

$consulta = mysqli_query($mysqli, $sql);


$result = mysqli_fetch_assoc($consulta);
echo json_encode($result);
