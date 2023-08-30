<?php
require "../../../../conexoes/conexao_pdo.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tipoID = $_POST['tipoID'];
    $tipoIncidenteEditar = $_POST['tipoIncidenteEditar'];
    $ativoTipoEditar = $_POST['ativoTipoEditar'];
    $codigoIncidenteEditar = $_POST['codigoIncidenteEditar'];

    $data = [
        'tipoID' => $tipoID,
        'tipoIncidenteEditar' => $tipoIncidenteEditar,
        'ativoTipoEditar' => $ativoTipoEditar,
        'codigoIncidenteEditar' => $codigoIncidenteEditar,
    ];

    try {
        $sql2 = "UPDATE incidentes_types SET type=:tipoIncidenteEditar, codigo=:codigoIncidenteEditar, active=:ativoTipoEditar WHERE id=:tipoID";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute($data);

        if ($stmt2->rowCount() > 0) {
            header("Location: /servicedesk/incidentes/configuracoes/index.php?&incidentesConfiguracao=tipo");
            exit;
        } else {
            header("Location: /servicedesk/incidentes/configuracoes/index.php?&incidentesConfiguracao=tipo");
            exit;
        }
    } catch (PDOException $e) {
        if ($e->errorInfo[1] === 1062) {
            header("Location: /servicedesk/incidentes/configuracoes/index.php?&error=codigo_ja_existe&incidentesConfiguracao=tipo");
            exit;
        } else {
            echo "Ocorreu um erro durante a inserção: " . $e->getMessage();
        }
    }
}
