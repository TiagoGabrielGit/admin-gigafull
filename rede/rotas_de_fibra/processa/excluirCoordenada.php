<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "../../../conexoes/conexao_pdo.php";

    $coordenadaId = $_POST['coordenada_id'];
    $rotaID = $_POST['rotaID'];

    try {
        $sql = "UPDATE rotas_fibras_coordenadas SET active = 0 WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        // Executar a consulta
        $stmt->execute([$coordenadaId]);

        // Redirecionar para a página anterior com uma mensagem de sucesso
        header("Location: /rede/rotas_de_fibra/view.php?id=$rotaID");
        exit();
    } catch (PDOException $e) {
        // Redirecionar para a página anterior com uma mensagem de erro
        header("Location: /rede/rotas_de_fibra/view.php?id=$rotaID");
        exit();
    }
} else {
    // Redirecionar se a solicitação não for do tipo POST
    header("Location: /rede/rotas_de_fibra/view.php?id=$rotaID");
    exit();
}
