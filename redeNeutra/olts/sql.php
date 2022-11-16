<?php
$lista_OLTs =
    "SELECT
    rno.id as idOLT,
    rno.olt_name as olt_name,
    eqp.ipaddress as olt_ipAddress,
    rno.olt_username as olt_user,
    rno.olt_password as olt_pass,
    rno.active as olt_actice,
    CASE
    WHEN rno.active = 1 THEN 'Ativo'
    WHEN rno.active = 0 THEN 'Inativo'
    END as olt_status
FROM
    redeneutra_olts as rno
LEFT JOIN
equipamentospop as eqp
ON
eqp.id = rno.equipamento_id
ORDER BY
    rno.olt_name ASC
";

$lista_equipamentos =
    "SELECT
eqp.id as idEquipamento,
eqp.hostname as equipamento
FROM
equipamentospop as eqp
LEFT JOIN
redeneutra_olts as rno
ON
eqp.id = rno.equipamento_id
WHERE
eqp.deleted = 1
and
eqp.tipoEquipamento_id = 5
and
rno.id IS NULL
";
