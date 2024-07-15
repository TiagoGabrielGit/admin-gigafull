<?php
session_start();
if (isset($_SESSION['id'])) {

    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
    $vm_desc = $_POST['VMDescricao'];
    $vm_user = $_POST['VMUsuario'];
    $vm_pass = $_POST['VMSenha'];
    $usuario_id = $_SESSION['id'];
    $tipo = "0";
    $id_VM = $_POST['idVM'];
    $privacidade = $_POST['cadastroPrivacidade'];
    $id_empresa = "0";

    $credenciais_vms = "INSERT INTO credenciais_vms (empresa_id, tipo, usuario_id, privacidade, vm_id, vmdescricao, vmusuario, vmsenha, active)
                    VALUES (:empresa_id, :tipo, :usuario_id, :privacidade, :vm_id, :vmdescricao, :vmusuario, :vmsenha, '1')";
    $stmt1 = $pdo->prepare($credenciais_vms);
    $stmt1->bindParam(':empresa_id', $id_empresa);
    $stmt1->bindParam(':tipo', $tipo);
    $stmt1->bindParam(':usuario_id', $usuario_id);
    $stmt1->bindParam(':privacidade', $privacidade);
    $stmt1->bindParam(':vm_id', $id_VM);
    $stmt1->bindParam(':vmdescricao', $vm_desc);
    $stmt1->bindParam(':vmusuario', $vm_user);
    $stmt1->bindParam(':vmsenha', $vm_pass);

    $stmt1->execute();

    header("Location: /telecom/vault/vms/view.php?id=$id_VM");
    exit();
} else {
    header("Location: /index.php");
    exit();
}
