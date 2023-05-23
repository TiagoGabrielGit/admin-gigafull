<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../conexoes/conexao_pdo.php";

    $idCompetencia = $_POST['idIncluirCompetencia'];
    $idUsuario = $_POST['idUsuarioCompetencia'];

    $sql =
        "INSERT INTO usuario_competencia (id_competencia, id_usuario) VALUES (:id_competencia, :id_usuario)";

    $stmt1 = $pdo->prepare($sql);

    $stmt1->bindParam(':id_competencia', $idCompetencia);
    $stmt1->bindParam(':id_usuario', $idUsuario);

    // Executa a consulta
    if ($stmt1->execute()) {
    }
}
