<?php
session_start();

if (isset($_SESSION['id'])) {
    require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

    $idEquipe = $_POST["idEquipe"];
    $idCredencial = $_POST["credencialId"];

    $insert_permissao_equipe = "INSERT INTO credenciais_portal_privacidade_equipe (credencial_id, equipe_id) 
                            VALUES (:idCredencial, :idEquipe)";
    $stmt1 = $pdo->prepare($insert_permissao_equipe);
    $stmt1->bindParam(':idCredencial', $idCredencial);
    $stmt1->bindParam(':idEquipe', $idEquipe);

    $stmt1->execute();
} else {
}
