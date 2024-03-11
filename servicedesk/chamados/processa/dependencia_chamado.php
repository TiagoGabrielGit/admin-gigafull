<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../conexoes/conexao_pdo.php";

        $id_chamado = $_POST['conf_id_chamado'];
        $dependencia_chamado = $_POST['dependencia_chamado'];

        // Atualizar o tipo de chamado no banco de dados
        $sql_update_dependencia = "UPDATE chamados SET chamado_dependente = :chamado_dependente WHERE id = :chamado_id";
        $stmt = $pdo->prepare($sql_update_dependencia);
        $stmt->execute(['chamado_dependente' => $dependencia_chamado, 'chamado_id' => $id_chamado]);

        // Redirecionar para a página de detalhes do chamado ou outra página
        header("Location: /servicedesk/chamados/visualizar_chamado.php?id=$id_chamado");
        exit;
    } else {
        header("Location: /index.php");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
