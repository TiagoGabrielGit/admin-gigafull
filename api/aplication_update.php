<?php
require "../conexoes/conexao_pdo.php";
$version = $_GET['version'];

header('Access-Control-Allow-Origin: *');
$output = exec("/bin/bash atualiza_admin.sh");
if ($output == "Finish") {
    echo '{"retorno":"Update Success","versao":"' . $version . '"}';

    $sql =
        "INSERT INTO version (aplication_version, aplication_update) VALUES (:aplication_version, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':aplication_version', $version);
    $stmt->execute();
} else {
    echo '{"retorno":"Update Error"}';
}
