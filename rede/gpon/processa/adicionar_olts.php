<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "../../../conexoes/conexao_pdo.php";
    try {

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Recupera os valores enviados via POST
        $equipamento_id = $_POST['equipamento'];
        $cidade = $_POST['cidade'];
        $usuarioIntegracao = $_POST['usuarioIntegracao'];
        $senhaIntegracao = $_POST['senhaIntegracao'];
        $identificacao = $_POST['identificacao'];
        $active = "1";

        $sql = "INSERT INTO gpon_olts (equipamento_id, olt_name, city, olt_username, olt_password, active) 
                               VALUES (:equipamento_id, :olt_name, :city, :olt_username, :olt_password, :active)";

        // Prepara e executa a declaração preparada
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':equipamento_id', $equipamento_id, PDO::PARAM_INT);
        $stmt->bindParam(':olt_name', $identificacao, PDO::PARAM_STR);
        $stmt->bindParam(':city', $cidade, PDO::PARAM_STR);
        $stmt->bindParam(':olt_username', $usuarioIntegracao, PDO::PARAM_STR);
        $stmt->bindParam(':olt_password', $senhaIntegracao, PDO::PARAM_STR);
        $stmt->bindParam(':active', $active, PDO::PARAM_INT);

        $stmt->execute();
        $lastInsertedId = $pdo->lastInsertId();

        header("Location: /rede/gpon/olt_view.php?id=$lastInsertedId");
        exit();
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            header("Location: /rede/gpon/index.php?gpon=olt&error=codigo_ja_existe");
            exit();
        } else {
            header("Location: /rede/gpon/index.php?gpon=olt");
            exit();
        }
    }
}
