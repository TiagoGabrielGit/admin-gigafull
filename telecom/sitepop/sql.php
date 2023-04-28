<?php

$sql_lista_pops = 
"SELECT
pop.id as id,
pop.pop as pop,
pop.apelidoPop as apelidoPop,
city.cidade as cidade,
emp.fantasia as empresa,
pais.id as id_pais,
pais.pais as nome_pais
FROM
pop as pop
LEFT JOIN
logradouros as logradouro
ON
logradouro.id = pop.logradouro_id
LEFT JOIN
cidades as city
ON
city.id = logradouro.cidade
LEFT JOIN
empresas as emp
ON
emp.id = pop.empresa_id
LEFT JOIN
estado as est
ON
est.id = city.estado
LEFT JOIN
pais as pais
ON
pais.id = est.pais
WHERE
pop.active = 1        
ORDER BY
emp.fantasia asc,
city.cidade asc,
pop.pop asc
";

$sql_lista_cidades =
"SELECT
    city.*
FROM
    cidades as city
WHERE
    city.deleted = 1            
ORDER BY
    city.cidade asc
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

$sql_pais =
"SELECT
pais.*
FROM pais as pais
WHERE pais.deleted = 1
ORDER BY pais.pais
"; 

$sql_cidade =
"SELECT
cidade.id as id,
cidade.cidade as cidade,
estado.estado as estado,
pais.pais as pais,
cidade.criado as criado,
cidade.modificado as modificado,
pais.id as idpais,
estado.id as idestado
FROM cidades as cidade
LEFT JOIN estado as estado
ON cidade.estado = estado.id
LEFT JOIN pais as pais
ON cidade.pais = pais.id
WHERE cidade.deleted = 1
ORDER BY cidade.cidade
";