<?php
require "../../../conexoes/conexao_pdo.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['competencia']) || empty($_POST['descricao'])) {
        echo "<p style='color:red;'>Error: Dados obrigatórios não preenchidos.</p>";
    } else {
        $competencia = $_POST['competencia'];
        $descricao = $_POST['descricao'];

        $sql =
            "INSERT INTO competencias (competencia, descricao, active) VALUES (:competencia, :descricao, '1')";

        $stmt1 = $pdo->prepare($sql);

        $stmt1->bindParam(':competencia', $competencia);
        $stmt1->bindParam(':descricao', $descricao);

        // Executa a consulta
        if ($stmt1->execute()) {
            echo "<p style='color:green;'>Cadastro realizado.</p>";
        }
    }
}
