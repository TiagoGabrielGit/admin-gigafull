<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id_equipamento = $_POST["id_equipamento"];
$id_tipoequipamento = $_POST["id_tipoequipamento"];
$active = $_POST["active"];

if ($active == '1' || $active == '0') {
    if ($id_equipamento != '' && $id_tipoequipamento != '' && $active != '') {
        $update = "UPDATE `equipamentos_atributos` SET `active`= '$active' WHERE equipamento_id = '$id_equipamento' and tipoequipamento_id = '$id_tipoequipamento' ";
        $update_banco = mysqli_query($mysqli, $update);
    }
}
