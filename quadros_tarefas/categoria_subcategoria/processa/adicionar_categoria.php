<?php
session_start();

// Verificando se o usuário está logado
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    // Checando se o método da requisição é POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificando se o campo 'categoria' foi enviado e não está vazio
        if (isset($_POST['categoria']) && !empty($_POST['categoria'])) {
            $categoria = $_POST['categoria'];

            try {
                // Preparando a instrução SQL para evitar SQL Injection
                $stmt = $pdo->prepare("INSERT INTO qt_categorias (descricao, active) VALUES (:categoria, 1)");
                // Associando o valor ao parâmetro
                $stmt->bindValue(':categoria', $categoria, PDO::PARAM_STR);

                // Executando a instrução SQL
                if ($stmt->execute()) {
                    // Redirecionando para a página desejada após sucesso
                    header("Location: /quadros_tarefas/categoria_subcategoria/index.php");
                    exit();
                } else {
                    echo "Erro ao adicionar categoria.";
                }
            } catch (PDOException $e) {
                // Tratando erros de execução do PDO
                echo "Erro ao adicionar categoria: " . $e->getMessage();
            }
        } else {
            // Redirecionando se o campo 'categoria' estiver vazio
            header("Location: /quadros_tarefas/categoria_subcategoria/index.php");
            exit();
        }
    }
} else {
    // Redirecionando para a página de login se o usuário não estiver logado
    header("Location: /index.php");
    exit();
}
