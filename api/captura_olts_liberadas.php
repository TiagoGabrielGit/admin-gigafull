<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$redeNeutra_OLTs = 
"SELECT
rnpo.olt_id as idOLT,
rno.olt_name as nameOLT
FROM
redeneutra_parceiro_olt as rnpo
LEFT JOIN
redeneutra_olts as rno
ON
rno.id = rnpo.olt_id
WHERE
rnpo.parceiro_id = $id
and
rnpo.active = 1
ORDER BY
rno.olt_name ASC
";

$consulta = mysqli_query($mysqli, $redeNeutra_OLTs);
if($consulta):
    echo "<option value=''>Selecione</option>";
    while($resp = mysqli_fetch_object($consulta)):
        
       echo "<option value='$resp->idOLT'> $resp->nameOLT </option>";
    endwhile;

else: 
	echo "Algo deu errado";
endif;
?> 