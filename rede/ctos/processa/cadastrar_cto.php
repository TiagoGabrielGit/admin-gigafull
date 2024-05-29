<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

        $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
        $codigoIntegracao = isset($_POST['codigoIntegracao']) ? trim($_POST['codigoIntegracao']) : '';
        $latitude = isset($_POST['latitude']) ? trim($_POST['latitude']) : '';
        $longitude = isset($_POST['longitude']) ? trim($_POST['longitude']) : '';

        // Verifica se todos os campos obrigatórios foram preenchidos
        if (empty($titulo) || empty($codigoIntegracao) || empty($latitude) || empty($longitude)) {
            echo "Todos os campos são obrigatórios.";
            exit;
        }

        try {
            // Prepara a query de inserção
            $query = "INSERT INTO gpon_ctos (title, paintegration_code, lat, lng) VALUES (:titulo, :codigoIntegracao, :latitude, :longitude)";
            $stmt = $pdo->prepare($query);

            // Vincula os parâmetros
            $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $stmt->bindParam(':codigoIntegracao', $codigoIntegracao, PDO::PARAM_STR);
            $stmt->bindParam(':latitude', $latitude, PDO::PARAM_STR);
            $stmt->bindParam(':longitude', $longitude, PDO::PARAM_STR);

            // Executa a query
            if ($stmt->execute()) {
                header("Location: /rede/ctos/index.php#");
                exit();
            } else {
                header("Location: /rede/ctos/index.php#");
                exit();
            }
        } catch (PDOException $e) {
            // Trata erros de conexão ou execução da query
            echo "Erro: " . $e->getMessage();
        }
    } else {
        // Se o método não for POST, exibe uma mensagem de erro
        echo "Método de requisição inválido.";
    }
} else {
    header("Location: /index.php");
    exit();
}
