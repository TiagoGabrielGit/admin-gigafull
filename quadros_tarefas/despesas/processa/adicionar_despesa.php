<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

        $tarefa_id = $_POST['tarefa_id'];
        $subcategoria = $_POST['subcategoria'];
        $valor = $_POST['valor'];

        // Converter o valor para formato numérico correto
        $valor = str_replace('.', '', $valor); // Remove os pontos de separação de milhar
        $valor = str_replace(',', '.', $valor); // Substitui a vírgula pelo ponto decimal

        try {
            $stmt = $pdo->prepare("INSERT INTO qt_despesas (id_subcategoria, id_tarefa, valor, active) VALUES (:id_subcategoria, :id_tarefa, :valor, 1)");
            $stmt->bindValue(':id_subcategoria', $subcategoria, PDO::PARAM_INT);
            $stmt->bindValue(':id_tarefa', $tarefa_id, PDO::PARAM_INT);
            $stmt->bindValue(':valor', $valor, PDO::PARAM_STR);

            if ($stmt->execute()) {
                header("Location: /quadros_tarefas/despesas/index.php?id=$tarefa_id");
                exit();
            } else {
                header("Location: /quadros_tarefas/despesas/index.php?id=$tarefa_id");
                exit();
            }
        } catch (PDOException $e) {
            echo "Erro ao adicionar despesa: " . $e->getMessage();
        }
    } else {
        header("Location: /index.php");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
