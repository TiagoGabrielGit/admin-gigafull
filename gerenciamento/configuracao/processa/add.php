<?php
require "../../../conexoes/conexao_pdo.php";

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verifica se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtém os valores dos campos do formulário
        $servidor = $_POST["adicionarServidor"];
        $nomeRemetente = $_POST["adicionarNomeRemetente"];
        $contaEnvio = $_POST["adicionarContaEnvio"];
        $senha = $_POST["adicionarSenha"];
        $ServidorSMTP = $_POST["adicionarServidorSMTP"];
        $portaSmtp = $_POST["adicionarPortaSMTP"];
        $segurancaSmtp = $_POST["adicionarSegurancaSMTP"];

        // Verifica se todos os campos foram preenchidos
        if (!empty($servidor) && !empty($nomeRemetente) && !empty($contaEnvio) && !empty($senha) && !empty($ServidorSMTP) && !empty($portaSmtp) && !empty($segurancaSmtp)) {

            $stmt = $pdo->prepare("INSERT INTO servermail (server, remetente, host, user, password, port, authentication, active)
                                    VALUES (:server, :remetente, :host, :user, :password, :port, :authentication, '1')");

            // Executa a instrução SQL com os valores dos campos do formulário
            $stmt->bindParam(":server", $servidor);
            $stmt->bindParam(":remetente", $nomeRemetente);
            $stmt->bindParam(":host", $ServidorSMTP);
            $stmt->bindParam(":user", $contaEnvio);
            $stmt->bindParam(":password", $senha);
            $stmt->bindParam(":port", $portaSmtp);
            $stmt->bindParam(":authentication", $segurancaSmtp);

            if ($stmt->execute()) {
                echo "<p style='color:green;'>Dados salvos com sucesso.</p>";
            } else {
                echo "<p style='color:red;'>Error: Não foi possível salvar.</p>";
            }
        } else {
            echo "<p style='color:red;'>Error: Por favor, preencha todos os campos do formulário.</p>";
        }
    }
} catch (PDOException $e) {
    echo "<p style='color:red;'>Error: Erro na conexão com o banco de dados: </p>" . $e->getMessage();
}

$pdo = null;
?>
