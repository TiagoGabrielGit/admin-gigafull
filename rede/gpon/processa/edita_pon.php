<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['idPON'];
    $activePON = $_POST['activePON'];
    $codigo = $_POST['codigo'];
    require "../../../conexoes/conexao_pdo.php";
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erro de conexão com o banco de dados: " . $e->getMessage();
        exit();
    }

    // Preparar a consulta SQL para atualização
    $sql = "UPDATE gpon_pon SET active = :activePON, cod_int = :codigo WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':activePON', $activePON, PDO::PARAM_INT);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);

        // Executar a consulta SQL
        $stmt->execute();

        header("Location: /rede/gpon/pon_view.php?id=$id");
        exit();
    } catch (PDOException $e) {
        //echo "Erro na consulta SQL: " . $e->getMessage();
        if ($e->errorInfo[1] == 1062) {
            header("Location: /rede/gpon/pon_view.php?id=$id&error=codigo_ja_existe");
            exit();
        } else {
            header("Location: /rede/gpon/pon_view.php?id=$id");
            exit();
        }
    }
} else {
    header("Location: /rede/gpon/pon_view.php?id=$id");
    exit();
}
