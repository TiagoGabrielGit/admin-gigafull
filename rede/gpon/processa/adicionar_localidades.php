<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "../../../conexoes/conexao_pdo.php";

    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $loc_idPON = $_POST['loc_idPON'];

    $sql = "INSERT INTO gpon_localidades (cidade, bairro, pon_id, active) VALUES (:cidade, :bairro, :idPON, '1')";

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
        $stmt->bindParam(':bairro', $bairro, PDO::PARAM_STR);
        $stmt->bindParam(':idPON', $loc_idPON, PDO::PARAM_INT);

        // Executar a consulta SQL
        $stmt->execute();

        // Redirecionar de volta à página anterior ou a outra página de sua escolha
        header("Location: /rede/gpon/pon_view.php?id=$loc_idPON");
        exit();
    } catch (PDOException $e) {
        header("Location: /rede/gpon/pon_view.php?id=$loc_idPON");
        exit();
    }
} else {

    header("Location: /rede/gpon/pon_view.php?id=$loc_idPON");
    exit();
}
