<?php
session_start();

if (isset($_SESSION['id'])) {
    require "../../../conexoes/conexao_pdo.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitizar e validar os dados do formulário
        $descricaoZabbix = trim($_POST['descricaoZabbix']);
        $tokenAPI = trim($_POST['tokenAPI']);
        $urlZabbix = trim($_POST['urlZabbix']);

        // Verificar se a descrição é vazia
        if (empty($descricaoZabbix)) {
            die('Descrição é obrigatória.');
        }

        // Verificar se a URL é um formato válido
        if (!filter_var($urlZabbix, FILTER_VALIDATE_URL)) {
            die('URL inválida.');
        }

        // Preparar a consulta SQL para inserir os dados
        $query = "INSERT INTO integracao_zabbix (descricao, tokenAPI, urlZabbix, statusIntegracao) VALUES (:descricao, :token, :url, 1)";

        try {
            // Preparar a declaração
            $stmt = $pdo->prepare($query);

            // Vincular os parâmetros
            $stmt->bindParam(':descricao', $descricaoZabbix);
            $stmt->bindParam(':token', $tokenAPI);
            $stmt->bindParam(':url', $urlZabbix);

            // Executar a declaração
            if ($stmt->execute()) {
                // Redirecionar para uma página de sucesso ou exibir uma mensagem
                header('Location: /integracao/zabbix/index.php'); // Redirecionar para uma página de sucesso
                exit;
            } else {
                echo 'Erro ao inserir os dados: ' . implode(", ", $stmt->errorInfo());
            }
        } catch (PDOException $e) {
            echo 'Erro na preparação da declaração: ' . $e->getMessage();
        }
    }
} else {
    header("Location: /index.php");
    exit();
}
?>
