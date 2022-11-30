<?php
$sql_lista_empresas = 
"SELECT
emp.id as id,
emp.fantasia as empresa
FROM
empresas as emp
WHERE
emp.deleted = 1
ORDER BY
emp.fantasia ASC
";

$sql_lista_EquipamentosPop =
"SELECT
equipop.id as id_equipop,
equipop.hostname as hostname,
equipop.ipaddress as ipaddress,
equipop.deleted as deleted,
equipop.criado as criado,
equipop.modificado as modificado,
equipop.statusEquipamento as statuseqp,
emp.fantasia as empresa,
eqp.equipamento as equipamento,
pop.pop as pop
FROM
equipamentospop as equipop
LEFT JOIN
empresas as emp
ON
equipop.empresa_id = emp.id
LEFT JOIN
equipamentos as eqp
ON
eqp.id = equipop.equipamento_id
LEFT JOIN
pop as pop
ON
pop.id = equipop.pop_id
WHERE
equipop.deleted = 1
";

$sql_lista_fabricantes =
"SELECT
fab.id as id,
fab.fabricante as fabricante
FROM
fabricante as fab
WHERE
fab.deleted = 1
ORDER BY
fab.fabricante ASC
";

$sql_lista_pop =
"SELECT
pop.id as id_pop,
pop.pop as nome_pop
FROM
pop as pop
WHERE
pop.active = 1
ORDER BY
pop.pop ASC
";

$sql_lista_tipos = 
"SELECT
tipo.id as id,
tipo.tipo as tipo
FROM
tipoequipamento as tipo
WHERE
tipo.deleted = 1
ORDER BY
tipo.tipo ASC
";

