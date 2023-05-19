<?php
require "../../../conexoes/conexao_pdo.php";

$chamadoID = $_POST['chamadoID'];

// Montar a consulta preparada
$sql_deleta_rascunho = "DELETE FROM chamados_relatos_rascunho WHERE id_chamado = :chamadoID";

// Preparar a consulta
$stmt_delete = $pdo->prepare($sql_deleta_rascunho);
$stmt_delete->bindParam(':chamadoID', $chamadoID);


$stmt_delete->execute();
