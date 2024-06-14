<?php
session_start(); // Inicia a sessão para poder usar $_SESSION
if (isset($_SESSION['id'])) {

    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    try {
        // Verificar se o ID foi enviado e se é um número válido
        if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
            throw new Exception("ID de status inválido.");
        }

        $status_id = $_POST['id'];

        // Verificar permissões do usuário
        $submenu_id = "61"; // Id do submenu para a página de status
        $uid = $_SESSION['id'];

        $permissions = "SELECT u.perfil_id
                    FROM usuarios u
                    JOIN perfil_permissoes_submenu pp
                    ON u.perfil_id = pp.perfil_id
                    WHERE u.id = :uid AND pp.url_submenu = :submenu_id";

        $exec_permissions = $pdo->prepare($permissions);
        $exec_permissions->bindParam(':uid', $uid);
        $exec_permissions->bindParam(':submenu_id', $submenu_id);
        $exec_permissions->execute();

        if ($exec_permissions->rowCount() <= 0) {
            throw new Exception("Você não tem permissão para atualizar este status.");
        }

        // Buscar o status atual para verificar se é "default"
        $busca_status = "SELECT * FROM tarefas_status WHERE id = :id";
        $stmt = $pdo->prepare($busca_status);
        $stmt->bindParam(':id', $status_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() <= 0) {
            throw new Exception("Status não encontrado.");
        }

        $status_atual = $stmt->fetch(PDO::FETCH_ASSOC);

        // Dados recebidos do formulário
        $descricao = $_POST['status'] ?? null;
        $tipo_fechamento = isset($_POST['tipo_fechamento']) ? (int)$_POST['tipo_fechamento'] : null;
        $ativo = isset($_POST['ativo']) ? (int)$_POST['ativo'] : null;

        // Validações básicas
        if (!$descricao) {
            throw new Exception("A descrição do status é obrigatória.");
        }

        if ($ativo === null || !in_array($ativo, [0, 1], true)) {
            throw new Exception("O valor de ativo é inválido.");
        }

        // Preparar a query de atualização
        if ($status_atual['default'] == 1) {
            // Se for "default", não permite alterar "tipo_fechamento"
            $update_query = "UPDATE tarefas_status SET descricao = :descricao, active = :active WHERE id = :id";
            $update_stmt = $pdo->prepare($update_query);
            $update_stmt->bindParam(':descricao', $descricao);
            $update_stmt->bindParam(':active', $ativo);
        } else {
            // Permitir todas as atualizações para não-default
            if ($tipo_fechamento === null || !in_array($tipo_fechamento, [0, 1], true)) {
                throw new Exception("O valor de tipo de fechamento é inválido.");
            }
            $update_query = "UPDATE tarefas_status SET descricao = :descricao, status_fechamento = :status_fechamento, active = :active WHERE id = :id";
            $update_stmt = $pdo->prepare($update_query);
            $update_stmt->bindParam(':descricao', $descricao);
            $update_stmt->bindParam(':status_fechamento', $tipo_fechamento);
            $update_stmt->bindParam(':active', $ativo);
        }

        // Adicionar o ID à query
        $update_stmt->bindParam(':id', $status_id, PDO::PARAM_INT);

        // Executar a atualização
        if ($update_stmt->execute()) {
            $_SESSION['msg'] = "Status atualizado com sucesso.";
        } else {
            throw new Exception("Erro ao atualizar o status.");
        }
    } catch (Exception $e) {
        $_SESSION['msg'] = $e->getMessage();
    }

    // Redirecionar de volta à página de edição ou a uma página de listagem
    header("Location: /quadros_tarefas/tarefas_status/view.php?id=$status_id");
    exit();
} else {
    header("Location: /index.php");
    exit();
}
