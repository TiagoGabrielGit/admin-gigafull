<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["novo_quadro"]) && !empty($_POST["novo_quadro"])) {
            // Inclua o arquivo de conexão com o banco de dados
            require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

            // Obtém o título do novo quadro do formulário
            $titulo = $_POST["novo_quadro"];

            // Prepara e executa a consulta SQL para inserir o novo quadro no banco de dados
            $stmt = $pdo->prepare("INSERT INTO quadros (titulo, status) VALUES (:titulo, 1)");
            $stmt->execute(['titulo' => $titulo]);

            // Redireciona de volta para a página principal após adicionar o novo quadro
            header("Location: index.php");
            exit();
        } else {
            // Se o campo estiver vazio, exibe uma mensagem de erro
            echo "O campo do novo quadro não pode estar vazio!";
        }
    } else {
        // Se o formulário não foi submetido via POST, redireciona de volta para a página principal
        header("Location: index.php");
        exit();
    }
} else {
    // Se o formulário não foi submetido via POST, redireciona de volta para a página principal
    header("Location: index.php");
    exit();
}
