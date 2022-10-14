<?php
$lista_parceiros =
"SELECT
rnp.id as idParceiro,
rnp.codigo as codigoParceiro,
rnp.active as parceiro_actiVe,
    CASE
    WHEN rnp.active = 1 THEN 'Ativo'
    WHEN rnp.active = 0 THEN 'Inativo'
    END as parceiro_status,
    e.fantasia as parceiroFantasia
FROM
    redeneutra_parceiro as rnp
LEFT JOIN
    empresas as e
ON
    e.id = rnp.empresa_id
ORDER BY
    e.fantasia ASC
";

$lista_empresas = 
"SELECT
e.id as idEmpresa,
e.fantasia as fantasia
FROM
empresas as e
LEFT JOIN
redeneutra_parceiro as rnp
ON
e.id = rnp.empresa_id
WHERE
e.deleted = 1
and
rnp.empresa_id is null
ORDER BY
e.fantasia ASC
";

$lista_olts = 
"SELECT
rno.id as idOLT,
rno.olt_name as nomeOLT
FROM
redeneutra_olts as rno
WHERE
rno.active = 1
";

$count_olts = 
"SELECT
count(*) as count_olt
FROM
redeneutra_olts as rno
WHERE
rno.active = 1
";