<?php
session_start();
if (isset($_SESSION['id']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        require "../../../conexoes/conexao_pdo.php";
        // Obtendo os dados do formulário
        $idBateria = $_POST['idBateria'];
        $dataRetirada = $_POST['dataRetirada' . $idBateria];
        $userRetirada = $_SESSION['id'];
        $status = "0";
        $idPOP = $_POST['idPOPBateriaRetirada'];

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE pop_baterias_in_use SET data_retirada = :dataRetirada, status = :status, user_retirada = :user_retirada WHERE id = :idBateria";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dataRetirada', $dataRetirada);
        $stmt->bindParam(':idBateria', $idBateria);
        $stmt->bindParam(':user_retirada', $userRetirada);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        header("Location: /telecom/sitepop/view.php?id=$idPOP");
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
 