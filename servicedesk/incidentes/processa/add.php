<?php
require "../../../conexoes/conexao_pdo.php";

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados enviados pelo formulário
    $incidente = $_POST["incidente"];
    $autor = $_POST["autor"];
    $classificacao = isset($_POST["classificacao"]) ? $_POST["classificacao"] : null;
    $vinculado = $_POST["vinculado"];
    $previsao = isset($_POST["previsao"]) ? $_POST["previsao"] : null;
    $equipamento = isset($_POST["equipamento"]) ? $_POST["equipamento"] : null;

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (empty($autor) || empty($incidente) || $classificacao === null || empty($vinculado)) {
        // Mensagem de erro
        echo "<p style='color:red;'>Error 1: Por favor, preencha todos os campos obrigatórios.</p>";
    } else if ($vinculado == "sim" && $equipamento == "") {
        echo "<p style='color:red;'>Error 2: Por favor, preencha todos os campos obrigatórios.</p>";
    } else {
        // Todos os campos estão preenchidos, continue com a lógica de salvamento no banco de dados
        $sql_insert_incidente =
            "INSERT INTO incidentes (autor_id, equipamento_id, descricaoIncidente, active, inicioIncidente, previsaoNormalizacao, classificacao)
         VALUES (:autor_id, :equipamento_id, :descricaoIncidente, '1', NOW(), :previsaoNormalizacao, :classificacao)";

        $stmt1 = $pdo->prepare($sql_insert_incidente);

        $stmt1->bindParam(':autor_id', $autor);
        $stmt1->bindParam(':equipamento_id', $equipamento);
        $stmt1->bindParam(':descricaoIncidente', $incidente);
        $stmt1->bindParam(':previsaoNormalizacao', $previsao, PDO::PARAM_NULL);
        $stmt1->bindParam(':classificacao', $classificacao, PDO::PARAM_INT);

        // Executa a consulta
        if ($stmt1->execute()) {
            echo "<p style='color:green;'>Incidente salvo com sucesso.</p>";
        } else {
            // Ocorreu um erro ao salvar
            echo "<p style='color:red;'>Error 3: Ocorreu um erro ao salvar o incidente.</p>";
        }
    }
} else {
    // A requisição não é do tipo POST, redireciona para a página do formulário
    header("Location: /servicedesk/incidentes/index.php");
    exit();
}
