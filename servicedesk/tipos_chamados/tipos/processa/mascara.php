<?php
session_start();

if (isset($_SESSION['id'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['id_mascara'])) {

            $id_tipo_chamado = $_POST['id_mascara'];

            if (isset($_POST['mascara'])) {
                require "../../../../conexoes/conexao_pdo.php";

                $mascara = $_POST['mascara'];


                try {

                    // Prepara a consulta SQL para atualizar a coluna 'mascara' na tabela 'tipos_chamados'
                    $stmt = $pdo->prepare("UPDATE tipos_chamados SET mascara = :mascara WHERE id = :id");

                    // Bind dos parâmetros
                    $stmt->bindParam(':id', $id_tipo_chamado);
                    $stmt->bindParam(':mascara', $mascara);

                    // Executa a consulta
                    $stmt->execute();

                    // Redireciona o usuário de volta para a página anterior
                    header("Location: {$_SERVER['HTTP_REFERER']}");
                    exit; // Termina o script
                } catch (PDOException $e) {
                    echo "Erro: " . $e->getMessage();
                }
            } else {
                echo "A máscara não foi enviada.";
            }
        } else {
            echo "O ID da máscara não foi enviado.";
        }
    } else {
        echo "Este arquivo deve ser acessado via método POST.";
    }
} else {
    header('Location: /index.php');
    exit();
}
