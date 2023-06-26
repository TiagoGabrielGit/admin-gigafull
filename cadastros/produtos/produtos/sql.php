<?php

$sql_fabricante =
    "SELECT
fab.*
FROM fabricante as fab
WHERE fab.deleted = 1
ORDER BY fab.fabricante
";

$sql_tipo =
    "SELECT
tipo.*
FROM tipoequipamento as tipo
WHERE tipo.deleted = 1
ORDER BY tipo.tipo
";

$sql_equipamentos =
    "SELECT
eqp.id as id,
eqp.equipamento as equipamento,
fab.fabricante as fabricante,
CASE
WHEN eqp.deleted = 1 THEN 'Ativo'
WHEN eqp.deleted = 0 THEN 'Inativo'
END deleted
FROM equipamentos AS eqp
left join fabricante as fab
on fab.id = eqp.fabricante
ORDER BY eqp.equipamento ASC
";

$sql_baterias =
    "SELECT
pb.id as 'id',
f.fabricante as 'fabricante',
pb.modelo as 'modelo',
pb.tensao as 'tensao',
pb.amperagem as 'amperagem',
CASE
WHEN pb.active = 1 THEN 'Ativo'
WHEN pb.active = 0 THEN 'Inativo'
END as active
FROM
produtos_bateria as pb
LEFT JOIN
fabricante as f
ON
f.id = pb.fabricante_id";

$sql_transceiver =
    "SELECT
pt.id as 'id',
f.fabricante as 'fabricante',
pt.modelo as 'modelo',
pt.descricao as 'descricao',
CASE
WHEN pt.active = 1 THEN 'Ativo'
WHEN pt.active = 0 THEN 'Inativo'
END as active
FROM
produtos_transceiver as pt
LEFT JOIN
fabricante as f
ON
f.id = pt.fabricante_id";


$sql_componentes =
    "SELECT
pc.id as 'id',
f.fabricante as 'fabricante',
pc.modelo as 'modelo',
pc.descricao as 'descricao',
CASE
WHEN pc.active = 1 THEN 'Ativo'
WHEN pc.active = 0 THEN 'Inativo'
END as active
FROM
produtos_componentes as pc
LEFT JOIN
fabricante as f
ON
f.id = pc.fabricante_id";
