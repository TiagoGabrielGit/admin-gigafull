<?php
session_start();
if (isset($_SESSION['id'])) {

    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_voalle.php');


    // Receber os dados do formulário
    $id_afericao = $_POST['id_afericao'];
    $olt_id = $_POST['olt']; // Modificado para olt_id conforme nome do campo no form
    $cto_id = $_POST['cto_id'];
    $texto_inicial = $_POST['texto_inicial'];
    $cto = $_POST['cto'];
    $integration_code = $_POST['integration_code'];


    // Data atual
    $data_atual = date('Y-m-d H:i:s');

    // Montar o texto inicial com formatação HTML
    $texto_inicial .= '<br><br>';
    $texto_inicial .= '<b>CTO alterada manualmente para OLT: ' . htmlspecialchars($olt_id) . ' CTO: ' . htmlspecialchars($cto) . ' em ' . $data_atual . '</b>';

    //////////////////////////////////////////////////////////////////////////////////////////////////////

    // Obtém a ocupação das portas
    $query_ocupacao = "SELECT
                autport.port as porta,
                autcont.user,
                autport.blocked_description
                from authentication_splitter_ports autport 
                left join authentication_contracts autcont on autport.authentication_contract_id = autcont.id 
                left join contracts on contracts.id = autcont.contract_id AND v_stage = 'Aprovado'and v_status not in('Cancelado', 'Encerrado', 'Cortesia')
                left join people on people.id = contracts.client_id
                left join authentication_access_points  acp on acp.id = autcont.authentication_access_point_id
                left join authentication_splitters asp  on autport.authentication_splitter_id = asp.id
                left join network_boxes nb on nb.id = asp.network_box_id
                where nb.integration_code like :integration_code and nb.deleted = false
                ORDER BY autport.port ASC";

    // Executa a consulta de ocupação com o integration_code específico
    $ocupacao_stmt = $pgsql_pdo->prepare($query_ocupacao);
    $ocupacao_stmt->bindParam(':integration_code', $integration_code);
    $ocupacao_stmt->execute();
    $ocupacao_result = $ocupacao_stmt->fetchAll(PDO::FETCH_ASSOC);

    $ocupacao_formatted = '';
    foreach ($ocupacao_result as $row) {
        $ocupacao_formatted .= "{$row['porta']} - {$row['user']} {$row['blocked_description']}<br>";
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////

    // Preparar e executar a atualização no banco de dados
    $query = "UPDATE afericao SET olt_id = :olt_id, cto_id = :cto_id, texto_inicial = :texto_inicial, crm_pre_afericao = :crm_pre_afericao WHERE id = :id_afericao";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array(
        ':olt_id' => $olt_id,
        ':cto_id' => $cto_id,
        ':texto_inicial' => $texto_inicial,
        ':id_afericao' => $id_afericao,
        ':crm_pre_afericao' => $ocupacao_formatted,


    ));

    // Verificar se a atualização foi bem-sucedida
    if ($stmt->rowCount() > 0) {
        header("Location: /rede/afericao/afericao.php?id=" . $id_afericao . '&return=Atualização bem sucedida');
        exit();
    } else {
        header("Location: /rede/afericao/afericao.php?id=" . $id_afericao . '&return=Erro ao atualizar');
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
