<?php
require "../../../conexoes/conexao.php";
require "../../../conexoes/conexao_pdo.php";

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (empty($_POST['nomeUsuario']) || empty($_POST['tipoAcesso']) || empty($_POST["empresaSelect"])) {
        // Mensagem de erro
        echo "<p style='color:red;'>Error 1: Por favor, preencha todos os campos obrigatórios.</p>";
    } else {
        $tipoAcesso = $_POST['tipoAcesso'];
        if ($tipoAcesso == "1" && empty($_POST["perfil"])) {
            echo "<p style='color:red;'>Error 2: Por favor, preencha todos os campos obrigatórios.</p>";
        } else {


            // Obtém os dados enviados pelo formulário
            $pessoaID = $_POST['nomeUsuario'];
            $empresaID = $_POST["empresaSelect"];
            $permissaoAberturaChamado = $_POST["permissaoAberturaChamado"];
            $permissaoVisualizaChamado = isset($_POST["permissaoVisualizaChamado"]) ? $_POST["permissaoVisualizaChamado"] : 0;
            $perfil = isset($_POST["perfil"]) ? $_POST["perfil"] : 0;
            $password = md5($_POST["senha"]);
            $senha = $_POST["senha"];


            // Todos os campos estão preenchidos, continue com a lógica de salvamento no banco de dados
            $insert_usuario =
                "INSERT INTO usuarios (permissao_chamado, permissao_visualiza_chamado, pessoa_id, senha, criado, tipo_usuario, empresa_id, perfil_id, reset_password, active, notify_email)
        VALUES (:permissao_chamado, :permissao_visualiza_chamado, :pessoa_id, :senha, NOW(), :tipo_usuario, :empresa_id, :perfil_id, '1', '1', '1')";

            $stmt1 = $pdo->prepare($insert_usuario);

            $stmt1->bindParam(':pessoa_id', $pessoaID);
            $stmt1->bindParam(':senha', $password);
            $stmt1->bindParam(':tipo_usuario', $tipoAcesso);
            $stmt1->bindParam(':empresa_id', $empresaID);
            $stmt1->bindParam(':perfil_id', $perfil);
            $stmt1->bindParam(':permissao_chamado', $permissaoAberturaChamado);
            $stmt1->bindParam(':permissao_visualiza_chamado', $permissaoVisualizaChamado);

            // Executa a consulta
            if ($stmt1->execute()) {
                echo "<p style='color:green;'>Utilize a senha gerada abaixo para realizar acesso. <br> Ao realizar o acesso, a senha deve ser alterada.
                <br><br>
                <b>Senha: $senha</b></p>";
            } else {
                // Ocorreu um erro ao salvar a empresa
                echo "<p style='color:red;'>Error: . $stmt->error</p>";
            }
        }
    }
} else {
    // A requisição não é do tipo POST, redireciona para a página do formulário
    header("Location: /gerenciamento/usuarios/usuarios.php");
    exit();
}
