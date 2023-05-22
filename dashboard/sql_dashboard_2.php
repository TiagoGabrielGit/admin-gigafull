 <?php 
 $usuarioID = $_SESSION['id'];

$sql_dados_empresa = 
"SELECT
u.empresa_id as empresaID
FROM
usuarios as u
WHERE
u.id = $usuarioID
and
u.active = 1
";
$r_dados_empresa = mysqli_query($mysqli, $sql_dados_empresa);
$c_dados_empresa = $r_dados_empresa->fetch_array();

$empresaID = $c_dados_empresa['empresaID'];

 //ÚLTIMOD 30 CHAMADOS
$sql_ultimos_30_chamados = 
"SELECT
c.id as idChamado,
tc.tipo as tipoChamado,
c.assuntoChamado as assuntoChamado,
c.status_id as statusChamado
FROM
chamados as c
LEFT JOIN
tipos_chamados as tc
ON
c.tipochamado_id = tc.id
WHERE
c.empresa_id = $empresaID
ORDER BY
c.id DESC
LIMIT 30
";

$r_ultimos_30_chamados = mysqli_query($mysqli, $sql_ultimos_30_chamados); 

//CHAMADOS ABERTOS
$sql_count_chamados_abertos = 
"SELECT
count(*) as quantidade
FROM
chamados as c
WHERE
c.status_id <> 3
and
c.empresa_id = $empresaID
";
$chamados_abertos = mysqli_query($mysqli, $sql_count_chamados_abertos);
$campos_chamados_abertos = $chamados_abertos->fetch_array();

//CHAMADOS EXECUÇÃO
$sql_count_chamados_execucao = 
"SELECT
count(*) as quantidade
FROM
chamados as c
WHERE
c.status_id <> 3
and
c.empresa_id = $empresaID
and
c.in_execution = 1
";
$r_count_chamados_execucao = mysqli_query($mysqli, $sql_count_chamados_execucao);
$c_count_chamados_execucao = $r_count_chamados_execucao->fetch_array();