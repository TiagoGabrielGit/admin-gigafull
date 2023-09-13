<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        require "../../conexoes/conexao_pdo.php";

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Coleta os dados do formulário
        $notificacaoIdEmpresa = $_POST["notificacaoIdEmpresa"];
        $notificacaoMetodo = $_POST["notificacaoMetodo"];
        $notificacaoMidia = $_POST["notificacaoMidia"];
        $active = "1";

        // Prepara a instrução SQL para inserção de dados
        $sql = "INSERT INTO empresas_notificacao (empresa_id, metodo_id, midia, active) VALUES (:id_empresa, :metodo, :midia, :active)";

        // Prepara a declaração
        $stmt = $pdo->prepare($sql);

        // Associa os parâmetros à declaração
        $stmt->bindParam(':id_empresa', $notificacaoIdEmpresa, PDO::PARAM_INT);
        $stmt->bindParam(':metodo', $notificacaoMetodo, PDO::PARAM_INT);
        $stmt->bindParam(':midia', $notificacaoMidia, PDO::PARAM_STR);
        $stmt->bindParam(':active', $active, PDO::PARAM_INT);

        // Executa a declaração
        $stmt->execute();

        header("Location: /empresas/view.php?id=$notificacaoIdEmpresa");
        exit;
    } catch (PDOException $e) {
        header("Location: /empresas/view.php?id=$notificacaoIdEmpresa");
        exit;
    }

    // Fecha a conexão PDO
    $pdo = null;
} else {
    echo "Este script não pode ser acessado diretamente.";
}
