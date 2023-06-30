<?php

if (empty($_POST['tipoChamado'])) {
    echo "<p style='color:red;'>Error: Dados obrigatórios não preenchidos</p>";
} else {
    require "../../../conexoes/conexao_pdo.php";

    $tipo = $_POST['tipoChamado'];

    $cont_insert1 = false;

    $sql = "INSERT INTO tipos_chamados (tipo, permite_atendente_abertura, permite_data_entrega, horas_prazo_entrega, active) 
        VALUES (:tipo, '0', '0', '0', '1')";
    $stmt1 = $pdo->prepare($sql);
    $stmt1->bindParam(':tipo', $tipo);

    if ($stmt1->execute()) {
        $id_cadastrado = $pdo->lastInsertId();

        $cont_insert1 = true;
    } else {
        $cont_insert1 = false;
    }

    if ($cont_insert1) {
        echo $id_cadastrado;
    } else {
        echo "<p style='color:red;'>Error: Erro ao cadastrar</p>";
    }
}
