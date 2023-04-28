<?php

$redeneutra_parceiro =
"SELECT
    rnp.id as idparceiro,
    e.fantasia as parceiro
FROM
    redeneutra_parceiro as rnp
LEFT JOIN
    empresas as e
ON
    e.id = rnp.empresa_id         
WHERE
    rnp.active = 1
    and
    rnp.id LIKE '$parceiroID'
ORDER BY
    e.fantasia ASC
";