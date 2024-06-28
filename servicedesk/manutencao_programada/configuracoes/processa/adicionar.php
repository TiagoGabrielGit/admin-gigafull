<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

if (isset($_SESSION['id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Obtém o ID da empresa a ser adicionada na manutenção
        $empresa_id = $_GET['id'];

        $inserir_sql = "INSERT INTO manutencao_programada_empresas (empresa_id, active) VALUES (:empresa_id, 1)";
        $inserir_stmt = $pdo->prepare($inserir_sql);
        $inserir_stmt->bindParam(':empresa_id', $empresa_id, PDO::PARAM_INT);

        if ($inserir_stmt->execute()) {
            header("Location: /servicedesk/manutencao_programada/configuracoes/index.php");
            exit();
        } else {
            header("Location: /servicedesk/manutencao_programada/configuracoes/index.php");
            exit();
        }
    } else {

        header("Location: /index.php");
        exit();
    }
} else {

    header("Location: /index.php");
    exit();
}
