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
date(data_provisionamento) = CURDATE() - 1
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
date(data_provisionamento) BETWEEN CURRENT_DATE()-7 AND CURRENT_DATE()  
and
parceiro_id = $parceiroID";

$r_ultimos_7_dias = mysqli_query($mysqli, $sql_ultimos_7_dias);
$c_ultimos_7_dias = $r_ultimos_7_dias->fetch_array();