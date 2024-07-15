<?php
session_start();

if (isset($_SESSION['id'])) {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
        $usuarioCriador = $_POST['usuarioCriador'];

        $cadastroEmpresa = $_POST['cadastroEmpresa'];
        $cadastroTipo = "portal";
        $cadastroPrivacidade = $_POST['cadastroPrivacidade'];

        $portalPaginaAcesso = $_POST['portalPaginaAcesso'];
        $portalDescricao = $_POST['portalDescricao'];
        $portalUsuario = $_POST['portalUsuario'];
        $portalSenha = $_POST['portalSenha'];
        $portalAnotacao = $_POST['portalAnotacao'];

        $cont_insert = false;

        $sql = "INSERT INTO credenciais_portal (empresa_id, tipo, usuario_id, privacidade, paginaacesso, portaldescricao, portalusuario, portalsenha, anotacao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$cadastroEmpresa, $cadastroTipo, $usuarioCriador, $cadastroPrivacidade, $portalPaginaAcesso, $portalDescricao, $portalUsuario, $portalSenha, $portalAnotacao])) {
            $cont_insert = true;
        } else {
            $cont_insert = false;
        }

        if ($cont_insert) {
            $lastInsertedId = $pdo->lastInsertId();
            header("Location: /telecom/vault/portal/view.php?id=$lastInsertedId");
            exit();
        } else {
            $referer = $_SERVER['HTTP_REFERER'];
            header("Location: $referer");
            exit();
        }
    }
}
