<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');


    // Verificar se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Receber e sanitizar os dados
        $titulo = htmlspecialchars(trim($_POST['titulo']));
        $status = intval($_POST['status']);
        $id = intval($_POST['id_quadro']); // Assumindo que você tem o ID do quadro para atualizar

        // Validar os dados
        if (empty($titulo)) {
            die("O campo Título do Quadro não pode estar vazio.");
        }
        if ($status != 1 && $status != 2) {
            die("Status inválido.");
        }

        // Atualizar o banco de dados
        try {
            $stmt = $pdo->prepare("UPDATE quadros SET titulo = :titulo, status = :status WHERE id = :id");
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            header("Location: /tarefas/quadros.php?id=" . $id);
            exit();
        } catch (PDOException $e) {
            die("Erro ao atualizar o quadro: " . $e->getMessage());
        }
    } else {
        echo "Método de requisição inválido.";
    }
} else {
    header("Location: /tarefas/quadros.php?id="  . $id);
    exit();
}
