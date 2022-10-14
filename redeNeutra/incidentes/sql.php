<?php
$sql_incidentes =
    "SELECT
rni.id as idIncidente,
rni.zabbix_event_id as zabbixID,
eqpop.hostname as equipamento,
rni.descricaoIncidente as descricaoIncidente,
CASE
WHEN rni.active = 1 THEN 'Incidente aberto'
WHEN rni.active = 0 THEN 'Normalizado'
END active,
rni.active as activeID,
date_format(rni.inicioIncidente,'%H:%m:%s %d/%m/%Y') as horainicial,
date_format(rni.fimIncidente,'%H:%m:%s %d/%m/%Y') as horafinal,
IF (rni.fimIncidente IS NULL, TIMEDIFF(NOW(), rni.inicioIncidente), TIMEDIFF(rni.fimIncidente, rni.inicioIncidente)) as tempoIncidente
FROM
redeneutra_incidentes as rni
LEFT JOIN
equipamentospop as eqpop
ON
eqpop.id = rni.equipamento_id
ORDER BY
rni.inicioIncidente DESC
";
