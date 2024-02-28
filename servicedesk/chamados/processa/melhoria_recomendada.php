<?php
session_start();
if (isset($_SESSION['id']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificando se o campo conf_id_chamado foi enviado pelo formulário
    if (isset($_POST["conf_id_chamado"])) {
        $id_chamado = $_POST["conf_id_chamado"];
        $melhoria_recomendada = $_POST["chamado_melhoria_recomendada"];

        require "../../../conexoes/conexao_pdo.php";

        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta SQL para realizar o update
            $sql = "UPDATE chamados SET melhoria_recomendada = :melhoria_recomendada WHERE id = :id_chamado";

            // Preparar a consulta
            $stmt = $pdo->prepare($sql);

            // Executar a consulta com os parâmetros
            $stmt->execute([
                ':melhoria_recomendada' => $melhoria_recomendada,
                ':id_chamado' => $id_chamado
            ]);
            header("Location: /servicedesk/chamados/visualizar_chamado.php?id=$id_chamado");

            exit();
        } catch (PDOException $e) {
            echo "Erro na atualização: " . $e->getMessage();
        }
    } else {
        echo "ID do chamado não fornecido.";
    }
}
