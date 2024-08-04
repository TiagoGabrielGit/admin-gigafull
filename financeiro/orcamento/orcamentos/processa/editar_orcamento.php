<?php
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: /login.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os dados do formulário
    $orcamento_id = isset($_POST['orcamento_id']) ? $_POST['orcamento_id'] : '';
    $descricao = isset($_POST['descricao-edit']) ? $_POST['descricao-edit'] : '';
    $fornecedor = isset($_POST['fornecedor-edit']) ? $_POST['fornecedor-edit'] : '';
    $mes_competencia = isset($_POST['mes_competencia-edit']) ? $_POST['mes_competencia-edit'] : '';
    $ano_competencia = isset($_POST['ano_competencia-edit']) ? $_POST['ano_competencia-edit'] : '';
    $orcado = isset($_POST['orcado-edit']) ? $_POST['orcado-edit'] : '';


    // Conectar ao banco de dados
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Atualizar o orçamento no banco de dados
        $sql = "UPDATE cc_orcamentos SET descricao = :descricao, fornecedor = :fornecedor, mes_competencia = :mes_competencia, ano_competencia = :ano_competencia, orcado = :orcado WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        // Vincular os parâmetros
        $stmt->bindParam(':id', $orcamento_id, PDO::PARAM_INT);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':fornecedor', $fornecedor, PDO::PARAM_STR);
        $stmt->bindParam(':mes_competencia', $mes_competencia, PDO::PARAM_STR);
        $stmt->bindParam(':ano_competencia', $ano_competencia, PDO::PARAM_STR);
        $stmt->bindParam(':orcado', $orcado, PDO::PARAM_STR);

        // Executar a atualização
        if ($stmt->execute()) {
            header("Location: /financeiro/orcamento/orcamentos/index.php");
            exit();
        } else {
            header("Location: /financeiro/orcamento/orcamentos/index.php");
            exit();
        }
    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();
    }
} else {
    header("Location: /financeiro/orcamento/orcamentos/index.php");
    exit();
}
