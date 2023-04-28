<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

$nameEvent = $_GET["nameEvent"];
$descEvent = $_GET["descEvent"];
$tipoAgendamento = $_GET["tipoAgendamento"];
$intervaloAgendamento = $_GET["intervaloAgendamento"];
$inicioAgendamento = $_GET["inicioAgendamento"];
$fimAgendamento = $_GET["fimAgendamento"];
$solicitante = $_GET["solicitante"];
$empresaChamado = $_GET["empresaChamado"];
$tipoChamado = $_GET["tipoChamado"];
$assuntoChamado = $_GET["assuntoChamado"];
$relatoChamado = $_GET["relatoChamado"];

//Cria evento na tabela auxiliar
$sql_event_schedule =
    "INSERT INTO event_scheduler (event_name, event_desc, chamado_assunto, chamado_relato, tipo_chamado_id, solicitante_id, empresa_id)
VALUES (:nameEvent, :event_desc, :assuntoChamado, :relatoChamado, :tipoChamado, :solicitante, :empresaChamado)";
$stmt = $pdo->prepare($sql_event_schedule);
$stmt->bindParam(':nameEvent', $nameEvent);
$stmt->bindParam(':event_desc', $descEvent);
$stmt->bindParam(':assuntoChamado', $assuntoChamado);
$stmt->bindParam(':relatoChamado', $relatoChamado);
$stmt->bindParam(':tipoChamado', $tipoChamado);
$stmt->bindParam(':solicitante', $solicitante);
$stmt->bindParam(':empresaChamado', $empresaChamado);
$stmt->execute();
$id_event = $pdo->lastInsertId();

$sql_insert = "INSERT INTO chamados (atendente_id, assuntoChamado, relato_inicial, tipochamado_id, solicitante_id, empresa_id, status_id, data_abertura, in_execution, in_execution_atd_id, seconds_worked)
VALUES ('0', '$assuntoChamado', '$relatoChamado', $tipoChamado, $solicitante, $empresaChamado, '1', NOW(), '0', '0', '0');";

//Cria o agendamento do evento
$create_event =
    "
    CREATE EVENT `$id_event`
    ON SCHEDULE EVERY $intervaloAgendamento $tipoAgendamento
    STARTS '$inicioAgendamento' ENDS '$fimAgendamento'
    ON COMPLETION PRESERVE ENABLE
    COMMENT '$descEvent'
        DO 
            $sql_insert";

$stmt1 = $pdo->prepare($create_event);
$stmt1->execute();
?>