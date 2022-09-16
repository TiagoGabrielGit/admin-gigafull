<?php

$usuarioID = $_SESSION['id'];

//CHAMADOS ABERTOS
$sql_count_chamados_abertos = 
"SELECT
count(*) as quantidade
FROM
chamados as c
WHERE
c.status_id <> 3
";
$chamados_abertos = mysqli_query($mysqli, $sql_count_chamados_abertos);
$campos_chamados_abertos = $chamados_abertos->fetch_array();

//CHAMADOS SEM ATENDENTE
$sql_count_chamados_sematendente = 
"SELECT
count(*) as quantidade
FROM
chamados as c
WHERE
c.atendente_id = 0
and
c.status_id <> 3
";
$chamados_sematendente = mysqli_query($mysqli, $sql_count_chamados_sematendente);
$campos_chamados_sematendentes = $chamados_sematendente->fetch_array();

//CHAMADOS SEM ATENDENTE
$sql_count_chamados_meus = 
"SELECT
count(*) as quantidade
FROM
chamados as c
LEFT JOIN
usuarios as u
ON
u.pessoa_id = c.atendente_id
WHERE
u.id = $usuarioID
and
c.status_id <> 3
";
$chamados_meus = mysqli_query($mysqli, $sql_count_chamados_meus);
$campos_chamados_meus = $chamados_meus->fetch_array();

//ÚLTIMOD 30 CHAMADOS
$sql_ultimos_30_chamados = 
"SELECT
c.id as idChamado,
e.fantasia as fantasia,
tc.tipo as tipoChamado,
c.assuntoChamado as assuntoChamado,
c.status_id as statusChamado
FROM
chamados as c
LEFT JOIN
empresas as e
ON
e.id = c.empresa_id
LEFT JOIN
tipos_chamados as tc
ON
c.tipochamado_id = tc.id
ORDER BY
c.id DESC
LIMIT 30
";

$r_ultimos_30_chamados = mysqli_query($mysqli, $sql_ultimos_30_chamados);

//Horas trabalhadas X Clientes
$sql_horas_x_clientes =
"SELECT
CONCAT(MONTH(c.data_fechamento),'/',YEAR(c.data_fechamento)) as periodo,
e.fantasia as fantasia,
SUM(c.seconds_worked) as tempoTrabalhado
FROM
chamados as c
LEFT JOIN
empresas as e
ON
e.id = c.empresa_id
WHERE
c.status_id = 3
GROUP BY
YEAR(c.data_fechamento), MONTH(c.data_fechamento), c.empresa_id
ORDER BY
periodo DESC,
fantasia ASC
";


$r_sql_horas_x_clientes = mysqli_query($mysqli, $sql_horas_x_clientes);

//Horas trabalhadas X Consultores
$sql_horas_x_consultores =
"SELECT
CONCAT(MONTH(c.data_fechamento),'/',YEAR(c.data_fechamento)) as periodo,
p.nome as consultor,
SUM(cr.seconds_worked) as tempoTrabalhado
FROM
chamados as c
LEFT JOIN
chamado_relato as cr
ON
cr.chamado_id = c.id
LEFT JOIN
pessoas as p
ON
p.id = cr.relator_id
WHERE
c.status_id = 3
GROUP BY
YEAR(c.data_fechamento), MONTH(c.data_fechamento), cr.relator_id
ORDER BY
periodo DESC,
consultor ASC
";

$r_sql_horas_x_consultores = mysqli_query($mysqli, $sql_horas_x_consultores);