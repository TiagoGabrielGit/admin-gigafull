<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require "../../../conexoes/conexao_pdo.php";

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id = $_POST['id'];
        $active = $_POST['activeOLT'];
        $oltName = $_POST['oltName'];
        $cidadeOLT = $_POST['cidadeOLT'];
        $usuarioIntegracao = $_POST['usuarioIntegracao'];
        $senhaIntegracao = $_POST['senhaIntegracao'];

        // Atualiza os dados na tabela gpon_olts
        $sql = "UPDATE gpon_olts SET active = :active, olt_name = :oltName, city = :cidadeOLT, olt_username = :usuarioIntegracao, olt_password = :senhaIntegracao WHERE id = :id";

        // Prepara e executa a declaração preparada
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':active', $active, PDO::PARAM_INT);
        $stmt->bindParam(':oltName', $oltName, PDO::PARAM_STR);
        $stmt->bindParam(':cidadeOLT', $cidadeOLT, PDO::PARAM_STR);
        $stmt->bindParam(':usuarioIntegracao', $usuarioIntegracao, PDO::PARAM_STR);
        $stmt->bindParam(':senhaIntegracao', $senhaIntegracao, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        // Redireciona para a página de sucesso ou outra página após a atualização
        header("Location: /rede/gpon/olt_view.php?id=$id");
        exit();
    } catch (PDOException $e) {
        // Em caso de erro, redirecione para uma página de erro genérica ou faça outra ação apropriada
        header("Location: /rede/erro_generico.php");
        exit();
    }
} else {
    // Se o método de requisição não for POST, redirecione para outra página ou exiba uma mensagem de erro
    echo "Método de requisição inválido";
    // Ou redirecione para outra página usando header() ou exiba uma mensagem de erro
}
