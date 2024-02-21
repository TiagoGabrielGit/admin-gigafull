<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../../conexoes/conexao_pdo.php";
    

    $idCompetencia = $_POST['idIncluirCompetencia'];
    $idTipoChamadoCompetencia = $_POST['idTipoChamadoCompetencia'];

    $sql =
        "INSERT INTO tipo_chamado_competencia (id_competencia, id_tipo_chamado) VALUES (:id_competencia, :id_tipo_chamado)";

    $stmt1 = $pdo->prepare($sql);

    $stmt1->bindParam(':id_competencia', $idCompetencia);
    $stmt1->bindParam(':id_tipo_chamado', $idTipoChamadoCompetencia);

    // Executa a consulta
    if ($stmt1->execute()) {
    }
}
