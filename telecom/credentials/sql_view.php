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

$sql_credenciais_vm =
"SELECT
credvm.id as cred_id,
credvm.privacidade as cred_priv,
credvm.tipo as cred_tipo,
credvm.vmdescricao as cred_descricao,
credvm.vmusuario as cred_usuario,
credvm.vmsenha as cred_senha,
vm.hostname as vm_hostname,
vm.id as vm_id,
vm.ipaddress as cred_ip,
emp.id as emp_id,
emp.fantasia as emp_fantasia,
p.nome as nomeCriador
FROM
credenciais_vms as credvm
LEFT JOIN
vms as vm
ON
credvm.vm_id = vm.id
LEFT JOIN
empresas as emp
ON
emp.id = credvm.empresa_id
LEFT JOIN
usuarios as u
ON
u.id = credvm.usuario_id
LEFT JOIN
pessoas as p
ON
u.pessoa_id = p.id
WHERE
credvm.id = '$id'
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