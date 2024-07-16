<?php
session_start();
if (isset($_SESSION['id'])) {
    require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

    $idCadastroCredencialUsuario = $_POST["idPermissaoUsuario"];

    $dados = [
        'idCadastroCredencialUsuario' => $idCadastroCredencialUsuario
    ];

    $sql = "DELETE FROM credenciais_portal_privacidade_usuario WHERE id = :idCadastroCredencialUsuario";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($dados);
}
