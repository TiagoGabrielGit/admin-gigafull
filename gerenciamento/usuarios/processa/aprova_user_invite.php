<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require "../../../conexoes/conexao_pdo.php";

    // Validação do parâmetro 'id'
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        // ID inválido, faça o tratamento apropriado
        echo "ID inválido.";
        exit;
    }

    // Prepare a query SQL
    $query = "SELECT
        uia.nomePessoa as 'nome',
        uia.cpf as 'cpf',
        uia.email as 'email',
        uia.telefone as 'telefone',
        uia.celular as 'celular',
        uia.cep as 'cep',
        uia.ibgecode as 'ibgecode',
        uia.logradouro as 'logradouro',
        uia.bairro as 'bairro',
        uia.cidade as 'cidade',
        uia.estado as 'estado',
        uia.numero as 'numero',
        uia.complemento as 'complemento',
        uia.status as 'status',
        uia.token as 'token'
        FROM
        usuario_invite_accept as uia
        WHERE
        uia.id = :id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $token = $result['token'];
    if ($result) {
        // Faça o que for necessário com os dados obtidos
        $nome = $result['nome'];
        $cpf = $result['cpf'];
        $email = $result['email'];
        $telefone = $result['telefone'];
        $celular = $result['celular'];
        $cep = $result['cep'];
        $ibgecode = $result['ibgecode'];
        $logradouro = $result['logradouro'];
        $bairro = $result['bairro'];
        $cidade = $result['cidade'];
        $estado = $result['estado'];
        $numero = $result['numero'];
        $complemento = $result['complemento'];
        $status = $result['status'];

        // Insere os dados na tabela "pessoas"
        $insert_pessoa =
            "INSERT INTO pessoas (nome, email, telefone, celular, cpf, atributoCliente, atributoPrestadorServico, permiteUsuario, deleted, criado)
            VALUES (:nome, :email, :telefone, :celular, :cpf, '0', '0', '1', '1', NOW())";

        // Prepara a declaração de inserção
        $stmt_insert = $pdo->prepare($insert_pessoa);

        // Vincula os valores dos parâmetros
        $stmt_insert->bindParam(':nome', $nome);
        $stmt_insert->bindParam(':email', $email);
        $stmt_insert->bindParam(':telefone', $telefone);
        $stmt_insert->bindParam(':celular', $celular);
        $stmt_insert->bindParam(':cpf', $cpf);

        // Executa a inserção
        if ($stmt_insert->execute()) {
            $id_pessoa = $pdo->lastInsertId();

            $insert_endereco =
                "INSERT INTO people_address (people_id, ibge_code, cep, street, neighborhood, city, state, number, complement) 
            VALUES (:people_id, :ibge_code, :cep, :street, :neighborhood, :city, :state, :number, :complement)";

            $stmt_endereco = $pdo->prepare($insert_endereco);

            // Vincula os valores dos parâmetros
            $stmt_endereco->bindParam(':people_id', $id_pessoa);
            $stmt_endereco->bindParam(':ibge_code', $ibgecode);
            $stmt_endereco->bindParam(':cep', $cep);
            $stmt_endereco->bindParam(':street', $logradouro);
            $stmt_endereco->bindParam(':neighborhood', $bairro);
            $stmt_endereco->bindParam(':city', $cidade);
            $stmt_endereco->bindParam(':state', $estado);
            $stmt_endereco->bindParam(':number', $numero);
            $stmt_endereco->bindParam(':complement', $complemento);

            // Executa a inserção
            if ($stmt_endereco->execute()) {

                $dados_invite =
                    "SELECT
                    ui.tipo_acesso as 'tipo_acesso',
                    ui.empresa_id as 'empresa_id',
                    ui.perfil_id as 'perfil_id',
                    ui.permissao_chamado as 'permissao_chamado'
                    FROM
                    usuario_invite as ui
                    WHERE
                    ui.token = :token";

                $stmt_dados_invite = $pdo->prepare($dados_invite);
                $stmt_dados_invite->bindParam(':token', $token, PDO::PARAM_INT);

                if ($stmt_dados_invite->execute()) {
                    $result_dados_invite = $stmt_dados_invite->fetch(PDO::FETCH_ASSOC);


                    // Função para gerar uma senha aleatória
                    function gerarSenhaAleatoria($tamanho = 10)
                    {
                        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                        $senha = '';
                        $caracteresTamanho = strlen($caracteres) - 1;

                        // Gera um caractere aleatório até atingir o tamanho desejado
                        for ($i = 0; $i < $tamanho; $i++) {
                            $senha .= $caracteres[mt_rand(0, $caracteresTamanho)];
                        }

                        return $senha;
                    }

                    // Uso da função para gerar a senha
                    $senha = gerarSenhaAleatoria(10);
                    $senhaCriptografada = md5($senha);
                    $tipo_usuario = $result_dados_invite['tipo_acesso'];
                    $empresa_id = $result_dados_invite['empresa_id'];
                    $perfil_id = $result_dados_invite['perfil_id'];
                    $permissao_chamado = $result_dados_invite['permissao_chamado'];

                    $insert_usuario =
                        "INSERT INTO usuarios (pessoa_id, senha, criado, tipo_usuario, empresa_id, perfil_id, reset_password, notify_email, permissao_chamado, active)
                    VALUES (:pessoa_id, :senha, NOW(), :tipo_usuario, :empresa_id, :perfil_id, '1', '0', :permissao_chamado, '1')";
                    $stmt_usuario = $pdo->prepare($insert_usuario);

                    // Vincula os valores dos parâmetros
                    $stmt_usuario->bindParam(':pessoa_id', $id_pessoa);
                    $stmt_usuario->bindParam(':tipo_usuario', $tipo_usuario);
                    $stmt_usuario->bindParam(':senha', $senhaCriptografada);
                    $stmt_usuario->bindParam(':empresa_id', $empresa_id);
                    $stmt_usuario->bindParam(':perfil_id', $perfil_id);
                    $stmt_usuario->bindParam(':permissao_chamado', $permissao_chamado);

                    // Executa a inserção
                    if ($stmt_usuario->execute()) {
                        $id_usuario = $pdo->lastInsertId();

                        $update_status = "UPDATE usuario_invite_accept SET senha_default = :senha_default, status = '2' WHERE id = :id";
                        $stmt_update_status = $pdo->prepare($update_status);
                        $stmt_update_status->bindParam(':id', $id);
                        $stmt_update_status->bindParam(':senha_default', $senha);
                        if ($stmt_update_status->execute()) {

                            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                                $protocol = 'https';
                            } else {
                                $protocol = 'http';
                            }
                            $documentRoot = $_SERVER['DOCUMENT_ROOT'];
                            $url = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/notificacao/mail/accept_invite.php';

                            $data = array(
                                'id' => $id_usuario,
                                'senha' => $senha
                            );

                            // Inicializa o cURL
                            $curl = curl_init($url);

                            // Configura as opções do cURL
                            curl_setopt($curl, CURLOPT_POST, true);
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                            // Executa a requisição cURL
                            $response = curl_exec($curl);

                            // Verifica se ocorreu algum erro durante a requisição
                            if ($response === false) {
                                header('Location: ' . $_SERVER['HTTP_REFERER']);
                                exit; // Encerra a execução do script após o redirecionamento
                            } else {
                                header('Location: ' . $_SERVER['HTTP_REFERER']);
                                exit; // Encerra a execução do script após o redirecionamento
                            }

                            // Fecha a conexão cURL
                            curl_close($curl);
                        }
                    }
                }
            }
        }
    } else {
        // Registro não encontrado
        echo "Registro não encontrado.";
    }
}
