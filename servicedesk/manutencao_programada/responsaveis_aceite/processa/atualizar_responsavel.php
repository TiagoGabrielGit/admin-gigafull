<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require "../../../../conexoes/conexao_pdo.php";
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $status = $_POST['status'];

        // Prepare a instrução SQL para atualizar os dados na tabela
        $sql = "UPDATE manutencao_programada_responsaveis_aceite SET nome = :nome, email = :email, active = :status WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        // Associe os parâmetros
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':status', $status);

        // Execute a instrução preparada
        if ($stmt->execute()) {
            // Redirecione para uma página de sucesso ou faça qualquer outra ação necessária
            header("Location: /servicedesk/manutencao_programada/responsaveis_aceite/view.php?id=$id"); // Substitua 'sucesso.php' pelo URL desejado
        } else {
            // Em caso de erro, você pode lidar com ele aqui
            header("Location: /servicedesk/manutencao_programada/responsaveis_aceite/view.php?id=$id");
        }
    } else {
        header("Location: /servicedesk/manutencao_programada/responsaveis_aceite/view.php?id=$id");
    }
} else {
    echo "Usuário não autenticado";
}
