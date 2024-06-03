<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require "../../../conexoes/conexao_pdo.php";

        $oltID = $_POST['oltID'];
        $intID = $_POST['intID'];

        try {
            $sql = "UPDATE gpon_olts_interessados SET active = 0 WHERE id = ?";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(1, $intID, PDO::PARAM_INT);


            // Executar a consulta
            $stmt->execute();

            // Redirecionar para a página anterior com uma mensagem de sucesso
            header("Location: /rede/gpon/interessados.php?olt_id=$oltID");
            exit();
        } catch (PDOException $e) {
            // Redirecionar para a página anterior com uma mensagem de erro
            header("Location: /rede/gpon/interessados.php?olt_id=$oltID");
            exit();
        }
    } else {
        // Redirecionar se a solicitação não for do tipo POST
        header("Location: /rede/gpon/interessados.php?olt_id=$oltID");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
