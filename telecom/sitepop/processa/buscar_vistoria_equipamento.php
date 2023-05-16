<?php
require "../../../conexoes/conexao.php";
require "../../../conexoes/conexao_pdo.php";

// Obtém a data selecionada enviada pela requisição POST
$idVistoriaEquipamento = $_POST['id'];

// Constrói a consulta SQL
$sql_busca_vistoria = 
"SELECT
ve.energia as energia,
ve.limpeza as limpeza,
ve.detalhes_fonte as detalhes_fonte,
ve.observacao as observacao
FROM
vistoria_equipamento as ve
WHERE
ve.id = $idVistoriaEquipamento";

$r_busca_vistoria = mysqli_query($mysqli, $sql_busca_vistoria);

// Verifica se há resultados
if ($r_busca_vistoria->num_rows > 0) {
    // Obtém os dados da primeira linha (supondo que haja apenas uma linha)
    $row = $r_busca_vistoria->fetch_assoc();
    // Cria um array associativo com os dados
    $dados = array(
        'energia' => $row['energia'],
        'limpeza' => $row['limpeza'],
        'detalhes_fonte' => $row['detalhes_fonte'],
        'observacao' => $row['observacao'],
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
 