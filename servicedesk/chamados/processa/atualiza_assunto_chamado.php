<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['assunto_chamado'])) {
            require "../../../conexoes/conexao_pdo.php";
            $assunto_chamado = $_POST['assunto_chamado'];
            $chamado_id = $_POST['conf_id_chamado'];

            // Atualizar o tipo de chamado no banco de dados
            $sql_update_tipo_chamado = "UPDATE chamados SET assuntoChamado = :assunto_chamado WHERE id = :chamado_id";
            $stmt = $pdo->prepare($sql_update_tipo_chamado);
            $stmt->execute(['assunto_chamado' => $assunto_chamado, 'chamado_id' => $chamado_id]);

            // Redirecionar para a página de detalhes do chamado ou outra página
            header("Location: /servicedesk/chamados/visualizar_chamado.php?id=$chamado_id");

            exit;
        }
    }
} else {
    header("Location: /index.php");
    exit();
}
