<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../conexoes/conexao_pdo.php";

        // Capturando os dados do POST
        $tipo_id = $_POST['tipo_id'];
        $equipe_id = $_POST['equipe_id'];

        try {
            // Preparando a consulta SQL para inserir os dados
            $inserir_dados = "INSERT INTO chamados_autorizados_atender (tipo_id, equipe_id) VALUES (:tipo_id, :equipe_id)";
            $stmt = $pdo->prepare($inserir_dados);

            // Ligando os parâmetros
            $stmt->bindParam(':tipo_id', $tipo_id);
            $stmt->bindParam(':equipe_id', $equipe_id);

            // Executando a consulta
            $stmt->execute();

            // Responder à solicitação AJAX com sucesso
            echo "success";
        } catch (PDOException $e) {
            // Responder à solicitação AJAX com erro
            echo "Erro ao inserir dados: " . $e->getMessage();
        }
    }
} else {
    // Se o usuário não estiver logado, redirecione para a página de login
    echo "not_logged_in";
}
