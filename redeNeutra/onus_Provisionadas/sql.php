<?php
$onus_provisionadas =
"SELECT
rnup.id as id,
rnup.olt_id as olt_id,
rnup.parceiro_id as parceiro_id,
rnup.descricao as descricao,
rnup.slot_olt as slot_olt,
rnup.pon_olt as pon_olt,
rnup.id_onu as id_onu,
rnup.serial_onu as serial_onu,
e.fantasia as parceiro,
rno.olt_name as olt
FROM
redeneutra_onu_provisionadas as rnup
LEFT JOIN
redeneutra_parceiro as rnp
ON
rnp.id = rnup.parceiro_id
LEFT JOIN
empresas as e
ON
e.id = rnp.empresa_id
LEFT JOIN
redeneutra_olts as rno
ON
rno.id = rnup.olt_id
WHERE
rnup.active = 1
order by
rnup.slot_olt asc,
rnup.pon_olt asc,
rnup.id_onu asc

"
?>