<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idUser = $_POST['permissionIdUser'];
    require "../../../conexoes/conexao_pdo.php";
    try {

        // Prepare a consulta SQL
        $sql = "UPDATE usuarios SET 
            notify_email = :notificaEmail,
            notify_email_abertura = :notificaEmailAbertura,
            notify_email_encaminhamento = :notificaEmailEncaminhamento,
            notify_email_relatos = :notificaEmailRelatos,
            notify_email_apropriacao = :notificaEmailApropriacao,
            notify_email_execucao = :notificaEmailExecucao,
            permissao_chamado = :permissaoAberturaChamado,
            permissao_visualiza_chamado = :permissaoVisualizaChamado,
            permissao_abrir_chamado = :permissaoAbrirChamado,
            permissao_apropriar_chamado = :permissaoApropriarChamados,
            permissao_encaminhar_chamado = :permissaoEncaminharChamados,
            permissao_interessados_chamados = :permissaoInteressadosChamados,
            permissao_selecionar_competencias = :permissaoSelecionarCompetencias,
            permissao_selecionar_solicitante = :permissaoSelecionaSolicitante,
            permissao_selecionar_atendente = :permissaoSelecionaAtendente,
            permissao_configuracoes_chamados = :permissaoAlterarConfiguracoes,
            permissao_privacidade_credenciais = :permissaoPrivacidadeCredenciais,
            permissao_gerenciar_incidentes = :permissaoGerenciarIncidentes,
            permissao_protocolo_erp = :permissao_protocolo_erp
            WHERE id = :permissionIdUser";

        // Preparar a declaração SQL
        $stmt = $pdo->prepare($sql);

        // Substituir os valores dos parâmetros com os valores do formulário
        $stmt->bindParam(':notificaEmail', $_POST['notificaEmail']);
        $stmt->bindParam(':notificaEmailAbertura', $_POST['notificaEmailAbertura']);
        $stmt->bindParam(':notificaEmailEncaminhamento', $_POST['notificaEmailEncaminhamento']);
        $stmt->bindParam(':notificaEmailRelatos', $_POST['notificaEmailRelatos']);
        $stmt->bindParam(':notificaEmailApropriacao', $_POST['notificaEmailApropriacao']);
        $stmt->bindParam(':notificaEmailExecucao', $_POST['notificaEmailExecucao']);
        $stmt->bindParam(':permissaoAberturaChamado', $_POST['permissaoAberturaChamado']);
        $stmt->bindParam(':permissaoVisualizaChamado', $_POST['permissaoVisualizaChamado']);
        $stmt->bindParam(':permissaoAbrirChamado', $_POST['permissaoAbrirChamado']);
        $stmt->bindParam(':permissaoApropriarChamados', $_POST['permissaoApropriarChamados']);
        $stmt->bindParam(':permissaoEncaminharChamados', $_POST['permissaoEncaminharChamados']);
        $stmt->bindParam(':permissaoInteressadosChamados', $_POST['permissaoInteressadosChamados']);
        $stmt->bindParam(':permissaoSelecionarCompetencias', $_POST['permissaoSelecionarCompetencias']);
        $stmt->bindParam(':permissaoSelecionaSolicitante', $_POST['permissaoSelecionaSolicitante']);
        $stmt->bindParam(':permissaoSelecionaAtendente', $_POST['permissaoSelecionaAtendente']);
        $stmt->bindParam(':permissaoAlterarConfiguracoes', $_POST['permissaoAlterarConfiguracoes']);
        $stmt->bindParam(':permissaoPrivacidadeCredenciais', $_POST['permissaoPrivacidadeCredenciais']);
        $stmt->bindParam(':permissaoGerenciarIncidentes', $_POST['permissaoGerenciarIncidentes']);
        $stmt->bindParam(':permissao_protocolo_erp', $_POST['permissaoProtocoloERP']);

        $stmt->bindParam(':permissionIdUser', $_POST['permissionIdUser']);

        

        $stmt->execute();

        header("Location: /gerenciamento/usuarios/view.php?id=$idUser");
        exit;
    } catch (PDOException $e) {
        //echo "Erro: " . $e->getMessage();

        header("Location: /gerenciamento/usuarios/view.php?id=$idUser");
        exit;
    }
}
