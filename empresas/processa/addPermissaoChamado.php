<?php
require "../../conexoes/conexao_pdo.php";

$idEmpresa = $_POST['idEmpresaFormChamado'];
$idTipoChamado = $_POST['idTipoChamadoFormChamado'];

$cont_insert = false;

$insert_integrante = "INSERT INTO chamados_autorizados_by_company (company_id, tipo_id) VALUES (:idCompany, :tipo_id)";
$stmt1 = $pdo->prepare($insert_integrante);
$stmt1->bindParam(':idCompany', $idEmpresa);
$stmt1->bindParam(':tipo_id', $idTipoChamado);

if ($stmt1->execute()) {
    $cont_insert = true;
} else {
    $cont_insert = false;
}