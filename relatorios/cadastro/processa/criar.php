<?php


// Verifica se a requisição foi feita por método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os valores enviados pelo formulário

    if (empty($_POST['consulta_nome']) || empty($_POST['consulta_nome'])) {
        echo "Error: Dados obrigatórios não preenchidos!";
    } else {

        $consultaNome = $_POST['consulta_nome'];
        $consultaSql = $_POST['consulta_sql'];

        require "../../../conexoes/conexao_pdo.php";

        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare a consulta SQL para inserir os dados no banco
            $sql = "INSERT INTO consultas_sql (consulta_identificacao, consulta_sql, active) VALUES (:consultaNome, :consultaSql, '1')";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':consultaNome', $consultaNome);
            $stmt->bindParam(':consultaSql', $consultaSql);

            // Executa a consulta
            $stmt->execute();

            // Obtenha o ID do registro inserido
            $idRegistroCriado = $pdo->lastInsertId();

            // Retorne o ID do registro para a requisição AJAX
            echo $idRegistroCriado;
        } catch (PDOException $e) {
            // Se ocorrer algum erro, retorne uma mensagem de erro e o código HTTP 500 (Internal Server Error)
            http_response_code(500);
            echo "Erro ao inserir os dados no banco de dados: " . $e->getMessage();
        }

        // Fecha a conexão com o banco de dados
        $pdo = null;
    }
} else {
    // Se a requisição não for feita por método POST, retorne um status de erro e o código HTTP 400 (Bad Request)
    http_response_code(400);
    echo "Requisição inválida";
}
