<?php
// buscar_servicos.php
require "../../conexoes/conexao.php";
require "../../conexoes/conexao_pdo.php";

// Verifica se o ID da empresa foi enviado
if (isset($_POST['empresaId'])) {
    $empresaId = $_POST['empresaId'];

    // Aqui você pode adicionar a lógica para buscar os serviços relacionados à empresa com o ID fornecido
    // Substitua este exemplo pela sua lógica real de busca dos serviços

    $sql_services =
        "SELECT
    c.id as contractID,
    cs.id as contractServiceID,
    s.service as service
    FROM
    contract_service as cs
    LEFT JOIN
    contract as c
    ON
    cs.contract_id = c.id
    LEFT JOIN
    service as s
    ON
    s.id = cs.service_id
    WHERE
    c.empresa_id = $empresaId
    and
    c.active = 1 
    and
    cs.active = 1
    ORDER BY
    s.service ASC";


    $options = '<option disabled selected value="">Selecione o serviço</option>';
    $r_services = mysqli_query($mysqli, $sql_services);
    while ($row = mysqli_fetch_assoc($r_services)) {

        $options .= "<option value='{$row['contractServiceID']}'>{$row['contractID']}/{$row['contractServiceID']} - {$row['service']}</option>";
    }

    // Retorna as opções dos serviços como resposta para a requisição AJAX
    echo $options;
}
