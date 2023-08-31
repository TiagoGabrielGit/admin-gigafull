<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../conexoes/conexao_pdo.php";

    try {

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $codigoRota = $_POST["codigoRota"];
        $pontaA = $_POST["pontaA"];
        $pontaB = $_POST["pontaB"];
        $active = "1";

        $sql = "INSERT INTO rotas_fibra (codigo, ponta_a, ponta_b, active) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$codigoRota, $pontaA, $pontaB, $active]);
        $idRota = $pdo->lastInsertId();

        if ($stmt->rowCount() > 0) {
            header("Location: /rede/rotas_de_fibra/view.php?id=$idRota");
            exit;
        } else {
            header("Location: /rede/rotas_de_fibra/index.php");
            exit;
        }
    } catch (PDOException $e) {
        if ($e->errorInfo[1] === 1062) {
            header("Location: /rede/rotas_de_fibra/index.php?rotasDeFibra=rotas&error=codigo_ja_existe");
            exit;
        } else {
            echo "Ocorreu um erro durante a inserção: " . $e->getMessage();
        }
    }

    $pdo = null;
} else {
    echo "Método inválido de requisição.";
}
