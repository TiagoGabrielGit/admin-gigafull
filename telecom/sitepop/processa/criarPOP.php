<?php
require "../../../conexoes/conexao_pdo.php";

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados enviados pelo formulário
    $pop = $_POST["pop"];
    $description = $_POST["description"];
    $empresa = isset($_POST["empresa"]);

    $cep = $_POST["cep"];
    $ibgecode = $_POST["ibgecode"];
    $logradouro = $_POST["logradouro"];
    $bairro = $_POST["bairro"];
    $cidade = $_POST["cidade"];
    $estado = $_POST["estado"];
    $numero = $_POST["numero"];
    $complemento = $_POST["complemento"];

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (empty($pop) || empty($description) || empty($empresa) || empty($cep) || empty($logradouro) || empty($bairro) || empty($cidade) || empty($estado) || empty($numero)) {
        // Mensagem de erro
        echo "<p style='color:red;'>Error: Por favor, preencha todos os campos obrigatórios.</p>";
    } else {
        // Todos os campos estão preenchidos, continue com a lógica de salvamento no banco de dados
        $sql_insert_pop =
            "INSERT INTO pop (pop, apelidoPop, empresa_id, active, criado) 
        VALUES (:pop, :apelidoPop, :empresa_id, '1', NOW())";

        $stmt1 = $pdo->prepare($sql_insert_pop);

        $stmt1->bindParam(':pop', $pop);
        $stmt1->bindParam(':apelidoPop', $description);
        $stmt1->bindParam(':empresa_id', $empresa);

        // Executa a consulta
        if ($stmt1->execute()) {
            $popId = $pdo->lastInsertId();

            $sql_insert_address =
                "INSERT INTO pop_address (pop_id, ibge_code, cep, street, neighborhood, city, state, number, complement)
         VALUES (:pop_id, :ibge_code, :cep, :street, :neighborhood, :city, :state, :number, :complement)";

            $stmt2 = $pdo->prepare($sql_insert_address);
            $stmt2->bindParam(':pop_id', $popId);
            $stmt2->bindParam(':cep', $cep);
            $stmt2->bindParam(':ibge_code', $ibgecode);
            $stmt2->bindParam(':street', $logradouro);
            $stmt2->bindParam(':neighborhood', $bairro);
            $stmt2->bindParam(':city', $cidade);
            $stmt2->bindParam(':state', $estado);
            $stmt2->bindParam(':number', $numero);
            $stmt2->bindParam(':complement', $complemento);

            if ($stmt2->execute()) {
                echo "<p style='color:green;'>POP salvo com sucesso.</p>";
            }
        } else {
            // Ocorreu um erro ao salvar a empresa
            echo "<p style='color:red;'>Error: . $stmt->error</p>";
        }
    }
} else {
    // A requisição não é do tipo POST, redireciona para a página do formulário
    header("Location: /telecom/sitepop/index.php");
    exit();
}?>