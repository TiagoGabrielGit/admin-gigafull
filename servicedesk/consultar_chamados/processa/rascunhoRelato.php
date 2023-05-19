<?php
require "../../../conexoes/conexao_pdo.php";

if (empty($_POST['chamadoID']) || empty($_POST['novoRelato'])) {
    echo "<p style='color:red;'>Error: Dados obrigatórios não preenchidos.</p>";
} else {
    $chamadoID = $_POST['chamadoID'];
    $novoRelato = $_POST['novoRelato'];

    $sql1 = "INSERT INTO chamados_relatos_rascunho (id_chamado, relato) VALUES (:id_chamado, :relato)";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->bindParam(':id_chamado', $chamadoID);
    $stmt1->bindParam(':relato', $novoRelato);

    if ($stmt1->execute()) {
        echo "<p style='color:green;'>Relato salvo como rascunho.</p>";
    } else {
        echo "<p style='color:red;'>Error: Erro ao salvar.</p>";
    }
}
