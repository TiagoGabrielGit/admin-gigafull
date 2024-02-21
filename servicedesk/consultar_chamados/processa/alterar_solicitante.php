<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../conexoes/conexao_pdo.php";

        $novo_solicitante_id = $_POST['chamado_solicitante'];
        $chamado_id = $_POST['conf_id_chamado'];

        // Consultar a tabela equipes_integrantes para obter a equipe do usuário
        $equipe_stmt = $pdo->prepare("SELECT equipe_id FROM equipes_integrantes WHERE integrante_id = :usuario_id");
        $equipe_stmt->execute(['usuario_id' => $novo_solicitante_id]);
        $equipe_result = $equipe_stmt->fetch(PDO::FETCH_ASSOC);
        $solicitante_equipe_id = $equipe_result['equipe_id'];

        // Atualizar o tipo de chamado e a equipe do solicitante no banco de dados
        $sql_update_chamado = "UPDATE chamados SET solicitante_id = :novo_solicitante_id, solicitante_equipe_id = :equipe_id WHERE id = :chamado_id";
        $stmt = $pdo->prepare($sql_update_chamado);
        $stmt->execute(['novo_solicitante_id' => $novo_solicitante_id, 'equipe_id' => $solicitante_equipe_id, 'chamado_id' => $chamado_id]);

        // Redirecionar para a página de detalhes do chamado ou outra página
        header("Location: /servicedesk/consultar_chamados/view.php?id=$chamado_id");
        exit;
    }
} else {
    header("Location: /index.php");
    exit();
}
