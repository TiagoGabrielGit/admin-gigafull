<?php
require "../../../conexoes/conexao_pdo.php";

$incidenteID = isset($_POST['incidenteID']) ? $_POST['incidenteID'] : null;
$solicitante = isset($_POST['solicitante']) ? $_POST['solicitante'] : null;
$classIncidente = isset($_POST['classIncidente']) ? $_POST['classIncidente'] : null;
$statusIncidente = isset($_POST['statusIncidente']) ? $_POST['statusIncidente'] : null;
$previsaoConclusao = isset($_POST['previsaoConclusao']) ? $_POST['previsaoConclusao'] : null;
$tipoIncidente = isset($_POST['tipoIncidente']) ? $_POST['tipoIncidente'] : null;
$relatoIncidente = isset($_POST['relatoIncidente']) ? $_POST['relatoIncidente'] : null;
$horaAtual = date('Y-m-d H:i:s');


$sql = "UPDATE incidentes SET ";
$params = array();

if ($classIncidente != null) {
    $sql .= "classificacao = :classIncidente, ";
    $params[':classIncidente'] = $classIncidente;
}

if ($tipoIncidente != null) {
    $sql .= "incident_type = :tipoIncidente, ";
    $params[':tipoIncidente'] = $tipoIncidente;
}

if ($statusIncidente != null && $statusIncidente == "0") {
    $sql .= "active = :statusIncidente, ";
    $params[':statusIncidente'] = $statusIncidente;

    $sql .= "fimIncidente = :fimIncidente, ";
    $params[':fimIncidente'] = $horaAtual;
} else if (($statusIncidente != null && $statusIncidente == "1")) {
    $sql .= "active = :statusIncidente, ";
    $params[':statusIncidente'] = $statusIncidente;
}

if (isset($_POST['semPrevisao'])) {
    $previsaoConclusao = null;
    $sql .= "previsaoNormalizacao = :previsaoConclusao, ";
    $params[':previsaoConclusao'] = $previsaoConclusao;
} else {
    if ($previsaoConclusao != null) {
        $sql .= "previsaoNormalizacao = :previsaoConclusao, ";
        $params[':previsaoConclusao'] = $previsaoConclusao;
    }
}

$sql = rtrim($sql, ", ") . " WHERE id = :id";
$params[':id'] = $incidenteID;

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$sql2 = "INSERT INTO incidentes_relatos (incidente_id, relato_autor, relato, horarioRelato) VALUES (:valor1, :valor4, :valor2, :valor3)";
$stmt2 = $pdo->prepare($sql2);

$stmt2->bindValue(':valor1', $incidenteID);
$stmt2->bindValue(':valor2', $relatoIncidente);
$stmt2->bindValue(':valor3', $horaAtual);
$stmt2->bindValue(':valor4', $solicitante);
if ($stmt2->execute()) {
    header("Location: /servicedesk/incidentes/view.php?id=$incidenteID");
    exit();
} else {
    header("Location: /servicedesk/incidentes/view.php?id=$incidenteID");
    exit();
}
