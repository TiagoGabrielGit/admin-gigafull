<?php

$sql_chamado1 =
"SELECT
c.id as id_chamado,
c.assuntoChamado as assunto,
c.relato_inicial as relato_inicial,
c.data_abertura as abertura,
c.data_fechamento as fechado,
c.atendente_id as id_atendente,
c.in_execution as in_execution,
c.in_execution_atd_id as in_execution_atd_id,
c.in_execution_start as in_execution_start,
tc.tipo as tipo,
cs.status_chamado as status,
e.fantasia as empresa
FROM
chamados as c 
LEFT JOIN
chamado_relato as cr
ON
c.id = cr.chamado_id
LEFT JOIN
tipos_chamados as tc
ON
c.tipochamado_id = tc.id
LEFT JOIN
chamados_status as cs
ON
c.status_id = cs.id
LEFT JOIN
portal_user as pu
ON
pu.id = c.solicitante_id
LEFT JOIN
pessoas as p
ON
p.id = c.solicitante_id
LEFT JOIN
empresas as e
ON
e.id = c.empresa_id
WHERE
c.id = '$id_chamado'
";

$sql_solicitante =
"SELECT
p.nome as solicitante
FROM
chamados as c
LEFT JOIN
pessoas as p
ON
p.id = c.solicitante_id
WHERE
c.id = '$id_chamado'
";

$sql_atendente =
"SELECT
p.nome as atendente
FROM
chamados as c
LEFT JOIN
pessoas as p
ON
p.id = c.atendente_id
WHERE
c.id = '$id_chamado'
";

$sql_relatos =
"SELECT
cr.id as id_relato,
cr.chamado_id as id_chamado,
p.nome as relatante,
cr.relato as relato,
cr.relato_hora_inicial as inicio,
cr.relato_hora_final as final,
cr.seconds_worked as seconds_worked
FROM
chamado_relato as cr
LEFT JOIN
pessoas as p
ON
p.id = cr.relator_id
WHERE
cr.chamado_id = '$id_chamado'
ORDER BY
cr.id DESC
";

$sql_status_chamados =
"SELECT
cs.id as id_status,
cs.status_chamado as status_chamado
FROM
chamados_status as cs
WHERE
cs.active = 1
and
cs.id != 1
and
cs.id != 2
ORDER BY
cs.status_chamado ASC
";