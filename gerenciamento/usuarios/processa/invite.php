<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['inviteTipoAcesso']) || empty($_POST['validadeInvite']) || empty($_POST['inviteEmpresa']) || empty($_POST['permissaoChamados'])) {
        echo "Error: Dados obrigatórios não preenchidos";
    } else if ($_POST['inviteTipoAcesso'] == 1 && empty($_POST['invitePerfil'])) {
        echo "Error: Dados obrigatórios não preenchidos";
    } else {
        require "../../../conexoes/conexao_pdo.php";

        // Obtenha os valores dos campos do formulário
        $inviteTipoAcesso = $_POST['inviteTipoAcesso'];
        $validadeInvite = $_POST['validadeInvite'];
        $inviteEmpresa = $_POST['inviteEmpresa'];
        $permissaoChamados = $_POST['permissaoChamados'];
        $invitePerfil = isset($_POST['invitePerfil']) ? $_POST['invitePerfil'] : '';

        // Gere um token único e aleatório
        $token = uniqid() . mt_rand(1000, 9999); // Adapte os valores mínimos e máximos conforme necessário

        // Obtenha a data e hora atual
        $dataAtual = new DateTime();

        // Adicione o tempo de validade em minutos à hora atual
        $validade = $dataAtual->modify("+" . $validadeInvite . " minutes");

        // Prepare a declaração SQL
        $stmt = $pdo->prepare("INSERT INTO usuario_invite (tipo_acesso, empresa_id, permissao_chamado, perfil_id, token, validade_invite, active) VALUES (?, ?, ?, ?, ?, ?, '1')");

        // Execute a declaração SQL com os valores fornecidos
        $stmt->execute([$inviteTipoAcesso, $inviteEmpresa, $permissaoChamados, $invitePerfil, $token, $validade->format("Y-m-d H:i:s")]);

        $host = $_SERVER['HTTP_HOST'];
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $url = $protocol . "://" . $host;

        echo "URL de invite: <br> <a href=\"$url/invite.php?token=$token\">$url/invite.php?token=$token</a>";
    }
}
