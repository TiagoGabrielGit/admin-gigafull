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

$sql_lista_so = 
"SELECT
so.id as id,
so.sistemaOperacional as so
From
sistemaoperacional as so
Where
so.deleted = 1
ORDER BY
so.sistemaOperacional ASC
";


?>