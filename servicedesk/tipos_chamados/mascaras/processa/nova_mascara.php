<?php
session_start();
if (isset($_SESSION['id'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["empresa"]) && isset($_POST["tipoChamado"]) && isset($_POST["mascara"])) {
            require "../../../../conexoes/conexao_pdo.php";
            $empresa_id = $_POST["empresa"];
            $tipo_chamado_id = $_POST["tipoChamado"];
            $mascara = $_POST["mascara"];

            try {
                // Prepara a consulta SQL para inserir a nova máscara
                $query_insert_mascara = "INSERT INTO tipos_chamados_mascaras (empresa_id, tipo_chamado_id, mascara, active) VALUES (:empresa_id, :tipo_chamado_id, :mascara, '1')";
                $stmt = $pdo->prepare($query_insert_mascara);
                $stmt->bindParam(":empresa_id", $empresa_id, PDO::PARAM_INT);
                $stmt->bindParam(":tipo_chamado_id", $tipo_chamado_id, PDO::PARAM_INT);
                $stmt->bindParam(":mascara", $mascara, PDO::PARAM_STR);
                $stmt->execute();


                // Obtém o ID do último registro inserido
                $mascara_id = $pdo->lastInsertId();

                // Redireciona para a página de visualização incluindo o ID da nova máscara no URL
                header("Location: ../view.php?id=" . $mascara_id);
                exit();
            } catch (PDOException $e) {
                // Em caso de erro, redireciona de volta para a página principal exibindo uma mensagem de erro
                header("Location: /servicedesk/tipos_chamados/mascaras/index.php?error=" . urlencode($e->getMessage()));
                exit();
            }
        } else {
            // Se algum dos campos estiver faltando, redireciona de volta para a página principal exibindo uma mensagem de erro
            header("Location: /servicedesk/tipos_chamados/mascaras/index.php?error=Todos os campos são obrigatórios.");
            exit();
        }
    } else {
        // Se a solicitação não for do tipo POST, redireciona de volta para a página principal exibindo uma mensagem de erro
        header("Location: /servicedesk/tipos_chamados/mascaras/index.php?error=Este script aceita apenas solicitações POST.");
        exit();
    }
} else {
    header('Location: /index.php');
    exit();
}
