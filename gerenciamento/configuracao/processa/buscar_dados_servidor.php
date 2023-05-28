<?php
require "../../../conexoes/conexao_pdo.php";

// Obtém o ID do servidor enviado via GET
$serverId = $_GET['id'];

// Prepara a consulta SQL
$sql = "SELECT * FROM servermail WHERE id = :serverId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':serverId', $serverId);

// Executa a consulta
$stmt->execute();

// Verifica se encontrou o servidor
if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Cria um array com os dados do servidor
    $serverData = array(
        'serverID' => $row['id'],
        'server' => $row['server'],
        'status' => $row['active'],
        'nome_remetente' => $row['remetente'],
        'conta_envio' => $row['user'],
        'senha_conta_envio' => $row['password'],
        'servidor_smtp' => $row['host'],
        'porta_smtp' => $row['port'],
        'seguranca_smtp' => $row['authentication']
    );

    // Retorna os dados como JSON
    header('Content-Type: application/json');
    echo json_encode($serverData);
} else {
    // Retorna um JSON vazio se não houver resultado
    header('Content-Type: application/json');
    echo json_encode(array());
}
