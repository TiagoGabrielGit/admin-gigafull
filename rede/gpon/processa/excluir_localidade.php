<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "../../../conexoes/conexao_pdo.php";
    $locID = $_POST['locID'];
    $locPONID = $_POST['locPONID'];
    
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erro de conexão com o banco de dados: " . $e->getMessage();
        exit();
    }

    $sql = "UPDATE gpon_localidades SET active = 0 WHERE id = :locID";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':locID', $locID, PDO::PARAM_INT);

        $stmt->execute();

        header("Location: /rede/gpon/pon_view.php?id=$locPONID");
        exit();
    } catch (PDOException $e) {
        //echo "Erro na consulta SQL: " . $e->getMessage();
        header("Location: /rede/gpon/pon_view.php?id=$locPONID");
        exit();
    }
} else {
    header("Location: /rede/gpon/pon_view.php?id=$locPONID");
    exit();
}
