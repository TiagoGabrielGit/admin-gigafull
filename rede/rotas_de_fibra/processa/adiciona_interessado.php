<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        require "../../../conexoes/conexao_pdo.php";

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $rotaInteressado = $_POST["rotaInteressado"];
        $notificacaoMetodo = $_POST["notificacaoMetodo"];
        $active = "1";

        $sql = "INSERT INTO rotas_fibras_interessados (rf_id, interessado_empresa_id, active) VALUES (:rota, :empresa, :active)";

        // Prepara a declaração
        $stmt = $pdo->prepare($sql);

        // Associa os parâmetros à declaração
        $stmt->bindParam(':rota', $rotaInteressado, PDO::PARAM_INT);
        $stmt->bindParam(':empresa', $notificacaoMetodo, PDO::PARAM_INT);
        $stmt->bindParam(':active', $active, PDO::PARAM_INT);

        // Executa a declaração
        $stmt->execute();

        // Redireciona para a página de sucesso ou faça outra ação necessária
        header("Location: /rede/rotas_de_fibra/index.php?rotasDeFibra=interessados");
        exit;
    } catch (PDOException $e) {

        header("Location: /rede/rotas_de_fibra/index.php?rotasDeFibra=interessados");
        exit;
    }

    // Fecha a conexão PDO
    $pdo = null;
} else {
    echo "Este script não pode ser acessado diretamente.";
}
