<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        require "../../../conexoes/conexao_pdo.php";

        $pessoaID = $_POST['nomeUsuario'];
        $empresaID = $_POST["empresaSelect"];
        $perfil = $_POST["perfil"];
        $dashboard = $_POST["dashboard"];


        // Gerar uma senha segura aleatória
        $password = bin2hex(random_bytes(8));

        // Criptografar a senha em MD5
        $passwordMD5 = md5($password);

        $insert_usuario =
            "INSERT INTO usuarios (pessoa_id, senha, criado, empresa_id, perfil_id, dashboard, reset_password, active)
VALUES (:pessoa_id, :senha, NOW(), :empresa_id, :perfil_id, :dashboard, '1', '1')";

        $stmt1 = $pdo->prepare($insert_usuario);

        $stmt1->bindParam(':pessoa_id', $pessoaID);
        $stmt1->bindParam(':senha', $password);
        $stmt1->bindParam(':empresa_id', $empresaID);
        $stmt1->bindParam(':dashboard', $dashboard);
        $stmt1->bindParam(':perfil_id', $perfil);
        $stmt1->bindParam(':senha', $passwordMD5);

        // Executa a consulta
        if ($stmt1->execute()) {
            $idUsuario = $pdo->lastInsertId();

            // Preparando e executando a segunda consulta
            $_insert_permissoes =
                "INSERT INTO usuarios_permissoes
                (`usuario_id`,
                `permite_interagir_chamados`,
                `permite_abrir_chamados_outras_empresas`,
                `permite_atender_chamados_outras_empresas`,
                `permite_atender_chamados`,
                `permite_encaminhar_chamados`,
                `permite_gerenciar_interessados`,
                `permite_selecionar_competencias_abertura_chamado`,
                `permite_selecionar_solicitantes_abertura_chamado`,
                `permite_selecionar_atendente_abertura_chamado`,
                `permite_alterar_configuracoes_chamado`,
                `permite_gerenciar_incidente`,
                `permite_visualizar_protocolo_erp`,
                `permite_configurar_privacidade_credenciais`)
                VALUES
                (:usuario_id, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')";

            $stmt2 = $pdo->prepare($_insert_permissoes);
            $stmt2->bindParam(':usuario_id', $idUsuario);
            $stmt2->execute();

            $_SESSION['temp_password'] = $password;

            header("Location: /gerenciamento/usuarios/view.php?id=$idUsuario");
            exit();
        } else {
            header("Location: /gerenciamento/usuarios/usuarios.php");
            exit();
        }
    }
} else {
    header("Location: /index.php");
    exit();
}
