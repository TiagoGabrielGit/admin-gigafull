<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    try {
        // Verifica se o método de requisição é POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Pega os dados enviados do formulário e os limpa
            $id = $_POST['id'];
            $status = $_POST['status'];
            $tipo_fechamento = isset($_POST['tipo_fechamento']) ? $_POST['tipo_fechamento'] : null;
            $ativo = $_POST['ativo'];
            $statusColor = $_POST['statusColor'];
            $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;

            if ($tipo_fechamento === null) {
                // Defina um valor padrão apropriado, como null ou outro valor dependendo do contexto
                $tipo_fechamento = "0";
            }
            // Prepara a query de atualização
            $query = "UPDATE tarefas_status SET 
                    titulo = :status,
                    status_fechamento = :tipo_fechamento, 
                    active = :ativo, 
                    color = :statusColor, 
                    descricao = :descricao 
                  WHERE id = :id";

            // Prepara a declaração
            $stmt = $pdo->prepare($query);

            // Liga os parâmetros à query
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':tipo_fechamento', $tipo_fechamento, PDO::PARAM_INT);
            $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
            $stmt->bindParam(':statusColor', $statusColor, PDO::PARAM_STR);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);

            // Executa a query
            if ($stmt->execute()) {
                $_SESSION['msg'] = "Status atualizado com sucesso!";
                header("Location: /quadros_tarefas/tarefas_status/view.php?id=$id");
                exit();
            } else {
                // Erro na atualização
                $_SESSION['msg'] = "Erro ao atualizar o status.";
                header("Location: /quadros_tarefas/tarefas_status/view.php?id=$id");
                exit();
            }
        } else {
            // Método de requisição inválido
            $_SESSION['msg'] = "Método de requisição inválido.";
            header("Location: /quadros_tarefas/tarefas_status/view.php?id=$id");
            exit();
        }
    } catch (Exception $e) {
        // Captura exceções e erros
        $_SESSION['msg'] = "Erro ao processar a atualização: " . $e->getMessage();
        header("Location: /quadros_tarefas/tarefas_status/view.php?id=$id");
        exit();
    }
} else {
    // Redireciona para a página de origem ou qualquer outra página de feedback
    header('Location: /index.php'); // Altere para o URL desejado
    exit();
}
