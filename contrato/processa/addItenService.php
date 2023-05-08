<?php

require "../../conexoes/conexao_pdo.php";

if (empty($_POST['selectService']) || empty($_POST['itemService'])) {
    echo "<p style='color:red;'>Preencha todos os campos.</p>";
} else {

    $contract_service_id = $_POST['selectService'];
    $iten_service = $_POST['itemService'];
    $active = "1";

    $cont_insert = false;

    $sql = "INSERT INTO contract_iten_service (contract_service_id, iten_service, active) VALUES (:contract_service_id, :iten_service, :active)";
    $stmt1 = $pdo->prepare($sql);
    $stmt1->bindParam(':contract_service_id', $contract_service_id);
    $stmt1->bindParam(':iten_service', $iten_service);
    $stmt1->bindParam(':active', $active);

    if ($stmt1->execute()) {
        $cont_insert = true;
    } else {
        $cont_insert = false;
    }

    if ($cont_insert) {
        echo "<p style='color:green;'>Item de serviço adicionado ao contrato com sucesso!</p>";
    } else {
        echo "<p style='color:red;'>Erro ao adicionar  item de serviço serviço ao contrato.</p>";
    }
}
