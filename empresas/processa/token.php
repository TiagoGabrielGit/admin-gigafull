<?php
session_start();
if (isset($_SESSION['id'])) {
    require "../../conexoes/conexao_pdo.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_empresa = $_POST['id_empresa_token'];

        // Função para gerar um token aleatório de 20 caracteres
        function gerarToken($length = 30)
        {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        $novo_token = gerarToken(); // Gera um novo token

        // Conexão com o banco de dados (ajuste com suas credenciais)
        // Atualiza o token da empresa no banco de dados
        $stmt = $pdo->prepare("UPDATE empresas SET token = :token WHERE id = :id_empresa");
        $stmt->execute([':token' => $novo_token, ':id_empresa' => $id_empresa]);

        // Redireciona para a página original ou exibe uma mensagem de sucesso
        header('Location: /empresas/view.php?id=' . $id_empresa);
        exit();
    }
} else {
    header("Location: /index.php");
}
