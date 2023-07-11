<?php
session_start();
if (isset($_SESSION['id']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../conexoes/conexao_pdo.php";

    try {
        // Obtém os dados do formulário
        $idPOP = $_POST['mc_pop_id'];
        $anotacoes = $_POST['melhoriasConhecidas'];

        // Verifica se já existe uma anotação para o idPOP no banco de dados
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM pop_melhorias_conhecidas WHERE pop_id = :idPOP");
        $stmt->execute(array(':idPOP' => $idPOP));
        $anotacaoExistente = $stmt->fetchColumn();

        if ($anotacaoExistente > 0) {
            // Atualiza a anotação existente
            $stmt = $pdo->prepare("UPDATE pop_melhorias_conhecidas SET melhoria_conhecida = :anotacoes WHERE pop_id = :idPOP");
            $stmt->execute(array(':idPOP' => $idPOP, ':anotacoes' => $anotacoes));
        } else {
            // Insere uma nova anotação
            $stmt = $pdo->prepare("INSERT INTO pop_melhorias_conhecidas (pop_id, melhoria_conhecida) VALUES (:idPOP, :anotacoes)");
            $stmt->execute(array(':idPOP' => $idPOP, ':anotacoes' => $anotacoes));
        }

        // Verifica se a operação foi bem sucedida
        if ($stmt->rowCount() > 0) {
            header("Location: /telecom/sitepop/view.php?id=" . $idPOP);
        } else {
            header("Location: /telecom/sitepop/view.php?id=" . $idPOP);
        }
    } catch (PDOException $e) {
        header("Location: /telecom/sitepop/view.php?id=" . $idPOP);
    }
}
?>
