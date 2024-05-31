<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

        $empresa_id = $_POST['empresa'];
        $usuarioOZ = $_POST['usuarioOZ'];

        // Prepara a consulta SQL para inserir na tabela integracao_ozmap_empresas
        $query = "INSERT INTO integracao_ozmap_empresas (empresa_id, usuario_oz) VALUES (:empresa_id, :usuarioOZ)";

        // Prepara e executa a consulta usando PDO prepared statements
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':empresa_id', $empresa_id, PDO::PARAM_INT);
        $stmt->bindParam(':usuarioOZ', $usuarioOZ, PDO::PARAM_STR);

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
