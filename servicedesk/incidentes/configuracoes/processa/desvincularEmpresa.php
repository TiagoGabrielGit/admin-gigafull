<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        require "../../../../conexoes/conexao_pdo.php";
        
        // Verifica se o parâmetro 'id' está presente na requisição GET
        if (isset($_GET["id"])) {
            $id = $_GET["id"];

            // Prepara a consulta SQL para excluir o registro com o ID fornecido
            $sql = "DELETE FROM incidentes_types_empresa WHERE id = :id";
            $stmt = $pdo->prepare($sql);

            // Executa a consulta, passando o valor do ID como parâmetro
            $stmt->execute(['id' => $id]);

            // Redireciona de volta para a página anterior após o processamento
            header("Location: /servicedesk/incidentes/configuracoes/index.php");
            exit();
        } else {
            echo "ID não fornecido.";
        }
    } else {
        echo "Método de requisição inválido.";
    }
} else {
    header("Location: /index.php");
}
?>
