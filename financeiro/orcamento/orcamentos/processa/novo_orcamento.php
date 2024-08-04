<?php
session_start();

if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Sanitiza a entrada
        $orcamento = htmlspecialchars($_POST['orcamento']);
        $created_by = $_SESSION['id'];
        $created_date = date('Y-m-d');

        // Prepara a consulta SQL para inserir os dados
        $sql = "INSERT INTO cc_orcamento (orcamento, created_by, created_date) VALUES (:orcamento, :created_by, :created_date)";
        $stmt = $pdo->prepare($sql);

        // Faz o bind dos parâmetros
        $stmt->bindParam(':orcamento', $orcamento, PDO::PARAM_STR);
        $stmt->bindParam(':created_by', $created_by, PDO::PARAM_INT);
        $stmt->bindParam(':created_date', $created_date, PDO::PARAM_STR);

        // Tenta executar a consulta
        try {
            $stmt->execute();
            header("Location: ../index.php");
            exit;
        } catch (Exception $e) {
            header("Location: ../index.php");
            exit;
        }
    } else {
        header("Location: ../index.php");
        exit;
    }
} else {
    header("Location: /index.php");
    exit;
}
