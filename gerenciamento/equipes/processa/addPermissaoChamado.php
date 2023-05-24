<?php
require "../../../conexoes/conexao_pdo.php";

$idEquipe = $_POST['idEquipeFormChamado'];
$idTipoChamado = $_POST['idTipoChamadoFormChamado'];

$cont_insert = false;

$insert_integrante = "INSERT INTO chamados_autorizados_by_equipe (equipe_id, tipo_id) VALUES (:idEquipe, :tipo_id)";
$stmt1 = $pdo->prepare($insert_integrante);
$stmt1->bindParam(':idEquipe', $idEquipe);
$stmt1->bindParam(':tipo_id', $idTipoChamado);

if ($stmt1->execute()) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}
