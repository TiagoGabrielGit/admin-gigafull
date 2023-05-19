<?php
require "../../../../conexoes/conexao_pdo.php";



if (empty($_POST['cadItem']) || empty($_POST['descricaoItem'])) {
    $item = $_POST['descricaoItem'];
    echo "<p style='color:red;'>Dados obrigatórios não preenchidos.</p>";
} else {

    $cadItem = $_POST['cadItem'];
    $cadItemCodInt = isset($_POST["cadItemCodInt"]) ? $_POST["cadItemCodInt"] : null;
    $descricaoItem = $_POST['descricaoItem'];
    $active = "1";
    $cont_insert = false;

    $sql_insert_servico = "INSERT INTO iten_service (item, integration_code, description, active) VALUES (:item, :integration_code, :description, :active)";
    $stmt1 = $pdo->prepare($sql_insert_servico);
    $stmt1->bindParam(':item', $cadItem);
    $stmt1->bindParam(':integration_code', $cadItemCodInt, PDO::PARAM_NULL);
    $stmt1->bindParam(':description', $descricaoItem);
    $stmt1->bindParam(':active', $active);

    if ($stmt1->execute()) {
        $cont_insert = true;
    } else {
        $cont_insert = false;
    }

    if ($cont_insert) {
        echo "<p style='color:green;'>Item cadastrado com Sucesso</p>";
    } else {
        echo "<p style='color:red;'>Erro ao cadastrar item.</p>";
    }
}
