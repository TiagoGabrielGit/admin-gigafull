<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    $cadastroEmpresa = $_POST['VMcadastroEmpresa'];
    $cadastroPop = $_POST['VMcadastroPop'];
    $cadastroServidor = $_POST['VMcadastroServidor'];
    $cadastroHostname = $_POST['VMcadastroHostname'];
    $cadastroSO = $_POST['VMcadastroSO'];
    $cadastroIPAddress = $_POST['VMcadastroIPAddress'];
    $cadastroDomino = $_POST['VMcadastroDomino'];
    $cadastroVLAN = empty($_POST['VMcadastroVLAN']) ? "" : $_POST['VMcadastroVLAN'];
    $cadastroStatusVM = $_POST['VMcadastroStatus'];
    $cadastroMemoria = $_POST['VMcadastroMemoria'];
    $cadastroVCPU = $_POST['VMcadastroVCPU'];
    $cadastroDisco1 = $_POST['VMcadastroDisco1'];
    $cadastroDisco2 = $_POST['VMcadastroDisco2'];
    $privacidade = "2";
    $idUsuario = $_SESSION['id'];

    // Preparar e executar a declaração SQL usando PDO
    $sql_insert = "INSERT INTO vms (
            privacidade, usuario_criador, empresa_id, pop_id, servidor_id, hostname, ipaddress, dominio, vlan, sistemaOperacional, recursoMemoria, recursoCPU, recursoDisco1, recursoDisco2, statusvm, criado
        ) VALUES (
            :privacidade, :usuario_criador, :empresa_id, :pop_id, :servidor_id, :hostname, :ipaddress, :dominio, :vlan, :sistemaOperacional, :recursoMemoria, :recursoCPU, :recursoDisco1, :recursoDisco2, :statusvm, NOW()
        )";

    $stmt = $pdo->prepare($sql_insert);

    // Vincular parâmetros
    $stmt->bindParam(':privacidade', $privacidade);
    $stmt->bindParam(':usuario_criador', $idUsuario);
    $stmt->bindParam(':empresa_id', $cadastroEmpresa);
    $stmt->bindParam(':pop_id', $cadastroPop);
    $stmt->bindParam(':servidor_id', $cadastroServidor);
    $stmt->bindParam(':hostname', $cadastroHostname);
    $stmt->bindParam(':ipaddress', $cadastroIPAddress);
    $stmt->bindParam(':dominio', $cadastroDomino);
    $stmt->bindParam(':vlan', $cadastroVLAN);
    $stmt->bindParam(':sistemaOperacional', $cadastroSO);
    $stmt->bindParam(':recursoMemoria', $cadastroMemoria);
    $stmt->bindParam(':recursoCPU', $cadastroVCPU);
    $stmt->bindParam(':recursoDisco1', $cadastroDisco1);
    $stmt->bindParam(':recursoDisco2', $cadastroDisco2);
    $stmt->bindParam(':statusvm', $cadastroStatusVM);

    // Executar a consulta
    if ($stmt->execute()) {
        $id_vm = $pdo->lastInsertId();
        header("Location: /telecom/vmslocal/view.php?id=$id_vm");
        exit();
    } else {
        header("Location: /telecom/vmslocal/index.php");
        exit();
    }
}
