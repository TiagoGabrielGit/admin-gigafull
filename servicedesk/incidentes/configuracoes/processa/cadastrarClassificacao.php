<?php
require "../../../../conexoes/conexao_pdo.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $classificacaoIncidente = $_POST['classificacaoIncidente'];
    $descricaoClassificacao = $_POST['descricaoClassificacao'];
    $colorClassificacao = $_POST['colorClassificacao'];

    $active = "1";
    try {
        $sql = "INSERT INTO incidentes_classificacao (classificacao, descricao, active, color) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$classificacaoIncidente, $descricaoClassificacao, $active, $colorClassificacao]);

        if ($stmt->rowCount() > 0) {
            header("Location: /servicedesk/incidentes/configuracoes/index.php?&incidentesConfiguracao=classificacao");
            exit;
        } else {
            header("Location: /servicedesk/incidentes/configuracoes/index.php?&incidentesConfiguracao=classificacao");
            exit;
        }
    } catch (PDOException $e) {
        if ($e->errorInfo[1] === 1062) {
            header("Location: /servicedesk/incidentes/configuracoes/index.php?incidentesConfiguracao=classificacao");
            exit;
        } else {
            echo "Ocorreu um erro durante a inserção: " . $e->getMessage();
        }
    }
}
