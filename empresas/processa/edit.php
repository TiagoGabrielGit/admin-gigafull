<?php
require "../../conexoes/conexao_pdo.php";

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados enviados pelo formulário
    $companyId = $_POST["id"];
    $razaoSocial = $_POST["razaoSocial"];
    $fantasia = $_POST["fantasia"];
    $cnpj = $_POST["cnpj"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $celular = $_POST["celular"];
    $atributoCliente = isset($_POST["atributoCliente"]) ? $_POST["atributoCliente"] : 0;
    $atributoEmpresaPropria = isset($_POST["atributoEmpresaPropria"]) ? $_POST["atributoEmpresaPropria"] : 0;
    $atributoFornecedor = isset($_POST["atributoFornecedor"]) ? $_POST["atributoFornecedor"] : 0;
    $atributoPrestadorServico = isset($_POST["atributoPrestadorServico"]) ? $_POST["atributoPrestadorServico"] : 0;
    $atributoTransportadora = isset($_POST["atributoTransportadora"]) ? $_POST["atributoTransportadora"] : 0;
    $cep = $_POST["cep"];
    $ibgecode = $_POST["ibgecode"];
    $logradouro = $_POST["logradouro"];
    $bairro = $_POST["bairro"];
    $cidade = $_POST["cidade"];
    $estado = $_POST["estado"];
    $numero = $_POST["numero"];
    $complemento = $_POST["complemento"];

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (empty($razaoSocial) || empty($fantasia) || empty($cnpj) || empty($email) || empty($celular) || empty($cep) || empty($logradouro) || empty($bairro) || empty($cidade) || empty($estado) || empty($numero)) {
        // Mensagem de erro
        echo "<p style='color:red;'>Error: Por favor, preencha todos os campos obrigatórios.</p>";
    } else {
        // Todos os campos estão preenchidos, continue com a lógica de salvamento no banco de dados

        $data = [
            'razaoSocial' => $razaoSocial,
            'fantasia' => $fantasia,
            'cnpj' => $cnpj,
            'email' => $email,
            'telefone' => $telefone,
            'celular' => $celular,
            'atributoCliente' => $atributoCliente,
            'atributoEmpresaPropria' => $atributoEmpresaPropria,
            'atributoFornecedor' => $atributoFornecedor,
            'atributoPrestadorServico' => $atributoPrestadorServico,
            'atributoTransportadora' => $atributoTransportadora,
            'company_id' => $companyId,
        ];

        $sql_update_empresa = "UPDATE empresas SET razaoSocial=:razaoSocial, fantasia=:fantasia, cnpj=:cnpj, email=:email, telefone=:telefone, celular=:celular,
        atributoCliente=:atributoCliente, atributoEmpresaPropria=:atributoEmpresaPropria, atributoFornecedor=:atributoFornecedor, atributoPrestadorServico=:atributoPrestadorServico,
         atributoTransportadora=:atributoTransportadora, modificado=NOW() WHERE id=:company_id";

        $stmt1 = $pdo->prepare($sql_update_empresa);


        // Executa a consulta
        if ($stmt1->execute($data)) {
            $data2 = [
                'company_id' => $companyId,
                'ibgecode' => $ibgecode,
                'cep' => $cep,
                'logradouro' => $logradouro,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'estado' => $estado,
                'numero' => $numero,
                'complemento' => $complemento,
            ];
            $sql_update_address = "UPDATE company_address SET ibge_code=:ibgecode, cep=:cep, street=:logradouro, neighborhood=:bairro, 
            city=:cidade, state=:estado, number=:numero, complement=:complemento WHERE company_id=:company_id";
            $stmt2 = $pdo->prepare($sql_update_address);
            if ($stmt2->execute($data2)) 
            echo "<p style='color:green;'>Editado com sucesso!</p>";{
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
