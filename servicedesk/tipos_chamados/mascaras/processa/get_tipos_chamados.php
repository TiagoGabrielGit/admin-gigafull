<?php
session_start();
if (isset($_SESSION['id'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["empresa"])) {
            require "../../../../conexoes/conexao_pdo.php";

            $empresa_id = $_POST["empresa"];

            try {
                // Consulta SQL para obter os tipos de chamados que ainda não possuem uma máscara para a empresa selecionada
                $query_tipos_chamados = "SELECT id, tipo as nome FROM tipos_chamados WHERE active = 1 and id NOT IN (SELECT tipo_chamado_id FROM tipos_chamados_mascaras WHERE empresa_id = :empresa_id and active = 1) order by nome asc";
                $stmt = $pdo->prepare($query_tipos_chamados);
                $stmt->bindParam(":empresa_id", $empresa_id, PDO::PARAM_INT);
                $stmt->execute();

                // Retorna os resultados como JSON
                echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            } catch (PDOException $e) {
                // Em caso de erro, retorna uma mensagem de erro
                echo json_encode(array("error" => $e->getMessage()));
            }
        } else {
            // Se o parâmetro empresa não foi enviado, retorna uma mensagem de erro
            echo json_encode(array("error" => "O parâmetro 'empresa' não foi fornecido."));
        }
    } else {
        // Se a solicitação não for do tipo POST, retorna uma mensagem de erro
        echo json_encode(array("error" => "Este script aceita apenas solicitações POST."));
    }
} else {
    header('Location: /index.php');
    exit();
}
