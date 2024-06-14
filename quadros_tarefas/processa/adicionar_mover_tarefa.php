<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Inserir nova tarefa
        if (isset($_POST['new_task']) && isset($_POST['quadro_id'])) {
            $new_task = htmlspecialchars($_POST['new_task']);
            $quadro_id = (int)$_POST['quadro_id'];

            // Primeiro, encontramos a maior ordem atual
            $stmt = $pdo->prepare("SELECT COALESCE(MAX(ordem), 0) AS max_ordem FROM tarefas WHERE quadro_id = :quadro_id");
            $stmt->execute(['quadro_id' => $quadro_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $max_ordem = $result['max_ordem'] + 1;

            // Depois, inserimos a nova tarefa com a ordem encontrada +1
            $stmt = $pdo->prepare("INSERT INTO tarefas (descricao, ordem, quadro_id, status, created) VALUES (:descricao, :ordem, :quadro_id, 1, NOW())");
            $stmt->execute(['descricao' => $new_task, 'ordem' => $max_ordem, 'quadro_id' => $quadro_id]);
        }

        // Reordenar tarefas
        if (isset($_POST['task_order']) && isset($_POST['quadro_id'])) {
            $ordered_tasks = explode(',', $_POST['task_order']);
            foreach ($ordered_tasks as $new_order => $task_id) {
                $stmt = $pdo->prepare("UPDATE tarefas SET ordem = :ordem WHERE id = :id");
                $stmt->execute(['ordem' => $new_order + 1, 'id' => $task_id]);
            }
        }

        header("Location: /quadros_tarefas/quadros/quadros_view.php?id=" . $quadro_id);
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
