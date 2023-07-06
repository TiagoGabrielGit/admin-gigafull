<?php
require "../../../conexoes/conexao_pdo.php";


// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados enviados pelo formulário
    $popId = $_POST["id"];
    $pop = $_POST["pop"];
    $description = $_POST["descricaoPOP"];
    $empresa = $_POST["empresa"];

    $cep = $_POST["cep"];
    $ibgecode = $_POST["ibgecode"];
    $logradouro = $_POST["logradouro"];
    $bairro = $_POST["bairro"];
    $cidade = $_POST["cidade"];
    $estado = $_POST["estado"];
    $numero = $_POST["numero"];
    $complemento = $_POST["complemento"];

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (empty($popId) || empty($pop) || empty($description) || empty($empresa) || empty($cep) || empty($logradouro) || empty($bairro) || empty($cidade) || empty($estado) || empty($numero)) {
        // Mensagem de erro
        echo "<p style='color:red;'>Error: Por favor, preencha todos os campos obrigatórios.</p>";
    } else {
        // Todos os campos estão preenchidos, continue com a lógica de salvamento no banco de dados

        $data = [
            'id' => $popId,
            'pop' => $pop,
            'apelidoPop' => $description,
            'empresa_id' => $empresa,
            'active' => '1',
        ];

        $sql_update_pop = "UPDATE pop SET pop=:pop, apelidoPop=:apelidoPop, empresa_id=:empresa_id, active=:active, modificado=NOW() WHERE id=:id";

        $stmt1 = $pdo->prepare($sql_update_pop);

        // Executa a consulta
        if ($stmt1->execute($data)) {
            $data2 = [
                'pop_id' => $popId,
                'ibgecode' => $ibgecode,
                'cep' => $cep,
                'logradouro' => $logradouro,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'estado' => $estado,
                'numero' => $numero,
                'complemento' => $complemento,
            ];
            $sql_update_address = "UPDATE pop_address SET ibge_code=:ibgecode, cep=:cep, street=:logradouro, neighborhood=:bairro, 
            city=:cidade, state=:estado, number=:numero, complement=:complemento WHERE pop_id=:pop_id";
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
    header("Location: /telecom/sitepop/index.php");
    exit();
}
