<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
if (isset($_SESSION['id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Obtém o ID da empresa a ser removida da manutenção
        $empresa_id = $_GET['id'];

        // Remove o registro da tabela manutencao_programada_empresas
        $remover_sql = "DELETE FROM manutencao_programada_empresas WHERE empresa_id = :empresa_id";
        $remover_stmt = $pdo->prepare($remover_sql);
        $remover_stmt->bindParam(':empresa_id', $empresa_id, PDO::PARAM_INT);

        if ($remover_stmt->execute()) {
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
