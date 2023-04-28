<?php
require "../../../../conexoes/conexao_pdo.php";

$idEquipamento = $_POST['idEquipamento'];
$idTipo = $_POST['idTipo'];

$insert_atributo = "INSERT INTO equipamentos_atributos (equipamento_id, tipoequipamento_id, active) VALUES (:equipamento_id, :tipoequipamento_id, '1')";
$stmt1 = $pdo->prepare($insert_atributo);
$stmt1->bindParam(':equipamento_id', $idEquipamento);
$stmt1->bindParam(':tipoequipamento_id', $idTipo);

$stmt1->execute();
