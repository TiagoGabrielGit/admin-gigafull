<?php
session_start();
if (isset($_SESSION['id'])) {
    require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

    $idUsuario = $_POST["idUsuario"];
    $idCredencial = $_POST["credencialId"];
    $tipoCredencial = "0";

    $cont_insert = false;

    $insert_permissao_usuario = "INSERT INTO credenciais_equipamentos_privacidade_usuario (tipo, credencial_id, usuario_id) 
                            VALUES (:tipo, :idCredencial, :idUsuario)";
    $stmt1 = $pdo->prepare($insert_permissao_usuario);
    $stmt1->bindParam(':idCredencial', $idCredencial);
    $stmt1->bindParam(':idUsuario', $idUsuario);
    $stmt1->bindParam(':tipo', $tipoCredencial);

    if ($stmt1->execute()) {
        $cont_insert = true;
    } else {
        $cont_insert = false;
    }
}
