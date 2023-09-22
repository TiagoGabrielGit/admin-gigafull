<?php
require "../../../conexoes/conexao_pdo.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //NOTIFICACAO 1
    if ($_POST['notificacao1_ativo'] == "true") {
        $active1 = "1";
    } else if ($_POST['notificacao1_ativo'] == "false") {
        $active1 = "0";
    }

    $notificacao1_servidor = isset($_POST['notificacao1_servidor']) ? $_POST['notificacao1_servidor'] : null;
    $sql_update1 = "UPDATE notificacao_email SET active = :active, server_id = :server_id WHERE notificacao_id = '1'";
    $stmt_update1 = $pdo->prepare($sql_update1);
    $stmt_update1->bindParam(':active', $active1, PDO::PARAM_INT);
    $stmt_update1->bindParam(':server_id', $notificacao1_servidor, PDO::PARAM_INT);

    //NOTIFICACAO 2
    if ($_POST['notificacao2_ativo'] == "true") {
        $active2 = "1";
    } else if ($_POST['notificacao2_ativo'] == "false") {
        $active2 = "0";
    }

    $notificacao2_servidor = isset($_POST['notificacao2_servidor']) ? $_POST['notificacao2_servidor'] : null;
    $sql_update2 = "UPDATE notificacao_email SET active = :active, server_id = :server_id WHERE notificacao_id = '2'";
    $stmt_update2 = $pdo->prepare($sql_update2);
    $stmt_update2->bindParam(':active', $active2, PDO::PARAM_INT);
    $stmt_update2->bindParam(':server_id', $notificacao2_servidor, PDO::PARAM_INT);

    //NOTIFICACAO 3
    if ($_POST['notificacao3_ativo'] == "true") {
        $active3 = "1";
    } else if ($_POST['notificacao3_ativo'] == "false") {
        $active3 = "0";
    }

    $notificacao3_servidor = isset($_POST['notificacao3_servidor']) ? $_POST['notificacao3_servidor'] : null;
    $sql_update3 = "UPDATE notificacao_email SET active = :active, server_id = :server_id WHERE notificacao_id = '3'";
    $stmt_update3 = $pdo->prepare($sql_update3);
    $stmt_update3->bindParam(':active', $active3, PDO::PARAM_INT);
    $stmt_update3->bindParam(':server_id', $notificacao3_servidor, PDO::PARAM_INT);


    //NOTIFICACAO 4
    if ($_POST['notificacao4_ativo'] == "true") {
        $active4 = "1";
    } else if ($_POST['notificacao4_ativo'] == "false") {
        $active4 = "0";
    }

    $notificacao4_servidor = isset($_POST['notificacao4_servidor']) ? $_POST['notificacao4_servidor'] : null;
    $sql_update4 = "UPDATE notificacao_email SET active = :active, server_id = :server_id WHERE notificacao_id = '4'";
    $stmt_update4 = $pdo->prepare($sql_update4);
    $stmt_update4->bindParam(':active', $active4, PDO::PARAM_INT);
    $stmt_update4->bindParam(':server_id', $notificacao4_servidor, PDO::PARAM_INT);


    //NOTIFICACAO 5
    if ($_POST['notificacao5_ativo'] == "true") {
        $active5 = "1";
    } else if ($_POST['notificacao5_ativo'] == "false") {
        $active5 = "0";
    }

    $notificacao5_servidor = isset($_POST['notificacao5_servidor']) ? $_POST['notificacao5_servidor'] : null;
    $sql_update5 = "UPDATE notificacao_email SET active = :active, server_id = :server_id WHERE notificacao_id = '5'";
    $stmt_update5 = $pdo->prepare($sql_update5);
    $stmt_update5->bindParam(':active', $active5, PDO::PARAM_INT);
    $stmt_update5->bindParam(':server_id', $notificacao5_servidor, PDO::PARAM_INT);

    //NOTIFICACAO 6
    if ($_POST['notificacao6_ativo'] == "true") {
        $active6 = "1";
    } else if ($_POST['notificacao6_ativo'] == "false") {
        $active6 = "0";
    }

    $notificacao6_servidor = isset($_POST['notificacao6_servidor']) ? $_POST['notificacao6_servidor'] : null;
    $sql_update6 = "UPDATE notificacao_email SET active = :active, server_id = :server_id WHERE notificacao_id = '6'";
    $stmt_update6 = $pdo->prepare($sql_update6);
    $stmt_update6->bindParam(':active', $active6, PDO::PARAM_INT);
    $stmt_update6->bindParam(':server_id', $notificacao6_servidor, PDO::PARAM_INT);

    if ($stmt_update1->execute() && $stmt_update2->execute() && $stmt_update3->execute() && $stmt_update4->execute() && $stmt_update5->execute() && $stmt_update6->execute()) {
        echo "<p style='color:green;'>Salvo com sucesso</p>";
    } else {
        echo "<p style='color:red;'>Erro ao salvar</p>";
    }
} else {
}
