<?php

require "../../conexoes/conexao_pdo.php";

if (empty($_POST['serviceContract'])) {
    echo "<p style='color:red;'>Nenhum serviço selecionado.</p>";
} else {

    $serviceContract = $_POST['serviceContract'];
    $serviceContratoID = $_POST['serviceContratoID'];
    $active = "1";

    $cont_insert = false;

    $sql = "INSERT INTO contract_service (contract_id, service_id, created, active) VALUES (:contract_id, :service_id, NOW(), :active)";
    $stmt1 = $pdo->prepare($sql);
    $stmt1->bindParam(':service_id', $serviceContract);
    $stmt1->bindParam(':contract_id', $serviceContratoID);
    $stmt1->bindParam(':active', $active);

    if ($stmt1->execute()) {
        $cont_insert = true;
    } else {
        $cont_insert = false;
    }

    if ($cont_insert) {
        echo "<p style='color:green;'>Serviço adicionado ao contrato com sucesso!</p>";
    } else {
        echo "<p style='color:red;'>Erro ao adicionar serviço ao contrato.</p>";
    }
}
