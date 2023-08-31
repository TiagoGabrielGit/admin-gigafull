<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "../../../conexoes/conexao_pdo.php";

    $rota_fibra_id = $_POST['idRota'];
    $coordenadaInicial = $_POST['coordenada_inicial'];
    $coordenadaFinal = $_POST['coordenada_final'];
    $proprietario = $_POST['proprietario'];
    $active = "1";

    try {
        // Preparar a consulta SQL
        $sql = "INSERT INTO rotas_fibras_coordenadas (rota_fibra_id, coordenada_inicial, coordenada_final, proprietario, active) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        // Executar a consulta
        $stmt->execute([$rota_fibra_id, $coordenadaInicial, $coordenadaFinal, $proprietario, $active]);

        // Redirecionar para a página anterior com uma mensagem de sucesso
        header("Location: /rede/rotas_de_fibra/view.php?id=$rota_fibra_id");
        exit();
    } catch (PDOException $e) {
        // Redirecionar para a página anterior com uma mensagem de erro
        header("Location: /rede/rotas_de_fibra/view.php?id=$rota_fibra_id");
        exit();
    }
} else {
    // Redirecionar se o formulário não foi enviado
    header("Location: /rede/rotas_de_fibra/view.php?id=$rota_fibra_id");
    exit();
}
