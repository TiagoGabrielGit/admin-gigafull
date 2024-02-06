<?php
session_start();

if (isset($_SESSION['id'])) {
    $chamado_id = $_POST['chamado_id_cto'];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        require "../../../conexoes/conexao_pdo.php";
        require "../../../conexoes/conexao_voalle.php";

        $cto_id = $_POST['cto_id'];

        $query_nbintegration = "SELECT nbintegration_code FROM gpon_ctos as gc WHERE gc.id = :id";
        $nbintegration_stmt = $pdo->prepare($query_nbintegration);
        $nbintegration_stmt->bindParam(':id', $cto_id);
        $nbintegration_stmt->execute();
        $nbintegration_result = $nbintegration_stmt->fetchAll(PDO::FETCH_ASSOC);
        $first_result = reset($nbintegration_result);
        $nbintegration = $first_result['nbintegration_code'];


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
          where nb.integration_code like :integration_code
          ORDER BY autport.port ASC";

        // Executa a consulta de ocupação com o integration_code específico
        $ocupacao_stmt = $pgsql_pdo->prepare($query_ocupacao);
        $ocupacao_stmt->bindParam(':integration_code', $nbintegration);
        $ocupacao_stmt->execute();
        $ocupacao_result = $ocupacao_stmt->fetchAll(PDO::FETCH_ASSOC);

        // Formata o resultado da consulta de ocupação
        $ocupacao_formatted = '<br>';
        foreach ($ocupacao_result as $row) {
            $ocupacao_formatted .= "{$row['porta']} - {$row['user']} {$row['blocked_description']}<br>";
        }
        $data_hora_atual = date('d/m/Y H:i');

        $ocupacao_formatted .= "<br> Leitura realizada em: " . $data_hora_atual;

        $query_update_afericao = "UPDATE afericao SET crm_pos_afericao = :crm_pos_afericao WHERE chamado_id = :chamado_id";
        $stmt_update_afericao = $pdo->prepare($query_update_afericao);
        $valores_update_afericao = array(':crm_pos_afericao' => $ocupacao_formatted, ':chamado_id' => $chamado_id);
        if ($stmt_update_afericao->execute($valores_update_afericao)) {
            header("Location: /servicedesk/consultar_chamados/view.php?id=$chamado_id");
            exit;
        } else {
            header("Location: /servicedesk/consultar_chamados/view.php?id=$chamado_id");
            exit;
        }
    } else {
        header("Location: /servicedesk/consultar_chamados/view.php?id=$chamado_id");
        exit;
    }
} else {
    header('Location: /index.php');
    exit;
}
