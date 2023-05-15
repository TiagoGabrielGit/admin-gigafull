<?php
require "../../../conexoes/conexao.php";
require "../../../conexoes/conexao_pdo.php";

// Obtém a data selecionada enviada pela requisição POST
$idVistoria = $_POST['data'];
/*
$dados = array(
    'buscaResponsavelVistoria' => $idVistoria
);
header('Content-Type: application/json');
echo json_encode($dados);

*/

// Constrói a consulta SQL
$sql_busca_vistoria = "SELECT
v.id as idVistoria,
v.limpeza as limpeza,
v.organizacao as organizacao,
v.obs_geral as obsGeral,
p.nome as responsavel
FROM
vistoria as v
LEFT JOIN
usuarios as u
ON
u.id = v.responsavel_id
LEFT JOIN
pessoas as p
ON
p.id = u.pessoa_id
WHERE
v.id = $idVistoria";



$r_busca_vistoria = mysqli_query($mysqli, $sql_busca_vistoria);

// Verifica se há resultados
if ($r_busca_vistoria->num_rows > 0) {
    // Obtém os dados da primeira linha (supondo que haja apenas uma linha)
    $row = $r_busca_vistoria->fetch_assoc();
    
    // Cria um array associativo com os dados
    $dados = array(
        'buscaLimpezaVistoria' => $row['limpeza'],
        'buscaOrganizacaoVistoria' => $row['organizacao'],
        'buscaObsGeralVistoria' => $row['obsGeral'],
        'buscaResponsavelVistoria' => $row['responsavel'],
    );
    
    // Retorna os dados como resposta em formato JSON
    header('Content-Type: application/json');
    echo json_encode($dados);
} else {
    // Caso não haja resultados, retorna um array vazio
    $dados = array();
    header('Content-Type: application/json');
    echo json_encode($dados);
}

// Fecha a conexão com o banco de dados
$mysqli->close();