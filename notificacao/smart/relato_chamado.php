<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../conexoes/conexao_pdo.php";

    $id_chamado = $_POST['id_chamado'];

    try {
        $infos_chamado = "SELECT
            c.assuntoChamado as assunto,
            c.relato_inicial as relato,
            c.data_abertura as data_abertura,
            tc.tipo as tipo_chamado,
            e.fantasia as empresa,
            p.nome as atendente,
            c.id as chamado_id
            FROM chamados as c
            LEFT JOIN tipos_chamados as tc ON tc.id = c.tipochamado_id
            LEFT JOIN empresas as e ON e.id = c.empresa_id
            LEFT JOIN usuarios as u ON u.id = c.atendente_id
            LEFT JOIN pessoas as p ON p.id = u.pessoa_id
            WHERE c.id = :id_chamado";

        $stmt_infos_chamado = $pdo->prepare($infos_chamado);
        $stmt_infos_chamado->bindParam(':id_chamado', $id_chamado);
        $stmt_infos_chamado->execute();
        $c_infos_chamado = $stmt_infos_chamado->fetch(PDO::FETCH_ASSOC);
        $titulo = $c_infos_chamado['assunto'];
        $empresa = $c_infos_chamado['empresa'];
        $chamado_id = $c_infos_chamado['chamado_id'];
        // Consulta para obter o último relato do chamado
        $ultimo_relato = "SELECT
            p.nome as 'relatante',
            cr.relato as 'relato',
            cr.private as 'privacidade'
            FROM chamado_relato as cr
            LEFT JOIN usuarios as u ON u.id = cr.relator_id
            LEFT JOIN pessoas as p ON p.id = u.pessoa_id
            WHERE cr.chamado_id = :id_chamado
            ORDER BY cr.id DESC
            LIMIT 1 ";

        $stmt_ultimo_relato = $pdo->prepare($ultimo_relato);
        $stmt_ultimo_relato->bindParam(':id_chamado', $id_chamado);
        $stmt_ultimo_relato->execute();
        $c_ultimo_relato = $stmt_ultimo_relato->fetch(PDO::FETCH_ASSOC);
        $ultimo_relato = $c_ultimo_relato['relato'];
        $relatante = $c_ultimo_relato['relatante'];
        $privacidade = $c_ultimo_relato['privacidade'];

        // Consulta para obter a lista de destinatários
        if ($privacidade == 1) { //Publico
            $lista_destinatarios =
                "SELECT u.id as 'id_usuario'
            FROM usuarios u
            JOIN pessoas p ON p.id = u.pessoa_id
            WHERE u.notify_smart= 1 and u.notify_email_relatos = 1 and u.active = 1

            UNION 

            SELECT u.id as 'id_usuario'
            FROM usuarios u
            JOIN equipes_integrantes ei1 ON u.id = ei1.integrante_id
            JOIN equipes_integrantes ei2 ON ei1.equipe_id = ei2.equipe_id
            JOIN chamados c ON ei2.integrante_id = c.solicitante_id
            JOIN pessoas p ON p.id = u.pessoa_id 
            WHERE u.id != 9999 and c.id = :id_chamado and u.notify_smart= 1 and u.notify_email_relatos = 2 and u.active = 1

            UNION

            SELECT u.id as 'id_usuario'
            FROM chamados as c
            LEFT JOIN usuarios as u ON u.id = c.atendente_id
            LEFT JOIN pessoas as p ON p.id = u.pessoa_id
            WHERE c.id = :id_chamado and u.notify_smart= 1";
        } else if ($privacidade == 2) { //Privado
            $lista_destinatarios =
                "SELECT u.id as 'id_usuario'
            FROM usuarios u
            JOIN pessoas p ON p.id = u.pessoa_id
            WHERE  u.notify_smart= 1 and u.notify_email_relatos = 1 and u.active = 1

            UNION

            SELECT u.id as 'id_usuario'
            FROM chamados as c
            LEFT JOIN usuarios as u ON u.id = c.atendente_id
            LEFT JOIN pessoas as p ON p.id = u.pessoa_id
            WHERE c.id = :id_chamado and u.notify_smart= 1";
        }

        $stmt_destinatarios = $pdo->prepare($lista_destinatarios);
        $stmt_destinatarios->bindParam(':id_chamado', $id_chamado);
        $stmt_destinatarios->execute();
        $result = $stmt_destinatarios;

        if ($result->rowCount() > 0) {
            // Loop para inserir notificações para cada destinatário
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $usuario_id = $row['id_usuario'];
                $mensagem = "Um novo relato foi adicionado no chamado $id_chamado por $relatante.";

                $insert_query = "INSERT INTO smart_notification (usuario_id, status, mensagem_tipo, chamado_id, mensagem, date) VALUES (:usuario_id, '1', '3', :chamado_id, :mensagem, NOW())";
                $stmt_insert = $pdo->prepare($insert_query);
                $stmt_insert->bindParam(':usuario_id', $usuario_id);
                $stmt_insert->bindParam(':chamado_id', $chamado_id);
                $stmt_insert->bindParam(':mensagem', $mensagem);
                $stmt_insert->execute();
            }

            echo "Notificações enviadas com sucesso.";
        } else {
            echo "Nenhum resultado encontrado.";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    } finally {
        $pdo = null; // Fechando a conexão com o banco de dados
    }
}
