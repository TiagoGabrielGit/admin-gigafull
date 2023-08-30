<?php
require "../../../../conexoes/conexao_pdo.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tipoIncidente = $_POST['tipoIncidente'];
    $codigoTipoIncidente = $_POST['codigoTipoIncidente'];
    $default = "0";
    $active = "1";

    try {

        $sql = "INSERT INTO incidentes_types (type, codigo, `default`, active) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$tipoIncidente, $codigoTipoIncidente, $default, $active]);

        if ($stmt->rowCount() > 0) {
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
