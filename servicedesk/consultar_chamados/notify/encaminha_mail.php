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
            ne.notificacao_id = 2
    ";

    // Executa a consulta no banco de dados
    $result_habilitado = $pdo->query($consulta_habilitado);
    $c_habilitado = $result_habilitado->fetch(PDO::FETCH_ASSOC);
    $active = $c_habilitado['active'];
    $server_id = $c_habilitado['server_id'];


    // Se habilitado, coleta informações do chamado.
    if ($active == 1) {
        $id_chamado = $_POST['id_chamado'];

        $infos_chamado =
            "SELECT
            c.assuntoChamado as assunto,
            c.relato_inicial as relato,
            c.data_abertura as data_abertura,
            tc.tipo as tipo_chamado,
            e.fantasia as empresa,
            p.nome as atendente
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
            LEFT JOIN
            usuarios as u
            ON
            u.id = c.atendente_id
            LEFT JOIN
            pessoas as p
            ON
            p.id = u.pessoa_id
            WHERE
            c.id = $id_chamado";

        // Executa a consulta no banco de dados
        $r_infos_chamado = $pdo->query($infos_chamado);
        $c_infos_chamado = $r_infos_chamado->fetch(PDO::FETCH_ASSOC);
        $titulo = $c_infos_chamado['assunto'];
        $relato = $c_infos_chamado['relato'];
        $data_abertura = $c_infos_chamado['data_abertura'];
        $tipo_chamado = $c_infos_chamado['tipo_chamado'];
        $empresa = $c_infos_chamado['empresa'];
        $atendente = $c_infos_chamado['atendente'];

        //SQL para receber lista de destinatários
        $lista_destinatarios =
            "SELECT
            p.email as 'email'
            FROM
            usuarios as u
            LEFT JOIN
            pessoas as p
            ON
            p.id = u.pessoa_id
            WHERE
            u.perfil_id = 1

            UNION

            SELECT
            p.email as 'email'
            FROM
            chamados as c
            LEFT JOIN
            usuarios as u
            ON
            u.id = c.atendente_id
            LEFT JOIN
            pessoas as p
            ON
            p.id = u.pessoa_id
            WHERE
            c.id = $id_chamado
           
            UNION
           
            SELECT
            p.email as 'email'
            FROM
            chamados as c
            LEFT JOIN
            usuarios as u
            ON
            u.id = c.solicitante_id
            LEFT JOIN
            pessoas as p
            ON
            p.id = u.pessoa_id
            WHERE
            c.id = $id_chamado";

        // Executa a consulta no banco de dados
        $result = $pdo->query($lista_destinatarios);

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
            $assunto = "SmartControl - Chamado $id_chamado encaminhado para $atendente.";

            // Mensagem do email
            $mensagem = "<b>O chamado $id_chamado foi encaminhado para o atendente $atendente.</b><br><br>";
            $mensagem .= "Chamado ID: $id_chamado<br>
                        Empresa: $empresa<br>
                        Tipo Chamdo: $tipo_chamado<br>
                        Assunto: $titulo<br>
                        Data Abertura: $data_abertura<br><br>

                        <b>Relato da Abertura:</b><br>
                        $relato<br><br>

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