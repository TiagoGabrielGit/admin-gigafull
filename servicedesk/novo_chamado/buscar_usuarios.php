<?php
// buscar_servicos.php
require "../../conexoes/conexao.php";
require "../../conexoes/conexao_pdo.php";

// Verifica se o ID da empresa foi enviado
if (isset($_POST['empresaId'])) {
    $empresaId = $_POST['empresaId'];

    $sql_solicitante =
        "SELECT u.id as 'idUsuario', p.nome as 'solicitante'
    FROM usuarios as u
    LEFT JOIN pessoas as p ON p.id = u.pessoa_id
    LEFT JOIN empresas as e ON e.id = u.empresa_id
    WHERE  u.active = 1 AND e.id = $empresaId 
    ORDER BY p.nome ASC";


    $options = '<option disabled selected value="">Selecione o solicitante</option>';
    $r_solicitante = mysqli_query($mysqli, $sql_solicitante);
    while ($row = mysqli_fetch_assoc($r_solicitante)) {

        $options .= "<option value='{$row['idUsuario']}'>{$row['solicitante']}</option>";
    }

    // Retorna as opções dos serviços como resposta para a requisição AJAX
    echo $options;
}
