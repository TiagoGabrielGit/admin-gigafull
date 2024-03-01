<?php
// buscar_servicos.php
require "../../conexoes/conexao.php";
require "../../conexoes/conexao_pdo.php";

// Verifica se o ID da empresa foi enviado
if (isset($_POST['chamadoID'])) {
    $chamadoID = $_POST['chamadoID'];

    $sql_atendentes =
        "SELECT u.id as 'idUsuario', p.nome as 'atendente', e.equipe
        FROM usuarios as u
        LEFT JOIN pessoas as p ON p.id = u.pessoa_id
        LEFT JOIN equipes_integrantes as ei ON ei.integrante_id = u.id
        LEFT JOIN equipe as e ON e.id = ei.equipe_id
        LEFT JOIN chamados_autorizados_atender as caa ON caa.equipe_id = ei.equipe_id
        WHERE caa.tipo_id = $chamadoID AND u.active = 1
        ORDER BY p.nome ASC";

 
    $options = '<option disabled selected value="">Selecione o atendente</option>';
    $r_atendentes = mysqli_query($mysqli, $sql_atendentes);
    while ($row = mysqli_fetch_assoc($r_atendentes)) {

        $options .= "<option value='{$row['idUsuario']}'>{$row['atendente']} - [Equipe: {$row['equipe']}]</option>";
    }

    // Retorna as opções dos serviços como resposta para a requisição AJAX
    echo $options;
}
