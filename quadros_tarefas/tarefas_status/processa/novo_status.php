<?php
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['id'])) {
    header("Location: /index.php");
    exit();
}

require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

// Função para limpar e validar os dados de entrada
function sanitize_input($data)
{
    return htmlspecialchars(trim($data));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegar e limpar os dados do formulário
    $status = isset($_POST['status']) ? sanitize_input($_POST['status']) : '';
    $tipo_fechamento = isset($_POST['tipo_fechamento']) ? sanitize_input($_POST['tipo_fechamento']) : '';

    // Validar os dados
    if (empty($status) || $tipo_fechamento === '') {
        $_SESSION['msg'] = "Todos os campos são obrigatórios.";
        header("Location: /quadros_tarefas/tarefas_status/index.php");
        exit();
    } elseif (!in_array($tipo_fechamento, ['0', '1'])) {
        $_SESSION['msg'] = "Seleção inválida para o tipo de fechamento.";
        header("Location: /quadros_tarefas/tarefas_status/index.php");
        exit();
    } else {
        // Tentar inserir no banco de dados
        try {
            $sql = "INSERT INTO tarefas_status (descricao, status_fechamento, active, `default`) VALUES (:status, :status_fechamento, 1, 0)";
            $stmt = $pdo->prepare($sql);

            // Bind dos parâmetros
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':status_fechamento', $tipo_fechamento);

            // Executar a inserção
            if ($stmt->execute()) {
                $_SESSION['msg'] = "Novo status criado com sucesso!";
                header("Location: /quadros_tarefas/tarefas_status/index.php");
                exit();
            } else {
                $_SESSION['msg'] = "Erro ao criar o novo status.";
                header("Location: /quadros_tarefas/tarefas_status/index.php");
                exit();
            }
        } catch (PDOException $e) {
            // Log de erro para debug
            error_log("Erro ao inserir no banco de dados: " . $e->getMessage());
            $_SESSION['msg'] = "Erro ao inserir no banco de dados: " . $e->getMessage();
            header("Location: /quadros_tarefas/tarefas_status/index.php?msg=error");
            exit();
        }
    }
}
