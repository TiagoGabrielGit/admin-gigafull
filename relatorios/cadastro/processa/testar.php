<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "../../../conexoes/conexao_pdo.php";

    // Parâmetros de consulta SQL enviados pelo JavaScript
    $consulta_sql = $_POST["consulta_sql"];

    try {
        // Configura o modo de erro do PDO para lançar exceções
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepara a consulta SQL
        $stmt = $pdo->prepare($consulta_sql);

        // Executa a consulta SQL
        $stmt->execute();

        // Obtém os resultados da consulta
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cria uma variável para armazenar os resultados
        $output = "";

        // Loop através dos resultados da consulta
        foreach ($results as $row) {
            // Adiciona cada linha dos resultados à saída
            $output .= implode(", ", $row) . "\n";
        }

        // Retorna os resultados
        echo $output;
    } catch (PDOException $e) {
        echo "Erro na consulta: " . $e->getMessage();
    }
}
