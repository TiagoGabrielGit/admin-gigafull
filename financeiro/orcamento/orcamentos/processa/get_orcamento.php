<?php
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: /login.php');
    exit();
}

// Verificar se o ID foi fornecido
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitizar o ID para evitar SQL Injection

    // Preparar a instrução SQL para obter os dados do orçamento
    $sql = "SELECT
                o.id,
                o.descricao,
                o.fornecedor,
                o.orcado,
                o.mes_competencia,
                o.ano_competencia
            FROM cc_orcamentos o
            WHERE o.id = :id";

    try {
        // Criar uma conexão PDO
        $stmt = $pdo->prepare($sql);

        // Bind do parâmetro
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Executar a instrução
        $stmt->execute();

        // Buscar o orçamento
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Retornar os dados como JSON
            echo json_encode($row);
        } else {
            // Caso não encontre o orçamento
            echo json_encode(['error' => 'Orçamento não encontrado.']);
        }
    } catch (PDOException $e) {
        // Em caso de erro, retornar uma mensagem de erro
        echo json_encode(['error' => 'Erro: ' . $e->getMessage()]);
    }
} else {
    // Caso não tenha fornecido o ID
    echo json_encode(['error' => 'ID do orçamento não fornecido.']);
}
