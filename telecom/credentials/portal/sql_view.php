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
$sql_credenciais_portal =
    "SELECT
portal.id as cred_id,
portal.privacidade as cred_priv,
portal.portaldescricao as cred_descricao,
portal.paginaacesso as cred_portal,
portal.portalusuario as cred_usuario,
portal.portalsenha as cred_senha,
portal.tipo as cred_tipo,
portal.anotacao as anotacaoEmail,
emp.fantasia as emp_fantasia,
p.nome as nomeCriador
FROM
credenciais_portal as portal
LEFT JOIN
empresas as emp
ON
emp.id = portal.empresa_id
LEFT JOIN
usuarios as u
ON
u.id = portal.usuario_id
LEFT JOIN
pessoas as p
ON
u.pessoa_id = p.id
WHERE
portal.id = '$id'
";
