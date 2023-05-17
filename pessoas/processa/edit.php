<?php
require "../../conexoes/conexao_pdo.php";

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados enviados pelo formulário
    $pessoaId = $_POST["id"];
    $nomePessoa = $_POST["nomePessoa"];
    $cpf = $_POST["cpf"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $celular = $_POST["celular"];
    $atributoCliente = isset($_POST["atributoCliente"]) ? $_POST["atributoCliente"] : 0;
    $permiteUsuario = isset($_POST["permiteUsuario"]) ? $_POST["permiteUsuario"] : 0;
    $atributoPrestadorServico = isset($_POST["atributoPrestadorServico"]) ? $_POST["atributoPrestadorServico"] : 0;
    $cep = $_POST["cep"];
    $ibgecode = $_POST["ibgecode"];
    $logradouro = $_POST["logradouro"];
    $bairro = $_POST["bairro"];
    $cidade = $_POST["cidade"];
    $estado = $_POST["estado"];
    $numero = $_POST["numero"];
    $complemento = $_POST["complemento"];

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (empty($nomePessoa) || empty($cpf) || empty($email) || empty($celular) || empty($cep) || empty($logradouro) || empty($bairro) || empty($cidade) || empty($estado) || empty($numero)) {
        // Mensagem de erro
        echo "<p style='color:red;'>Error: Por favor, preencha todos os campos obrigatórios.</p>";
    } else {
        // Todos os campos estão preenchidos, continue com a lógica de salvamento no banco de dados

        $data = [
            'nome' => $nomePessoa,
            'cpf' => $cpf,
            'email' => $email,
            'telefone' => $telefone,
            'celular' => $celular,
            'atributoCliente' => $atributoCliente,
            'atributoPrestadorServico' => $atributoPrestadorServico,
            'permiteUsuario' => $permiteUsuario,
            'pessoaId' => $pessoaId,

        ];

        $sql_update_pessoa = "UPDATE pessoas SET nome=:nome, email=:email, telefone=:telefone, celular=:celular, cpf=:cpf, atributoCliente=:atributoCliente,
         atributoPrestadorServico=:atributoPrestadorServico, permiteUsuario=:permiteUsuario, modificado=NOW() WHERE id=:pessoaId";

        $stmt1 = $pdo->prepare($sql_update_pessoa);


        // Executa a consulta
        if ($stmt1->execute($data)) {
            $data2 = [
                'people_id' => $pessoaId,
                'ibgecode' => $ibgecode,
                'cep' => $cep,
                'logradouro' => $logradouro,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'estado' => $estado,
                'numero' => $numero,
                'complemento' => $complemento,
            ];
            $sql_update_address = "UPDATE people_address SET ibge_code=:ibgecode, cep=:cep, street=:logradouro, neighborhood=:bairro, 
            city=:cidade, state=:estado, number=:numero, complement=:complemento WHERE people_id=:people_id";
            $stmt2 = $pdo->prepare($sql_update_address);
            if ($stmt2->execute($data2))
                echo "<p style='color:green;'>Editado com sucesso!</p>"; {
            }
        } else {
            // Ocorreu um erro ao salvar a empresa
            echo "<p style='color:red;'>Error: . $stmt->error</p>";
        }
    }
} else {
    // A requisição não é do tipo POST, redireciona para a página do formulário
    header("Location: /empresas/empresas.php");
    exit();
}
