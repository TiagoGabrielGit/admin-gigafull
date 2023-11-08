<?php
session_start();
if (isset($_SESSION['id'])) {
    require "../../../../conexoes/conexao_pdo.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $sql = "INSERT INTO manutencao_programada_responsaveis_aceite (nome, email, active) VALUES (:nome, :email, 1)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':nome', $_POST['nome']);
            $stmt->bindParam(':email', $_POST['email']);

            $stmt->execute();

            header('Location: /servicedesk/manutencao_programada/responsaveis_aceite/index.php');
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
} else {
    echo "Usuário não autenticado";
}
