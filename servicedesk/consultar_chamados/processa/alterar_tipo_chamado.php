<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['chamado_tipo_chamado'])) {
            require "../../../conexoes/conexao_pdo.php";
            $novo_tipo_id = $_POST['chamado_tipo_chamado'];
            $chamado_id = $_POST['conf_id_chamado'];

            // Atualizar o tipo de chamado no banco de dados
            $sql_update_tipo_chamado = "UPDATE chamados SET tipochamado_id = :novo_tipo_id WHERE id = :chamado_id";
            $stmt = $pdo->prepare($sql_update_tipo_chamado);
            $stmt->execute(['novo_tipo_id' => $novo_tipo_id, 'chamado_id' => $chamado_id]);

            // Redirecionar para a página de detalhes do chamado ou outra página
            header("Location: /servicedesk/consultar_chamados/view.php?id=$chamado_id");
            exit;
        }
    }
} else {
    header("Location: /index.php");
    exit();
}
