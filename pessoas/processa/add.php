<?php
require "../../conexoes/conexao_pdo.php";

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados enviados pelo formulário
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
        $sql_insert_pessoas =
            "INSERT INTO pessoas (nome, email, telefone, celular, cpf, atributoCliente, atributoPrestadorServico, permiteUsuario, deleted, criado) 
        VALUES (:nome, :email, :telefone, :celular, :cpf, :atributoCliente, :atributoPrestadorServico, :permiteUsuario, '1', NOW())";

        $stmt1 = $pdo->prepare($sql_insert_pessoas);

        $stmt1->bindParam(':nome', $nomePessoa);
        $stmt1->bindParam(':cpf', $cpf);
        $stmt1->bindParam(':email', $email);
        $stmt1->bindParam(':telefone', $telefone);
        $stmt1->bindParam(':celular', $celular);
        $stmt1->bindParam(':atributoCliente', $atributoCliente);
        $stmt1->bindParam(':atributoPrestadorServico', $atributoPrestadorServico);
        $stmt1->bindParam(':permiteUsuario', $permiteUsuario);

        // Executa a consulta
        if ($stmt1->execute()) {
            $peopleId = $pdo->lastInsertId();

            $sql_insert_address =
                "INSERT INTO people_address (people_id, ibge_code, cep, street, neighborhood, city, state, number, complement)
         VALUES (:people_id, :ibge_code, :cep, :street, :neighborhood, :city, :state, :number, :complement)";

            $stmt2 = $pdo->prepare($sql_insert_address);
            $stmt2->bindParam(':people_id', $peopleId);
            $stmt2->bindParam(':cep', $cep);
            $stmt2->bindParam(':ibge_code', $ibgecode);
            $stmt2->bindParam(':street', $logradouro);
            $stmt2->bindParam(':neighborhood', $bairro);
            $stmt2->bindParam(':city', $cidade);
            $stmt2->bindParam(':state', $estado);
            $stmt2->bindParam(':number', $numero);
            $stmt2->bindParam(':complement', $complemento);

            if ($stmt2->execute()) {
                echo "<p style='color:green;'>Pessoa salva com sucesso.</p>";
            }
        } else {
            // Ocorreu um erro ao salvar a empresa
            echo "<p style='color:red;'>Error: . $stmt->error</p>";
        }
    }
} else {
    // A requisição não é do tipo POST, redireciona para a página do formulário
    header("Location: /pessoas/pessoas.php");
    exit();
}
