<?php
require "../../../conexoes/conexao_pdo.php";

$img_id = filter_input(INPUT_GET, 'img', FILTER_SANITIZE_NUMBER_INT);
$equi_id = filter_input(INPUT_GET, 'eqp', FILTER_SANITIZE_NUMBER_INT);
$parametro = filter_input(INPUT_GET, 'param', FILTER_SANITIZE_NUMBER_INT);
$cont_update = false;

$sql = "UPDATE upload SET active=? WHERE id=?";
$stmt= $pdo->prepare($sql);
$stmt->execute([$parametro, $img_id]);

if ($stmt->execute()) {
    $cont_update = true;
    header("Location: /telecom/equipamentos/view.php?id=$equi_id&img=$img_id&param=$parametro");
} else {
    $cont_update = false;
    header("Location: /telecom/equipamentos/view.php?id=$equi_id&img=$img_id&param=$parametro");
} 