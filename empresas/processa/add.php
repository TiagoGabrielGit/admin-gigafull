<?php
require "../../conexoes/conexao_pdo.php";

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados enviados pelo formulário
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
        $sql_insert_empresa =
            "INSERT INTO empresas (razaoSocial, fantasia, cnpj, email, telefone, celular, atributoCliente, atributoEmpresaPropria, atributoFornecedor, atributoPrestadorServico, atributoTransportadora, deleted, criado) 
        VALUES (:razaoSocial, :fantasia, :cnpj, :email, :telefone, :celular, :atributoCliente, :atributoEmpresaPropria, :atributoFornecedor, :atributoPrestadorServico, :atributoTransportadora, '1', NOW())";

        $stmt1 = $pdo->prepare($sql_insert_empresa);

        $stmt1->bindParam(':razaoSocial', $razaoSocial);
        $stmt1->bindParam(':fantasia', $fantasia);
        $stmt1->bindParam(':cnpj', $cnpj);
        $stmt1->bindParam(':email', $email);
        $stmt1->bindParam(':telefone', $telefone);
        $stmt1->bindParam(':celular', $celular);
        $stmt1->bindParam(':atributoCliente', $atributoCliente);
        $stmt1->bindParam(':atributoEmpresaPropria', $atributoEmpresaPropria);
        $stmt1->bindParam(':atributoFornecedor', $atributoFornecedor);
        $stmt1->bindParam(':atributoPrestadorServico', $atributoPrestadorServico);
        $stmt1->bindParam(':atributoTransportadora', $atributoTransportadora);

        // Executa a consulta
        if ($stmt1->execute()) {
            $companyId = $pdo->lastInsertId();

            $sql_insert_address =
                "INSERT INTO company_address (company_id, ibge_code, cep, street, neighborhood, city, state, number, complement)
         VALUES (:company_id, :ibge_code, :cep, :street, :neighborhood, :city, :state, :number, :complement)";

            $stmt2 = $pdo->prepare($sql_insert_address);
            $stmt2->bindParam(':company_id', $companyId);
            $stmt2->bindParam(':cep', $cep);
            $stmt2->bindParam(':ibge_code', $ibgecode);
            $stmt2->bindParam(':street', $logradouro);
            $stmt2->bindParam(':neighborhood', $bairro);
            $stmt2->bindParam(':city', $cidade);
            $stmt2->bindParam(':state', $estado);
            $stmt2->bindParam(':number', $numero);
            $stmt2->bindParam(':complement', $complemento);

            if ($stmt2->execute()) {
                echo "<p style='color:green;'>Empresa salva com sucesso.</p>";
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
