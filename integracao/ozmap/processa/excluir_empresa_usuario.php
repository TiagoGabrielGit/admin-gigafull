<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

        $cadastro_id = $_POST['cadastro_id'];

        $query = "DELETE FROM integracao_ozmap_empresas WHERE id = :cadastro_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':cadastro_id', $cadastro_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: /integracao/ozmap/index.php");
            exit();
        } else {
            header("Location: /integracao/ozmap/index.php");
            exit();
        }
    } else {
        header("Location: /integracao/ozmap/index.php");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
