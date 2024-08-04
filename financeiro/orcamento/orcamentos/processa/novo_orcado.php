<?php
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: /login.php');
    exit();
}

$orcamento_id = isset($_POST['orcamento_id']) ? trim(htmlspecialchars($_POST['orcamento_id'])) : '';
$agrupamento = isset($_POST['agrupamento']) ? trim(htmlspecialchars($_POST['agrupamento'])) : '';
$centro_de_custo = isset($_POST['centro_de_custo']) ? trim(htmlspecialchars($_POST['centro_de_custo'])) : '';
$categoria = isset($_POST['categoria']) ? trim(htmlspecialchars($_POST['categoria'])) : '';
$descricao = isset($_POST['descricao']) ? trim(htmlspecialchars($_POST['descricao'])) : '';
$fornecedor = isset($_POST['fornecedor']) ? trim(htmlspecialchars($_POST['fornecedor'])) : '';
$orcado = isset($_POST['orcado']) ? str_replace(',', '.', trim(htmlspecialchars($_POST['orcado']))) : '';
$mes_competencia = isset($_POST['mes_competencia']) ? trim(htmlspecialchars($_POST['mes_competencia'])) : '';
$ano_competencia = isset($_POST['ano_competencia']) ? trim(htmlspecialchars($_POST['ano_competencia'])) : '';


// Prepare a consulta SQL para inserir os dados
$sql = "INSERT INTO cc_orcamentos (orcamento_id, agrupamento, centro_de_custo, categoria, descricao, fornecedor, orcado, mes_competencia, ano_competencia) 
        VALUES (:orcamento_id, :agrupamento, :centro_de_custo, :categoria, :descricao, :fornecedor, :orcado, :mes_competencia, :ano_competencia)";

$stmt = $pdo->prepare($sql);

// Bind dos parâmetros
$stmt->bindParam(':orcamento_id', $orcamento_id, PDO::PARAM_INT);
$stmt->bindParam(':agrupamento', $agrupamento, PDO::PARAM_INT);
$stmt->bindParam(':centro_de_custo', $centro_de_custo, PDO::PARAM_INT);
$stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
$stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
$stmt->bindParam(':fornecedor', $fornecedor, PDO::PARAM_STR);
$stmt->bindParam(':orcado', $orcado, PDO::PARAM_STR);
$stmt->bindParam(':mes_competencia', $mes_competencia, PDO::PARAM_STR);
$stmt->bindParam(':ano_competencia', $ano_competencia, PDO::PARAM_STR);


// Execute a consulta
if ($stmt->execute()) {
    // Redireciona ou exibe mensagem de sucesso
    header('Location: /financeiro/orcamento/orcamentos/view.php?id=' . $orcamento_id);
    exit();
} else {
    header('Location: /financeiro/orcamento/orcamentos/view.php?id=' . $orcamento_id);
    exit();
}
