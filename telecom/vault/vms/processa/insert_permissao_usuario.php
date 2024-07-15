<?php
session_start();
if (isset($_SESSION['id'])) {
    require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

    $idUsuario = $_POST["idUsuario"];
    $idCredencial = $_POST["credencialId"];

    $cont_insert = false;

    $insert_permissao_usuario = "INSERT INTO credenciais_vms_privacidade_usuario (credencial_id, usuario_id) 
                            VALUES (:idCredencial, :idUsuario)";
    $stmt1 = $pdo->prepare($insert_permissao_usuario);
    $stmt1->bindParam(':idCredencial', $idCredencial);
    $stmt1->bindParam(':idUsuario', $idUsuario);

    if ($stmt1->execute()) {
        $cont_insert = true;
    } else {
        $cont_insert = false;
    }
}
