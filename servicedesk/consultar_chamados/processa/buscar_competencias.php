<?php
require "../../../conexoes/conexao.php";
// buscar_competencias.php

// Obter o ID do tipo de chamado enviado pela requisição AJAX
$tipoChamadoId = $_GET['tipoChamadoId'];

// Faça a consulta no banco de dados para obter as competências necessárias para o tipo de chamado
$sql =
  "SELECT 
  tc.id_competencia as competencia_id 
FROM 
  tipo_chamado_competencia tc 
WHERE 
  tc.id_tipo_chamado = $tipoChamadoId";

$resultado = mysqli_query($mysqli, $sql);

$competencias = array();
while ($row = mysqli_fetch_assoc($resultado)) {
  $competencias[] = $row['competencia_id'];
}

// Defina o cabeçalho da resposta como JSON
header('Content-Type: application/json');


// Retorne as competências como uma resposta JSON
echo json_encode($competencias);
