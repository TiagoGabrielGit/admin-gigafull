<?php
session_start();
if (isset($_SESSION['id'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        require "../../../conexoes/conexao_pdo.php";
        $senha_atual = $_POST["senha_atual"];
        $nova_senha = $_POST["nova_senha"];
        $confirmar_senha = $_POST["confirmar_senha"];
        $uid = $_SESSION['id'];

        $stmt = $pdo->prepare("SELECT senha FROM usuarios WHERE id = :uid");
        $stmt->bindParam(':uid', $uid);
        $stmt->execute();
        $resultado = $stmt->fetch();
        $senha_atual_db = $resultado['senha'];

        if (md5($senha_atual) == $senha_atual_db) {
            if ($nova_senha == $confirmar_senha) {
                $nova_senha_md5 = md5($nova_senha);

                $stmt = $pdo->prepare("UPDATE usuarios SET senha = :nova_senha WHERE id = :uid");
                $stmt->bindParam(':nova_senha', $nova_senha_md5);
                $stmt->bindParam(':uid', $uid);
                $stmt->execute();

                header("Location: /gerenciamento/usuarios/profile.php?id=$uid&msgChangeUser=700&tab=altPass");
                exit();
            } else {
                header("Location: /gerenciamento/usuarios/profile.php?id=$uid&msgChangeUser=900&tab=altPass");
                exit();
            }
        } else {
            header("Location: /gerenciamento/usuarios/profile.php?id=$uid&msgChangeUser=800&tab=altPass");
            exit();
        }
    }
}
