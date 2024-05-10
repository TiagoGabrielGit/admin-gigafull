<?php
session_start();

if (isset($_SESSION['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $empresa = $_POST['empresa'];
    $tipo_incidente_id = $_POST['tipo_informativo'];

    // Gere um token aleatório
    $token = bin2hex(random_bytes(16)); // Gera um token de 32 caracteres

    require "../../../../conexoes/conexao_pdo.php";

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar a declaração SQL para inserção
        $sql = "INSERT INTO incidentes_iframe (titulo, tipo_incidente_id, empresa_id, token, active) VALUES (:titulo, :tipo_incidente_id, :empresa, :token, 1)";
        $stmt = $pdo->prepare($sql);

        // Bind dos parâmetros
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':tipo_incidente_id', $tipo_incidente_id);

        $stmt->bindParam(':empresa', $empresa);
        $stmt->bindParam(':token', $token);

        // Executar a declaração SQL
        if ($stmt->execute()) {
            $lastID = $pdo->lastInsertId();

            header("Location: /servicedesk/incidentes/iframe/edit.php?id=$lastID");
            exit;
        } else {
            header("Location: /servicedesk/incidentes/iframe/index.php");
            exit;
        }
    } catch (PDOException $e) {
        echo "Erro ao inserir dados: " . $e->getMessage();
    }

    $pdo = null;
} else {
    header("Location: /index.php");
    exit;
}
