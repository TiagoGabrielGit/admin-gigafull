<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

        $idEmpresa = $_POST['idEmpresa'];
        $tipo = "equipamento";
        $usuario_id = $_SESSION['id'];
        $privacidade = $_POST['cadastroPrivacidade'];
        $idEquipamento = $_POST['idEquipamento'];
        $descricao = $_POST['equipamentoDescricao'];
        $usuario = $_POST['equipamentoUsuario'];
        $senha = $_POST['equipamentoSenha'];

        try {
            $pdo->beginTransaction();

            $sql = "INSERT INTO credenciais_equipamento 
                    (empresa_id, tipo, usuario_id, privacidade, equipamento_id, equipamentodescricao, equipamentousuario, equipamentosenha, active) 
                    VALUES 
                    (?, ?, ?, ?, ?, ?, ?, ?, 1)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$idEmpresa, $tipo, $usuario_id, $privacidade, $idEquipamento, $descricao, $usuario, $senha]);

            $pdo->commit();

            header("Location: /telecom/vault/equipamentos/view.php?id=$idEquipamento");
            exit();
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "Erro ao salvar os dados: " . $e->getMessage();
        }
    } else {
        // Se o método de requisição não for POST, redirecione para a página principal
        header("Location: /telecom/vault/equipamentos/index.php");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
?>
