<?php
$lista_pessoas =
"SELECT
    pess.id as pessoa_id,
    pess.nome as pessoa_nome,
    pess.email as pessoa_email
FROM
    pessoas as pess
LEFT JOIN
    usuarios as u
ON
    u.pessoa_id = pess.id        
WHERE
    pess.permiteUsuario = 1
    and
    u.id is null    
ORDER BY
pess.nome ASC    
";

$sql_perfil =
"SELECT
p.id as idPerfil,
p.perfil as perfil
FROM
perfil as p
WHERE
p.active = 1
";

$sql_parceiros =
"SELECT
    rnp.id as parceiroID,
    e.fantasia as parceiro
FROM
    redeneutra_parceiro as rnp
LEFT JOIN
    empresas as e
ON
    e.id = rnp.empresa_id         
WHERE
    rnp.active = 1
ORDER BY
    e.fantasia ASC
";