<?php
session_start();
if (isset($_SESSION['id'])) {
    require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

    $idUsuario = $_POST["idUsuario"];
    $vm_id = $_POST["vmId"];

    $cont_insert = false;

    $insert_permissao_usuario = "INSERT INTO vm_privacidade_usuario (vm_id, usuario_id) 
                            VALUES (:vm_id, :idUsuario)";
    $stmt1 = $pdo->prepare($insert_permissao_usuario);
    $stmt1->bindParam(':vm_id', $vm_id);
    $stmt1->bindParam(':idUsuario', $idUsuario);

    if ($stmt1->execute()) {
        $cont_insert = true;
    } else {
        $cont_insert = false;
    }
}
 