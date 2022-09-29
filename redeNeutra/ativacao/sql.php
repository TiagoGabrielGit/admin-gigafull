<?php
$redeNeutra_OLTs = 
"SELECT
    rno.id as idOLT,
    rno.olt_name as nameOLT,
    rno.olt_ipAddress as ipOLT,
    rno.olt_username as userOLT,
    rno.olt_password as passOLT
FROM
    redeneutra_olts as rno
WHERE
    rno.active = 1
ORDER BY
    rno.olt_name ASC
";

$redeneutra_parceiro =
"SELECT
    rnp.id as idparceiro,
    e.fantasia as parceiro
FROM
    redeneutra_parceiro as rnp
LEFT JOIN
    empresas as e
ON
    e.id = rnp.empresa_id         
WHERE
    rnp.active = 1
ORDER BY
    e.fantasia ASC
";

$redeneutra_scripts = 
"SELECT
    rns.id as idScript,
    rns.descricao as descricao,
    rns.scriptName as scriptName
FROM
    redeneutra_scripts as rns
WHERE
    rns.active = 1
ORDER BY
    rns.scriptName ASC
";
