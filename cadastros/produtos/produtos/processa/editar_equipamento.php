<?php
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "../../../../conexoes/conexao_pdo.php";

    $id = $_POST['id'];
    $equipamento = $_POST['equipamento'];
    $fabricante = $_POST['fabricante'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    // Configura o modo de erro do PDO para Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Construa a consulta SQL para atualizar os dados na tabela equipamentos
    $sql = "UPDATE equipamentos SET equipamento = :equipamento, fabricante = :fabricante, modificado = NOW(), deleted = :deleted WHERE id = :id";

    // Prepara a consulta SQL
    $stmt = $pdo->prepare($sql);

    // Executa a consulta SQL
    $stmt->execute(array(
        ':equipamento' => $equipamento,
        ':fabricante' => $fabricante,
        ':id' => $id,
        ':deleted' => $ativo,
    ));

    // Verifique se a atualização foi bem-sucedida
    if ($stmt->rowCount() > 0) {
        echo "A atualização foi realizada com sucesso!";
    } else {
        echo "Nenhum registro foi atualizado.";
    }
}
?>