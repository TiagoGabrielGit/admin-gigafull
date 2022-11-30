<?php
$sql_lista_empresas = 
"SELECT
emp.id as id_empresa,
emp.fantasia as fantasia_empresa
FROM
empresas as emp
WHERE
atributoCliente = '1'
or
atributoEmpresaPropria = '1'
ORDER BY
emp.fantasia ASC
";

$sql_lista_tipos_chamados =
"SELECT
tipo.id as id,
tipo.tipo as tipo
FROM
tipos_chamados as tipo
WHERE
tipo.active = 1
ORDER BY
tipo.tipo ASC
";