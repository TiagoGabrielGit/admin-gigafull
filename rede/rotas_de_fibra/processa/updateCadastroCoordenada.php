<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "../../../conexoes/conexao_pdo.php";

    $id = $_POST['id'];
    $pontaA = $_POST['pontaA'];
    $pontaB = $_POST['pontaB'];
    $codigoRota = $_POST['codigoRota'];
    $active = $_POST['activeRota'];

    try {
        $sql = "UPDATE rotas_fibra SET ponta_a = ?, ponta_b = ?, codigo = ?, active = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([$pontaA, $pontaB, $codigoRota, $active, $id]);

        header("Location: /rede/rotas_de_fibra/view.php?id=$id");
        exit();
    } catch (PDOException $e) {
        if ($e->errorInfo[1] === 1062) {
            header("Location: /rede/rotas_de_fibra/view.php?id=$id&error=codigo_ja_existe");
            exit;
        } else {
            echo "Ocorreu um erro durante a inserção: " . $e->getMessage();
        }
    }
} else {
    header("Location: /rede/rotas_de_fibra/view.php?id=$id");
    exit();
}
 