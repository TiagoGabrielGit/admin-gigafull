<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../conexoes/conexao_pdo.php";

    // Consulta se o envio de e-mail está habilitado
    $consulta_habilitado = "
        SELECT
            ne.active as active,
            ne.server_id as server_id
        FROM
            notificacao_email as ne
        WHERE
            ne.notificacao_id = 1
    ";

    // Executa a consulta no banco de dados
    $result_habilitado = $pdo->query($consulta_habilitado);
    $c_habilitado = $result_habilitado->fetch(PDO::FETCH_ASSOC);
    $active = $c_habilitado['active'];
    $server_id = $c_habilitado['server_id'];


    // Verifica se o envio de e-mail está habilitado
    if ($active == 1) {
        $id_chamado = $_POST['id_chamado'];

        $infos_chamado =
            "SELECT
            c.assuntoChamado as assunto,
            c.relato_inicial as relato,
            c.data_abertura as data_abertura,
            tc.tipo as tipo_chamado,
            e.fantasia as empresa
            FROM
            chamados as c
            LEFT JOIN
            tipos_chamados as tc
            ON
            tc.id = c.tipochamado_id
            LEFT JOIN
            empresas as e
            ON
            e.id = c.empresa_id
            WHERE
            c.id = $id_chamado
            ";
        // Executa a consulta no banco de dados
        $r_infos_chamado = $pdo->query($infos_chamado);
        $c_infos_chamado = $r_infos_chamado->fetch(PDO::FETCH_ASSOC);
        $titulo = $c_infos_chamado['assunto'];
        $relato = $c_infos_chamado['relato'];
        $data_abertura = $c_infos_chamado['data_abertura'];
        $tipo_chamado = $c_infos_chamado['tipo_chamado'];
        $empresa = $c_infos_chamado['empresa'];


        $atendentes_capacitados = "SELECT 
            u.id as idUsuario,
            p.nome as atendente,
            p.email as email
        FROM
            usuarios AS u
        LEFT JOIN 
            pessoas AS p 
        ON 
            p.id = u.pessoa_id
        LEFT JOIN 
            (SELECT 
                cc.chamado_id, COUNT(cc.competencia_id) AS total_competencias
            FROM 
                chamados_competencias AS cc
            GROUP BY 
                cc.chamado_id) AS comp_total 
        ON 
            comp_total.chamado_id = $id_chamado
        LEFT JOIN 
            (SELECT 
                cc.chamado_id, uc.id_usuario,
                COUNT(uc.id_competencia) AS total_competencias_usuario
            FROM 
                chamados_competencias AS cc
           LEFT JOIN
                usuario_competencia AS uc 
            ON 
                cc.competencia_id = uc.id_competencia
            WHERE 
                cc.chamado_id = $id_chamado
            GROUP BY 
                cc.chamado_id, uc.id_usuario) AS comp_usuario 
        ON 
            comp_usuario.chamado_id = $id_chamado 
        AND 
            comp_usuario.id_usuario = u.id
        WHERE (comp_total.chamado_id IS NULL
        OR 
            comp_total.total_competencias = comp_usuario.total_competencias_usuario)
        AND
        u.tipo_usuario = 1
        AND
        u.notify_email = 1
        ORDER BY 
        p.nome ASC;";

        // Executa a consulta no banco de dados
        $result = $pdo->query($atendentes_capacitados);

        // Verifica se a consulta retornou algum resultado
        if ($result->rowCount() > 0) {

            // Array para armazenar os destinatários de e-mail
            $destinatarios = array();

            // Loop através dos resultados e exiba as informações
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $email = $row['email'];
                $destinatarios[] = $email;
            }

            //Assunto do email
            $assunto = "SmartControl - Chamado $id_chamado aberto";

            // Mensagem do email
            $mensagem = "<b>Um novo chamado foi aberto com as suas competências para execução.</b><br><br>";
            $mensagem .= "Chamado ID: $id_chamado<br>
                        Empresa: $empresa<br>
                        Tipo Chamdo: $tipo_chamado<br>
                        Assunto: $titulo<br>
                        Relato: $relato<br>
                        Data Abertura: $data_abertura<br><br>

            <b>Lista de destinatários que foi enviado notificação:</b><br>";

            // Adicionar a lista de destinatários à mensagem
            foreach ($destinatarios as $destinatario) {
                $mensagem .= $destinatario . "<br>";
            }


            // Formar a URL completa com base no Document Root
            $documentRoot = $_SERVER['DOCUMENT_ROOT'];
            $relativePath = '/mail/sendmail.php';
            $url = 'http://' . $_SERVER['HTTP_HOST'] . $relativePath . '?destinatario=' . urlencode(implode(',', $destinatarios)) . '&servidorID=' . urlencode($server_id) . '&assunto=' . urlencode($assunto) . '&mensagem=' . urlencode($mensagem);

            $response = file_get_contents($url);

            // Verificar a resposta
            if ($response === false) {
                echo "Erro ao enviar o e-mail.";
            } else {
                echo $url;
                echo "E-mail enviado com sucesso.";
            }
        } else {
            echo "Nenhum resultado encontrado.";
        }
    } else {
        echo "O envio de e-mail não está habilitado.";
    }
}
