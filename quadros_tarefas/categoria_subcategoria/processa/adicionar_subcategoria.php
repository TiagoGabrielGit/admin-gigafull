<?php
session_start();

// Verificando se o usuário está logado
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    // Checando se o método da requisição é POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificando se os campos foram enviados e não estão vazios
        if (
            isset($_POST['categoria_id']) && !empty($_POST['categoria_id']) &&
            isset($_POST['subcategoria']) && !empty($_POST['subcategoria'])
        ) {

            $categoria_id = $_POST['categoria_id'];
            $subcategoria = $_POST['subcategoria'];

            try {
                // Preparando a instrução SQL para evitar SQL Injection
                $stmt = $pdo->prepare("INSERT INTO qt_subcategoria (id_categoria, descricao, active) VALUES (:categoria_id, :subcategoria, 1)");
                // Associando os valores aos parâmetros
                $stmt->bindValue(':categoria_id', $categoria_id, PDO::PARAM_INT);
                $stmt->bindValue(':subcategoria', $subcategoria, PDO::PARAM_STR);

                // Executando a instrução SQL
                if ($stmt->execute()) {
                    // Redirecionando para a página desejada após sucesso
                    header("Location: /quadros_tarefas/categoria_subcategoria/index.php");
                    exit();
                } else {
                    echo "Erro ao adicionar subcategoria.";
                }
            } catch (PDOException $e) {
                // Tratando erros de execução do PDO
                echo "Erro ao adicionar subcategoria: " . $e->getMessage();
            }
        } else {
            // Redirecionando se os campos obrigatórios não estiverem preenchidos
            header("Location: /quadros_tarefas/categoria_subcategoria/index.php");
            exit();
        }
    }
} else {
    // Redirecionando para a página de login se o usuário não estiver logado
    header("Location: /index.php");
    exit();
}
