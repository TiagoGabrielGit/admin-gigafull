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
eqp.tamanho as tamanho,
eqp.equipamento as equipamento,
fab.fabricante as fabricante
FROM equipamentos AS eqp
left join fabricante as fab
on fab.id = eqp.fabricante
WHERE eqp.deleted = 1
ORDER BY eqp.equipamento ASC
";

?>