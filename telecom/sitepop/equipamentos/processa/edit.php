<?php
session_start();
if (isset($_SESSION['id'])) {

    require "../../../../conexoes/conexao.php";

    $id = $_POST['id'];


    if (empty($_POST['inputSerial'])) {
        $serialEquipamento = "";
    } else {
        $serialEquipamento = $_POST['inputSerial'];
    }

    if (empty($_POST['portaWeb'])) {
        $portaWeb = "";
    } else {
        $portaWeb = $_POST['portaWeb'];
    }

    if (empty($_POST['portaSSH'])) {
        $portaSSH = "";
    } else {
        $portaSSH = $_POST['portaSSH'];
    }

    if (empty($_POST['portaTelnet'])) {
        $portaTelnet = "";
    } else {
        $portaTelnet = $_POST['portaTelnet'];
    }

    if (empty($_POST['portaWinbox'])) {
        $portaWinbox = "";
    } else {
        $portaWinbox = $_POST['portaWinbox'];
    }


    //Captura todos os dados        
    $inputEmpresa = $_POST['inputEmpresa'];
    $inputPop = $_POST['editEquipamentoPop'];
    $inputHostname = $_POST['inputHostname'];
    $inputFabricante = $_POST['inputFabricante'];
    $inputEquipamento = $_POST['inputEquipamento'];
    $inputTipoEquipamento = $_POST['inputTipoEquipamento'];
    $inputIpAddress = $_POST['inputIpAddress'];
    $inputStatus = $_POST['inputStatus'];
    $privacidade = $_POST['privacidadeEquipamento'];
    $anotacaoEquipamento = $_POST['anotacaoEquipamento'];
    $usuario_id = $_SESSION['id'];


    $result_update_eqpop = "UPDATE equipamentospop SET privacidade='$privacidade', serialEquipamento='$serialEquipamento', portaTelnet='$portaTelnet', portaSSH='$portaSSH', portaWeb='$portaWeb', portaWinbox='$portaWinbox', anotacaoEquipamento='$anotacaoEquipamento', empresa_id='$inputEmpresa', pop_id='$inputPop', ipaddress='$inputIpAddress', hostname='$inputHostname', tipoEquipamento_id='$inputTipoEquipamento', equipamento_id='$inputEquipamento', statusEquipamento='$inputStatus', rack_id='$rack_id', modificado=NOW() WHERE id='$id'";
    $resultado_eqpop = mysqli_query($mysqli, $result_update_eqpop);


    if (mysqli_affected_rows($mysqli) > 0) {
        header("Location: /telecom/sitepop/equipamentos/view.php?id=$id");
        exit();
    } else {
        header("Location: /telecom/sitepop/equipamentos/view.php?id=$id");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
