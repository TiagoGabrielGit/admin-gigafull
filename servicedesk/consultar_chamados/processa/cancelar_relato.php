<?php
session_start();
if ($_SESSION['id']) {
    if ($_SERVER["REQUEST_METHOD"] === "GET") {
        $chamadoID = $_GET['idChamado'];

        require "../../../conexoes/conexao_pdo.php";

        try {
            // Preparar a consulta SQL
            $sql = "UPDATE chamados SET in_execution_start = NULL, in_execution = 0, in_execution_atd_id = 0 WHERE id = :chamadoID";
            $stmt = $pdo->prepare($sql);

            // Executar a consulta com o valor do parâmetro
            $stmt->bindParam(":chamadoID", $chamadoID, PDO::PARAM_INT);
            $stmt->execute();

            // Verificar se o update foi bem-sucedido
            $affectedRows = $stmt->rowCount();
            if ($affectedRows > 0) {
                // Preparar a consulta SQL para deletar os registros da tabela chamados_relatos_rascunho
                $sql_delete = "DELETE FROM chamados_relatos_rascunho WHERE id_chamado = :chamadoID";
                $stmt_delete = $pdo->prepare($sql_delete);

                // Executar o delete com o valor do parâmetro
                $stmt_delete->bindParam(":chamadoID", $chamadoID, PDO::PARAM_INT);
                $stmt_delete->execute();
                $affectedRowsDelete = $stmt_delete->rowCount();
                if ($affectedRowsDelete > 0) {
                    //echo "Cancelado execução de chamado e realizado exclusão de rascunho de relato.";
                    header("Location: /servicedesk/consultar_chamados/view.php?id=$chamadoID&success=1");
                    exit;
                } else {
                    //echo "Cancelada execuç~eo de chamado e nenhum rascunho de chamado encontrado com o ID informado.";
                    header("Location: /servicedesk/consultar_chamados/view.php?id=$chamadoID&success=2");
                    exit;
                }
            } else {
                //echo "Nenhum chamado encontrado com o ID informado.";
                header("Location: /servicedesk/consultar_chamados/view.php?id=$chamadoID&error=1");
                exit;
            }
        } catch (PDOException $e) {
            // Tratar erros de conexão ou consultas SQL
            echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
        }
    }
}
