<?php
require "../../../conexoes/conexao_pdo.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['competencia'])) {
        echo "<p style='color:red;'>Error: Dados obrigatórios não preenchidos.</p>";
    } else {
        $competencia = $_POST['competencia'];

        $sql =
            "INSERT INTO competencias (competencia, active) VALUES (:competencia, '1')";

        $stmt1 = $pdo->prepare($sql);

        $stmt1->bindParam(':competencia', $competencia);

        // Executa a consulta
        if ($stmt1->execute()) {
            echo "<p style='color:green;'>Cadastro realizado.</p>";
        }
    }
}
