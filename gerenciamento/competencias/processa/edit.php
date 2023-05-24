<?php
require "../../../conexoes/conexao_pdo.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["codigo"]) || empty($_POST["competencia"]) || empty($_POST["descricao"]) || $_POST["situacao"] === null) {
        echo "<p style='color:red;'>Error: Por favor, preencha todos os campos obrigatórios.</p>";
    } else {
        $codigo = $_POST["codigo"];
        $competencia = $_POST["competencia"];
        $situacao = $_POST["situacao"];
        $descricao = $_POST["descricao"];


        $data = [
            'codigo' => $codigo,
            'competencia' => $competencia,
            'situacao' => $situacao,
            'descricao' => $descricao,
        ];

        $sql_update_competencia = "UPDATE competencias SET competencia=:competencia, descricao=:descricao, active=:situacao WHERE id=:codigo";
        $stmt1 = $pdo->prepare($sql_update_competencia);

        if ($stmt1->execute($data)) {
            echo "<p style='color:green;'>Editado com sucesso!</p>";
        } else {
            echo "<p style='color:red;'>Error: . $stmt->error</p>";
        }
    }
} else {
    header("Location: /gerenciamento/competencias/view.php?id=$codigo");
    exit();
}
