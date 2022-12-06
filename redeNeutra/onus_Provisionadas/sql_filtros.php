<?php
$sql_lista_parceiros =
"SELECT
rp.id as id_empresa,
e.fantasia as fantasia_empresa
FROM
redeneutra_parceiro as rp
LEFT JOIN
empresas as e
ON
e.id = rp.empresa_id
WHERE
rp.active = 1
ORDER BY
e.fantasia ASC
";
?>