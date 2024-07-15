<?php
session_start();
if (isset($_SESSION['id']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../conexoes/conexao_pdo.php";

    $usuario_criador = $_SESSION['id'];

    try {
        // Obtém os dados do formulário
        $idPOP = $_POST['mc_pop_id'];
        $anotacoes = $_POST['melhoriasConhecidas'];
        $status = '1';

        // Insere uma nova anotação
        $stmt = $pdo->prepare("INSERT INTO pop_melhorias_conhecidas (pop_id, melhoria_conhecida, usuario_criador, criado, status) VALUES (:idPOP, :anotacoes, :usuario_criador, NOW(), :status)");
        $stmt->execute(array(':idPOP' => $idPOP, ':anotacoes' => $anotacoes, ':usuario_criador' => $usuario_criador, ':status' => $status));

        // Verifica se a operação foi bem sucedida
        if ($stmt->rowCount() > 0) {
            header("Location: /telecom/sitepop/view_atividades.php?id=" . $idPOP);
        } else {
            header("Location: /telecom/sitepop/view_atividades.php?id=" . $idPOP);
        }
    } catch (PDOException $e) {
        header("Location: /telecom/sitepop/view_atividades.php?id=" . $idPOP);
    }
}
