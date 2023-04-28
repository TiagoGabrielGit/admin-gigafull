<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

header('Access-Control-Allow-Origin: *');

$version =
    "SELECT
v.id as id,
v.aplication_version as aplication_version,
v.aplication_update as aplication_update
FROM
version as v
ORDER BY
v.aplication_update DESC

";

$consulta = mysqli_query($mysqli, $version);
if ($consulta) {
    $resp = mysqli_fetch_object($consulta);
    echo '{"version":"' . $resp->aplication_version . '"}';
    
} else {
    echo "Algo deu errado";
}
