<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idUser = $_POST['permissionIdUser'];
        require "../../../conexoes/conexao_pdo.php";
        try {

            // Prepare a consulta SQL
            $sql = "UPDATE usuarios_permissoes SET 
            permite_abrir_chamados_outras_empresas = :permite_abrir_chamados_outras_empresas,
            permite_atender_chamados = :permite_atender_chamados,
            permite_atender_chamados_outras_empresas = :permite_atender_chamados_outras_empresas,
            permite_interagir_chamados = :permite_interagir_chamados,
            permite_encaminhar_chamados = :permite_encaminhar_chamados,
            permite_gerenciar_interessados = :permite_gerenciar_interessados,
            permite_selecionar_competencias_abertura_chamado = :permite_selecionar_competencias_abertura_chamado,
            permite_selecionar_solicitantes_abertura_chamado = :permite_selecionar_solicitantes_abertura_chamado,
            permite_selecionar_atendente_abertura_chamado = :permite_selecionar_atendente_abertura_chamado,
            permite_alterar_configuracoes_chamado = :permite_alterar_configuracoes_chamado,
            permite_gerenciar_incidente = :permite_gerenciar_incidente,
            permite_visualizar_protocolo_erp = :permite_visualizar_protocolo_erp,
            permite_configurar_privacidade_equipamentos = :permite_configurar_privacidade_equipamentos,
            permite_configurar_privacidade_credenciais = :permite_configurar_privacidade_credenciais
            WHERE usuario_id = :permissionIdUser";

            // Preparar a declaração SQL 
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':permite_abrir_chamados_outras_empresas', $_POST['permite_abrir_chamados_outras_empresas']);
            $stmt->bindParam(':permite_atender_chamados', $_POST['permite_atender_chamados']);
            $stmt->bindParam(':permite_atender_chamados_outras_empresas', $_POST['permite_atender_chamados_outras_empresas']);
            $stmt->bindParam(':permite_interagir_chamados', $_POST['permite_interagir_chamados']);
            $stmt->bindParam(':permite_encaminhar_chamados', $_POST['permite_encaminhar_chamados']);
            $stmt->bindParam(':permite_gerenciar_interessados', $_POST['permite_gerenciar_interessados']);
            $stmt->bindParam(':permite_selecionar_competencias_abertura_chamado', $_POST['permite_selecionar_competencias_abertura_chamado']);
            $stmt->bindParam(':permite_selecionar_solicitantes_abertura_chamado', $_POST['permite_selecionar_solicitantes_abertura_chamado']);
            $stmt->bindParam(':permite_selecionar_atendente_abertura_chamado', $_POST['permite_selecionar_atendente_abertura_chamado']);
            $stmt->bindParam(':permite_alterar_configuracoes_chamado', $_POST['permite_alterar_configuracoes_chamado']);
            $stmt->bindParam(':permite_gerenciar_incidente', $_POST['permite_gerenciar_incidente']);
            $stmt->bindParam(':permite_visualizar_protocolo_erp', $_POST['permite_visualizar_protocolo_erp']);
            $stmt->bindParam(':permite_configurar_privacidade_equipamentos', $_POST['permite_configurar_privacidade_equipamentos']);
            $stmt->bindParam(':permite_configurar_privacidade_credenciais', $_POST['permite_configurar_privacidade_credenciais']);

            $stmt->bindParam(':permissionIdUser', $_POST['permissionIdUser']);



            $stmt->execute();

            header("Location: /gerenciamento/usuarios/view.php?id=$idUser");
            exit;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            //header("Location: /gerenciamento/usuarios/view.php?id=$idUser");
            //exit;
        }
    }
} else {
    header("Location: /index.php");
    exit();
}
