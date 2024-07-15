<?php
session_start();

if (isset($_SESSION['id'])) {
    require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

    $idEquipe = $_POST["idEquipe"];
    $vm_id = $_POST["vmId"];

    $insert_permissao_equipe = "INSERT INTO vm_privacidade_equipe (vm_id, equipe_id) 
                            VALUES (:vm_id, :idEquipe)";
    $stmt1 = $pdo->prepare($insert_permissao_equipe);
    $stmt1->bindParam(':vm_id', $vm_id);
    $stmt1->bindParam(':idEquipe', $idEquipe);

    $stmt1->execute();
} else {
}
  