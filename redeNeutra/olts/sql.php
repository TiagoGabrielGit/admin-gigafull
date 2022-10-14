<?php
$lista_OLTs =
    "SELECT
    rno.id as idOLT,
    rno.olt_name as olt_name,
    rno.olt_ipAddress as olt_ipAddress,
    rno.olt_username as olt_user,
    rno.olt_password as olt_pass,
    rno.active as olt_actice,
    CASE
    WHEN rno.active = 1 THEN 'Ativo'
    WHEN rno.active = 0 THEN 'Inativo'
    END as olt_status
FROM
    redeneutra_olts as rno
ORDER BY
    rno.olt_name ASC
";
