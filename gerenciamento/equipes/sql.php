<?php

$sql_pesquisa_equipes = 
"SELECT
e.id as id_equipe,
e.equipe as equipe,
CASE 
    WHEN e.active = 1 THEN 'Ativo'
    WHEN e.active = 0 THEN 'Inativo'
END active
FROM
equipe as e
ORDER BY
e.equipe ASC
";

?>