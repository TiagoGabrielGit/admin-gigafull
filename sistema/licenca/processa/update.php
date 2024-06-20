<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header('Location: /login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nova_licenca = filter_input(INPUT_POST, 'licenca', FILTER_SANITIZE_STRING);

    if ($nova_licenca) {
        $atualiza_licenca = "
            UPDATE licenca
            SET licenca = :licenca
            WHERE id = 1
        ";
        $stmt = $pdo->prepare($atualiza_licenca);
        $stmt->bindParam(':licenca', $nova_licenca, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['msg'] = "success";
            header('Location: /sistema/licenca/index.php');
        } else {
            $_SESSION['msg'] = "error";
            header('Location: /sistema/licenca/index.php');
        }
    } else {
        $_SESSION['msg'] = "error";

        header('Location: /sistema/licenca/index.php');
    }
} else {
    header('Location: /sistema/licenca/index.php');
}
exit;
