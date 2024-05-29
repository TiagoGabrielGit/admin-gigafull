<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    // Dados a serem inseridos
    $descricaoAPI = filter_input(INPUT_POST, 'descricaoAPI', FILTER_SANITIZE_STRING);
    $api = filter_input(INPUT_POST, 'api', FILTER_SANITIZE_STRING);

    try {
        // SQL para inserção
        $sql = "INSERT INTO integracao_ozmap_api (descricaoAPI, api) VALUES (:descricaoAPI, :api)";
        $stmt = $pdo->prepare($sql);

        // Vinculando os parâmetros
        $stmt->bindParam(':descricaoAPI', $descricaoAPI);
        $stmt->bindParam(':api', $api);

        // Executando a consulta
        $stmt->execute();
        
        // Redirecionando após a inserção bem-sucedida
        header("Location: /integracao/ozmap/index.php");
        exit();
    } catch (PDOException $e) {
        // Log o erro ou mostre uma mensagem amigável para o usuário
        error_log("Erro ao inserir o registro: " . $e->getMessage());
        echo "Ocorreu um erro ao inserir os dados. Por favor, tente novamente mais tarde.";
    }
} else {
    header("Location: /index.php");
    exit();
}
?>
