<?php
$sql_lista_so =
"SELECT
    so.id as id,
    so.sistemaoperacional as so,
    so.cadastroDefault as cadastroDefault,
    so.criado as criado,
    so.modificado as modificado
FROM
sistemaoperacional as so
WHERE
so.deleted = 1    
ORDER BY
so.sistemaoperacional ASC
";

?>