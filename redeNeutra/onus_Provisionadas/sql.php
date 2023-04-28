<?php
$onus_provisionadas =
"SELECT
rnup.id as id,
rnup.olt_id as olt_id,
rnup.parceiro_id as parceiro_id,
p.nome as usuario_ativador,
rnup.descricao as descricao,
rnup.slot_olt as slot_olt,
rnup.pon_olt as pon_olt,
rnup.id_onu as id_onu,
rnup.serial_onu as serial_onu,
date_format(rnup.data_provisionamento, '%H:%i:%s %d/%m/%Y') as data_provisionamento, 
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
LEFT JOIN
usuarios as u
ON
u.id = rnup.criado_por
LEFT JOIN
pessoas as p
ON
p.id = u.pessoa_id
WHERE
rnup.active = 1
and
rnup.parceiro_id LIKE '$parceiroID'
and
date(data_provisionamento) LIKE '$filter_data'
order by
rnup.data_provisionamento desc,
rnup.slot_olt asc,
rnup.pon_olt asc,
rnup.id_onu asc

"
?>