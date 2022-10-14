<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao_pdo.php";

$zabbix_event_id = $_GET["eventID"];

$sql = "UPDATE redeneutra_incidentes SET active=?, fimIncidente=NOW() WHERE zabbix_event_id=?";
$pdo->prepare($sql)->execute(['0', $zabbix_event_id]);