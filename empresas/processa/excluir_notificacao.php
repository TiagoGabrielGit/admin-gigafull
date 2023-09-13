<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        require "../../conexoes/conexao_pdo.php";

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Coleta os dados do formulário
        $idMidia = $_POST["idMidia"];
        $excMidiaIdEmpresa = $_POST["excMidiaIdEmpresa"];

        $sql = "UPDATE empresas_notificacao SET active = 0 WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $idMidia, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: /empresas/view.php?id=$excMidiaIdEmpresa");
        exit;
    } catch (PDOException $e) {
        header("Location: /empresas/view.php?id=$excMidiaIdEmpresa");
        exit;
    }

    // Fecha a conexão PDO
    $pdo = null;
} else {
    echo "Este script não pode ser acessado diretamente.";
}
