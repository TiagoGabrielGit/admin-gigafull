<?php
header("Content-Type: application/json; charset=UTF-8");
require "../conexoes/conexao_pdo.php";

$query_api = "SELECT active
FROM api
WHERE id = 6";

$query_api = $pdo->prepare($query_api);
$query_api->execute();
$result_api = $query_api->fetch(PDO::FETCH_ASSOC);

if ($result_api['active'] == 1) {

    $ip = $_SERVER['REMOTE_ADDR'];

    $query_ip = "SELECT count(*) as qtde
FROM api_externa_ip
WHERE api_id = 6 and ip = :ip";

    $stmt_ip = $pdo->prepare($query_ip);
    $stmt_ip->bindParam(':ip', $ip, PDO::PARAM_STR);
    $stmt_ip->execute();
    $result_ip = $stmt_ip->fetchAll(PDO::FETCH_ASSOC);

    if ($result_ip[0]['qtde'] > 0) {


        try {
            // Configuração para lançar exceções em caso de erro
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consulta incidentes abertos
            $sql = "SELECT * FROM incidentes WHERE active = 1";
            $stmt = $pdo->query($sql);

            // Obtém os resultados como um array associativo
            $incidentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Codifica os resultados em JSON e imprime
            echo json_encode($incidentes);
        } catch (PDOException $e) {
            // Em caso de erro na conexão ou consulta
            echo json_encode(array("error" => $e->getMessage()));
        }

        // Fecha a conexão com o banco de dados
        $pdo = null;
    } else {
        echo "IP $ip não autorizado";
    }
} else {
    echo "API não habilitada";
}
