<?php
require "../../../conexoes/conexao_pdo.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['idUsuario'];
    $url_dashboard = $_POST['urlDashboard'];


    $sql = "UPDATE usuarios SET url_dashboard = :url_dashboard WHERE id = :id";

    // Preparar a consulta
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':url_dashboard', $url_dashboard);
    $stmt->bindValue(':id', $id);

    // Executar a consulta
    if ($stmt->execute()) {
        header("Location: /gerenciamento/usuarios/profile.php?id=$id");
        exit;
    } else {
        header("Location: /gerenciamento/usuarios/profile.php?id=$id");
        exit;
    }
}
