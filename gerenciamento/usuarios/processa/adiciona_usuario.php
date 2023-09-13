<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require "../../../conexoes/conexao_pdo.php";

    $pessoaID = $_POST['nomeUsuario'];
    $empresaID = $_POST["empresaSelect"];
    $perfil = $_POST["perfil"];
    $dashboard = $_POST["dashboard"];


    // Gerar uma senha segura aleatória
    $password = bin2hex(random_bytes(8));

    // Criptografar a senha em MD5
    $passwordMD5 = md5($password);

    $insert_usuario =
        "INSERT INTO usuarios (pessoa_id, senha, criado, empresa_id, perfil_id, dashboard, reset_password, active)
VALUES (:pessoa_id, :senha, NOW(), :empresa_id, :perfil_id, :dashboard, '1', '1')";

    $stmt1 = $pdo->prepare($insert_usuario);

    $stmt1->bindParam(':pessoa_id', $pessoaID);
    $stmt1->bindParam(':senha', $password);
    $stmt1->bindParam(':empresa_id', $empresaID);
    $stmt1->bindParam(':dashboard', $dashboard);
    $stmt1->bindParam(':perfil_id', $perfil);
    $stmt1->bindParam(':senha', $passwordMD5);

    // Executa a consulta
    if ($stmt1->execute()) {
        $idUsuario = $pdo->lastInsertId();
        session_start();
        $_SESSION['temp_password'] = $password;

        header("Location: /gerenciamento/usuarios/view.php?id=$idUsuario");
        exit();
    } else {
        header("Location: /gerenciamento/usuarios/usuarios.php");
        exit();
    }
}
