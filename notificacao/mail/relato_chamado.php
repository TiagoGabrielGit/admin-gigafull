<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../conexoes/conexao_pdo.php";

    // Consulta se o envio de e-mail está habilitado
    $consulta_habilitado = "
        SELECT
            ne.active as active,
            ne.server_id as server_id
        FROM
            notificacao_email as ne
        WHERE
            ne.notificacao_id = 3
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
        $relato = $relato;
        $data_abertura = $c_infos_chamado['data_abertura'];
        $tipo_chamado = $c_infos_chamado['tipo_chamado'];
        $empresa = $c_infos_chamado['empresa'];

        // Último relato
        $ultimo_relato = "SELECT
        p.nome as 'relatante',
        cr.relato as 'relato',
        cr.private as 'privacidade'
        FROM
        chamado_relato as cr
        LEFT JOIN
        usuarios as u
        ON
        u.id = cr.relator_id
        LEFT JOIN
        pessoas as p
        ON
        p.id = u.pessoa_id
        WHERE
        cr.chamado_id = $id_chamado
        ORDER BY
        cr.id DESC
        LIMIT 1 ";

        $r_ultimo_relato = $pdo->query($ultimo_relato);
        $c_ultimo_relato = $r_ultimo_relato->fetch(PDO::FETCH_ASSOC);
        $ultimo_relato = $c_ultimo_relato['relato'];
        $relatante = $c_ultimo_relato['relatante'];
        $privacidade = $c_ultimo_relato['privacidade'];

        if ($privacidade == 1) {
            // SQL para receber lista de destinatários
            $lista_destinatarios_internos =
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
        } else if ($privacidade == 2) {
            // SQL para receber lista de destinatários
            $lista_destinatarios_internos =
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
            c.id = $id_chamado
            AND
            u.tipo_usuario = 1";
        }

        // Executa a consulta no banco de dados
        $result = $pdo->query($lista_destinatarios_internos);

        // Verifica se a consulta retornou algum resultado
        if ($result->rowCount() > 0) {

            // Array para armazenar os destinatários de e-mail
            $destinatarios = array();

            // Loop através dos resultados e exiba as informações
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $email = $row['email'];
                $destinatarios[] = $email;
            }

            // Assunto do e-mail
            $assunto = "SmartControl - Novo relato no chamado $id_chamado.";

            // Mensagem do e-mail
            $mensagem = "<b>Um novo relato foi adicionado no chamado $id_chamado por $relatante.</b><br>";
            $mensagem .= "Chamado ID: $id_chamado
                        Empresa: $empresa
                        Tipo Chamdo: $tipo_chamado
                        Assunto: $titulo
                        Data Abertura: $data_abertura

                        <b>Relato da Abertura:</b>
                        $relato
                        <b>Relato Adicionado:</b>
                        $ultimo_relato

            <b>Lista de destinatários que foi enviado notificação:</b><br>";

            // Adicionar a lista de destinatários à mensagem
            $destinatarios_str = implode(', ', $destinatarios);
            foreach ($destinatarios as $destinatario) {
                $mensagem .= $destinatario . "<br>";
            }

            // Formar a URL completa com base no Document Root
            $documentRoot = $_SERVER['DOCUMENT_ROOT'];
            $relativePath = '/mail/sendmail_POST.php';

            // Verificar se a solicitação foi feita via HTTPS
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                $protocol = 'https';
            } else {
                $protocol = 'http';
            }

            $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . $relativePath;

            // Dados a serem enviados
            $data = array(
                'destinatario' => $destinatarios_str,
                'assunto' => $assunto,
                'mensagem' => $mensagem,
                'servidorID' => $server_id
            );

            // Inicializar a sessão cURL
            $curl = curl_init();

            // Configurar a requisição POST
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // Permitir redirecionamento

            // Executar a requisição e obter a resposta
            $response = curl_exec($curl);

            // Verificar a resposta
            if ($response === false) {
                echo "Error: Erro ao enviar o e-mail.";
            } else {
                echo "Response:" . $response;
            }

            // Fechar a sessão cURL
            curl_close($curl);
        } else {
            echo "Nenhum resultado encontrado.";
        }
    } else {
        echo "O envio de e-mail não está habilitado.";
    }
}