<?php
// buscar_servicos.php
require "../../conexoes/conexao.php";
require "../../conexoes/conexao_pdo.php";

$serviceID = $_POST['serviceID'];

$sql_qtde_itens =
    "SELECT
       count(cis.id) as qtde
        FROM
        contract_iten_service as cis
        LEFT JOIN
        contract_service as cs
        ON
        cis.contract_service_id = cs.id
        LEFT JOIN
        iten_service as ise
        ON
        ise.id = cis.iten_service
        WHERE
        cis.active = 1
        and
        cs.active = 1
        and
        cs.id = $serviceID
        ORDER BY
        ise.item ASC";
$r_itens = $mysqli->query($sql_qtde_itens);
$row_itens = $r_itens->fetch_assoc();
if ($row_itens['qtde'] > 0) {

    $sql_itens =
        "SELECT
        cis.id as idContractItemService,
        ise.item as iten
        FROM
        contract_iten_service as cis
        LEFT JOIN
        contract_service as cs
        ON
        cis.contract_service_id = cs.id
        LEFT JOIN
        iten_service as ise
        ON
        ise.id = cis.iten_service
        WHERE
        cis.active = 1
        and
        cs.active = 1
        and
        cs.id = $serviceID
        ORDER BY
        ise.item ASC";


    $options_itens = '<option disabled selected value="">Selecione o serviço</option>';
    $r_itens = mysqli_query($mysqli, $sql_itens);
    while ($row_itens = mysqli_fetch_assoc($r_itens)) {

        $options_itens .= "<option value='{$row_itens['idContractItemService']}'>{$row_itens['iten']}</option>";
    }

    // Retorna as opções dos serviços como resposta para a requisição AJAX
    echo $options_itens;
} else {
    $options_itens = '<option disabled selected value="">Serviço sem itens vinculados</option>';
    echo $options_itens;
}
