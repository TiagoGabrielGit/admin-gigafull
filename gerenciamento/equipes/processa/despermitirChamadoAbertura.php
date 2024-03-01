<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../conexoes/conexao_pdo.php";

        // Capturando os dados do POST
        $tipo_id = $_POST['tipo_id'];
        $equipe_id = $_POST['equipe_id'];

        try {
            // Preparando a consulta SQL para remover o registro
            $remover_registro = "DELETE FROM chamados_autorizados_abertura WHERE tipo_id = :tipo_id AND equipe_id = :equipe_id";

            // Preparando e executando a consulta usando prepared statement
            $stmt = $pdo->prepare($remover_registro);
            $stmt->bindParam(':tipo_id', $tipo_id, PDO::PARAM_INT);
            $stmt->bindParam(':equipe_id', $equipe_id, PDO::PARAM_INT);
            $stmt->execute();

            // Verificando se a remoção foi bem-sucedida e retornando uma mensagem
            if ($stmt->rowCount() > 0) {
                echo "Registro removido com sucesso!";
            } else {
                echo "Nenhum registro foi removido.";
            }
        } catch (PDOException $e) {
            // Se ocorrer algum erro, exibe a mensagem de erro
            echo "Erro ao remover registro: " . $e->getMessage();
        }
    }
} else {
    // Se o usuário não estiver logado, redirecione para a página de login
    echo "not_logged_in";
}
?>
