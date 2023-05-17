<?php

$sql_lista_pops = 
"SELECT
pop.id as id,
pop.pop as pop,
pop.apelidoPop as apelidoPop,
emp.fantasia as empresa,
endereco.city as cidade
FROM
pop as pop
LEFT JOIN
pop_address as endereco
ON
endereco.pop_id = pop.id
LEFT JOIN
empresas as emp
ON
emp.id = pop.empresa_id
WHERE
pop.active = 1        
ORDER BY
emp.fantasia asc,
pop.pop asc
";

$sql_lista_empresas =
"SELECT
emp.*
FROM
empresas as emp
WHERE
emp. deleted = 1
and
emp.atributoCliente = 1
or
emp. deleted = 1
and
emp.atributoEmpresaPropria = 1
ORDER BY
emp.fantasia asc
";
