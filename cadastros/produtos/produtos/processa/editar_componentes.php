<?php
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "../../../../conexoes/conexao_pdo.php";

    $idComponentes = $_POST['idComponentes'];
    $fabricante = $_POST['fabricante'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $modeloComponentes = $_POST['modeloComponentes'];
    $modeloDescricao = $_POST['modeloDescricao'];

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE produtos_componentes SET fabricante_id = :fabricante, active = :ativo, modelo = :modelo, descricao = :descricao WHERE id = :id";

    // Prepara a consulta SQL
    $stmt = $pdo->prepare($sql);

    // Executa a consulta SQL
    $stmt->execute(array(
        ':id' => $idComponentes,
        ':fabricante' => $fabricante,
        ':modelo' => $modeloComponentes,
        ':ativo' => $ativo,
        ':descricao' => $modeloDescricao,
    ));

    // Verifique se a atualização foi bem-sucedida
    if ($stmt->rowCount() > 0) {
        echo "A atualização foi realizada com sucesso!";
    } else {
        echo "Nenhum registro foi atualizado.";
    }
}
