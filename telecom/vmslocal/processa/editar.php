<?php
session_start();

if (isset($_SESSION['id'])) {
    if (isset($_POST['id'], $_POST['editEmpresa'], $_POST['editPOP'], $_POST['editServidor'], $_POST['privacidadeVM'], $_POST['editHostname'], $_POST['editSO'], $_POST['editIPAddress'], $_POST['editStatusVM'], $_POST['editMemoria'], $_POST['editVCPU'], $_POST['editDisco1'])) {

        require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

        // Obter dados do formulário
        $id = $_POST['id'];
        $editEmpresa = $_POST['editEmpresa'];
        $editPOP = $_POST['editPOP'];
        $editServidor = $_POST['editServidor'];
        $privacidadeVM = $_POST['privacidadeVM'];
        $editHostname = $_POST['editHostname'];
        $editSO = $_POST['editSO'];
        $editIPAddress = $_POST['editIPAddress'];
        $editDominio = $_POST['editDominio'] ?? null;
        $editVLAN = $_POST['editVLAN'] ?? null;
        $editStatusVM = $_POST['editStatusVM'];
        $editMemoria = $_POST['editMemoria'];
        $editVCPU = $_POST['editVCPU'];
        $editDisco1 = $_POST['editDisco1'];
        $editDisco2 = $_POST['editDisco2'] ?? null;
        $anotacaoVM = $_POST['anotacaoVM'] ?? null;

        // Consulta para atualizar os dados da VM
        $sql = "
            UPDATE vms
            SET 
                empresa_id = :editEmpresa,
                pop_id = :editPOP,
                servidor_id = :editServidor,
                privacidade = :privacidadeVM,
                hostname = :editHostname,
                sistemaOperacional = :editSO,
                ipaddress = :editIPAddress,
                dominio = :editDominio,
                vlan = :editVLAN,
                statusVM = :editStatusVM,
                recursoMemoria = :editMemoria,
                recursoCPU = :editVCPU,
                recursoDisco1 = :editDisco1,
                recursoDisco2 = :editDisco2,
                anotacaoVM = :anotacaoVM
            WHERE id = :id
        ";

        $stmt = $pdo->prepare($sql);

        // Vincular parâmetros
        $stmt->bindParam(':editEmpresa', $editEmpresa, PDO::PARAM_INT);
        $stmt->bindParam(':editPOP', $editPOP, PDO::PARAM_INT);
        $stmt->bindParam(':editServidor', $editServidor, PDO::PARAM_INT);
        $stmt->bindParam(':privacidadeVM', $privacidadeVM, PDO::PARAM_INT);
        $stmt->bindParam(':editHostname', $editHostname, PDO::PARAM_STR);
        $stmt->bindParam(':editSO', $editSO, PDO::PARAM_INT);
        $stmt->bindParam(':editIPAddress', $editIPAddress, PDO::PARAM_STR);
        $stmt->bindParam(':editDominio', $editDominio, PDO::PARAM_STR);
        $stmt->bindParam(':editVLAN', $editVLAN, PDO::PARAM_INT);
        $stmt->bindParam(':editStatusVM', $editStatusVM, PDO::PARAM_STR);
        $stmt->bindParam(':editMemoria', $editMemoria, PDO::PARAM_INT);
        $stmt->bindParam(':editVCPU', $editVCPU, PDO::PARAM_INT);
        $stmt->bindParam(':editDisco1', $editDisco1, PDO::PARAM_INT);
        $stmt->bindParam(':editDisco2', $editDisco2, PDO::PARAM_INT);
        $stmt->bindParam(':anotacaoVM', $anotacaoVM, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: /telecom/vmslocal/view.php?id=$id");
            exit();
        } else {
            echo "Erro ao atualizar VM.";
        }
    } else {
        echo "Dados incompletos.";
    }
} else {
    echo "Acesso negado.";
}
