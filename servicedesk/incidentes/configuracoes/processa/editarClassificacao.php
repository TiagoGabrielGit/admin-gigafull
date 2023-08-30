<?php
require "../../../../conexoes/conexao_pdo.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $classificacaoID = $_POST['classificacaoID'];
    $classificacaoIncidenteEditar = $_POST['classificacaoIncidenteEditar'];
    $descricaoClassificacaoEditar = $_POST['descricaoClassificacaoEditar'];
    $ativoClassificacaoEditar = $_POST['ativoClassificacaoEditar'];

    $data = [
        'classificacaoID' => $classificacaoID,
        'classificacaoIncidenteEditar' => $classificacaoIncidenteEditar,
        'descricaoClassificacaoEditar' => $descricaoClassificacaoEditar,
        'active' => $ativoClassificacaoEditar,
    ];

    try {
        $sql2 = "UPDATE incidentes_classificacao SET classificacao=:classificacaoIncidenteEditar, descricao=:descricaoClassificacaoEditar, active=:active WHERE id=:classificacaoID";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute($data);

        if ($stmt2->rowCount() > 0) {
            header("Location: /servicedesk/incidentes/configuracoes/index.php?incidentesConfiguracao=classificacao");
            exit;
        } else {
            header("Location: /servicedesk/incidentes/configuracoes/index.php?incidentesConfiguracao=classificacao");
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
