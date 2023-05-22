<?php
$sql_lista_tipos_chamados =
"SELECT
tc.id as id_tipo,
tc.tipo as nome_tipo,
CASE
    WHEN tc.active = 1 THEN 'Ativado'
    WHEN tc.active = 0 THEN 'Inativado'
END as ativo_tipo
FROM
tipos_chamados as tc
ORDER BY
tc.tipo ASC
";
