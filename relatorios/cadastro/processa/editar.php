<?php


// Verifica se a requisição foi feita por método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os valores enviados pelo formulário

    if (empty($_POST['consulta_nome']) || empty($_POST['consulta_nome'])) {
        echo "Error: Dados obrigatórios não preenchidos!";
    } else {

        $id = $_POST['idConsulta'];
        $consultaNome = $_POST['consulta_nome'];
        $consultaSql = $_POST['consulta_sql'];
        $statusConsulta = $_POST['statusConsulta'];

        require "../../../conexoes/conexao_pdo.php";

        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE consultas_sql SET consulta_identificacao = :consultaNome, consulta_sql = :consultaSql, active = :statusConsulta WHERE id = :id ";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':consultaSql', $consultaSql);
            $stmt->bindParam(':consultaNome', $consultaNome);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':statusConsulta', $statusConsulta);

            // Executa a consulta
            $stmt->execute();

            echo $id;
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
