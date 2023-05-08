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

$sql_credenciais_email =
    "SELECT
credemail.id as cred_id,
credemail.privacidade as cred_priv,
credemail.emaildescricao as cred_descricao,
credemail.tipo as cred_tipo,
credemail.emailusuario as cred_usuario,
credemail.emailsenha as cred_senha,
credemail.webmail as cred_webmail,
credemail.anotacao as anotacaoEmail,
emp.id as emp_id,
emp.fantasia as emp_fantasia,
p.nome as nomeCriador
FROM
credenciais_email as credemail
LEFT JOIN
empresas as emp
ON
emp.id = credemail.empresa_id
LEFT JOIN
usuarios as u
ON
u.id = credemail.usuario_id
LEFT JOIN
pessoas as p
ON
u.pessoa_id = p.id
WHERE
credemail.id = '$id'
";