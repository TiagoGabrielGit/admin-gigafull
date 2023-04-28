<?php
$sql_atualizacoes =
"SELECT
a.id as id,
p.nome as usuario,
a.old_version as old_version,
a.new_version as new_version,
a.horario as horario
FROM
atualizacao as a
LEFT JOIN
usuarios as u
ON
u.id = a.usuario
LEFT JOIN
pessoas as p
ON
u.pessoa_id = p.id
order BY
a.horario DESC
";
