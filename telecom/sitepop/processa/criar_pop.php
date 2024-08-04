<?php
session_start();
if (isset($_SESSION['id'])) {

    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
                header("Location: /telecom/sitepop/view_informacoes.php?id=$popId");
                exit();
            }
        } else {
            header("Location: /telecom/sitepop/index.php");
            exit();
        }
    } else {
        header("Location: /telecom/sitepop/index.php");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
