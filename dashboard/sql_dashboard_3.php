<?php

$usuarioID = $_SESSION['id'];

//PARCEIRO ID
$sql_parceiro = 
"SELECT
parceiroRN_id as parceiro
FROM
usuarios
WHERE
id = $usuarioID
";
$r_parceiro = mysqli_query($mysqli, $sql_parceiro);
$c_parceiro = $r_parceiro->fetch_array();

$parceiroID = $c_parceiro['parceiro'];

//TOTAL ONUs PROVISIONADAS
$sql_total_onu = 
"SELECT
count(*) as total
FROM
redeneutra_onu_provisionadas
WHERE
active = 1
AND
parceiro_id = $parceiroID";

$r_total_onu = mysqli_query($mysqli, $sql_total_onu);
$c_total_onu = $r_total_onu->fetch_array();

//ONUs PROVISIONADAS HOJE
$sql_hoje_onu = 
"SELECT
count(*) as hoje
FROM
redeneutra_onu_provisionadas
WHERE
active = 1
and
date(data_provisionamento) = CURDATE()
and
parceiro_id = $parceiroID
";

$r_hoje_onu = mysqli_query($mysqli, $sql_hoje_onu);
$c_hoje_onu = $r_hoje_onu->fetch_array();

//ONUs PROVISIONADAS ONTEM
$sql_ontem = "SELECT
count(*) as ontem
FROM
redeneutra_onu_provisionadas
WHERE
active = 1
and
date(data_provisionamento) = CURDATE() - interval 1 day
and
parceiro_id = $parceiroID";

$r_ontem = mysqli_query($mysqli, $sql_ontem);
$c_ontem = $r_ontem->fetch_array();

//ONUs PROVISIONADAS ÚLTIMOS 7 DIAS
$sql_ultimos_7_dias = "SELECT
count(*) as 7day
FROM
redeneutra_onu_provisionadas
WHERE
active = 1
and
date(data_provisionamento) BETWEEN DATE_ADD(CURRENT_DATE(), INTERVAL -7 DAY) AND CURRENT_DATE()  
and
parceiro_id = $parceiroID";

$r_ultimos_7_dias = mysqli_query($mysqli, $sql_ultimos_7_dias);
$c_ultimos_7_dias = $r_ultimos_7_dias->fetch_array();

//Últimas 10 ONUs PROVISIONADAS
$last_10_onu = "SELECT
rnp.id as id,
rno.olt_name as olt,
rnp.slot_olt as slot,
rnp.pon_olt as pon,
rnp.id_onu as idONU,
rnp.serial_onu as serialONU,
rnp.descricao as descricao,
date_format(rnp.data_provisionamento,'%H:%i:%s %d/%m/%Y') as dataP,
p.nome as provisionado
FROM
redeneutra_onu_provisionadas as rnp
LEFT JOIN
redeneutra_olts as rno
ON
rno.id = rnp.olt_id
LEFT JOIN
usuarios as u
ON
rnp.criado_por = u.id
LEFT JOIN
pessoas as p
ON
p.id = u.pessoa_id
WHERE
rnp.active = 1
and
rnp.parceiro_id = $parceiroID
ORDER BY
rnp.data_provisionamento DESC
LIMIT 10";

$r_last_10_onu = mysqli_query($mysqli, $last_10_onu);

//ONUs POR OLT
$sql_onu_olt = "SELECT
count(*) as qtde,
ro.olt_name as olt
FROM
redeneutra_onu_provisionadas as rop
LEFT JOIN
redeneutra_olts as ro
ON
ro.id = rop.olt_id
WHERE
rop.active = 1
group by
rop.olt_id";

$r_onu_olt = mysqli_query($mysqli, $sql_onu_olt);
