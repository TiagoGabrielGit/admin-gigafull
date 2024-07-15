<?php
session_start();

if (isset($_SESSION['id'])) {
    require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

    $idCadastroCredencialEquipe = $_POST["idPermissaoEquipe"];

    $dados = [
        'idCadastroCredencialEquipe' => $idCadastroCredencialEquipe
    ];

    $sql = "DELETE FROM credenciais_equipamentos_privacidade_equipe WHERE id = :idCadastroCredencialEquipe";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($dados);
} else {
}
