<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "../../../conexoes/conexao_pdo.php";

    $intID = $_POST['intID'];

    try {
        $sql = "UPDATE rotas_fibras_interessados SET active = 0 WHERE id = ?";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(1, $intID, PDO::PARAM_INT);


        // Executar a consulta
        $stmt->execute();

        // Redirecionar para a página anterior com uma mensagem de sucesso
        header("Location: /rede/rotas_de_fibra/index.php?rotasDeFibra=interessados");
        exit();
    } catch (PDOException $e) {
        // Redirecionar para a página anterior com uma mensagem de erro
        header("Location: /rede/rotas_de_fibra/index.php?rotasDeFibra=interessados");
        exit();
    }
} else {
    // Redirecionar se a solicitação não for do tipo POST
    header("Location: /rede/rotas_de_fibra/index.php?rotasDeFibra=interessados");
    exit();
}
