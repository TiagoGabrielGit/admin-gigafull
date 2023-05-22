<?php
$sql_lista_user_portal =
    "SELECT
pu.id as id_usuario,
pu.user as user_usuario,
emp.fantasia as fantasia_empresa,
pess.nome as nome_pessoa,
CASE
    WHEN pu.active = 1 THEN 'Ativado'
    WHEN pu.active = 0 THEN 'Inativado'
END AS active
FROM
portal_user as pu
LEFT JOIN
portal_user_empresa AS pue
ON
pue.usuario_id = pu.id
LEFT JOIN
empresas as emp
ON
emp.id = pue.empresa_id
LEFT JOIN
pessoas as pess
ON
pess.id = pu.pessoa_id
ORDER BY
pess.nome ASC
";

$lista_pessoas =
"SELECT
    pess.id as pessoa_id,
    pess.nome as pessoa_nome,
    pess.email as pessoa_email
FROM
    pessoas as pess
WHERE
    pess.permiteUsuario = 1
ORDER BY
pess.nome ASC    
";

$lista_empresas =
"SELECT
emp.id as empresa_id,
emp.fantasia as empresa_nome
FROM
empresas as emp
WHERE
emp.deleted = 1
and
emp.atributoCliente = 1
ORDER BY
emp.fantasia ASC
";