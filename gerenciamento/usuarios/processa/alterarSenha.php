<?php
if (empty($_POST['id']) || empty($_POST['senha'])) {
    echo "<p style='color:red;'>Erro ao gerar nova senha.</p>";
} else {
    $idUsuario = $_POST['id'];
    $senha = $_POST['senha'];
    $senhaMD5 = md5($_POST['senha']);

    require "../../../conexoes/conexao_pdo.php"; // Inclui o arquivo com as credenciais de acesso ao banco

    $sql = "UPDATE usuarios AS u
            SET u.reset_password = '1', u.senha = :senha, u.modificado = NOW()
            WHERE u.id = :idUsuario";

    // Preparação da declaração
    $stmt = $pdo->prepare($sql);

    // Atribuição dos valores aos parâmetros
    $stmt->bindParam(":senha", $senhaMD5);
    $stmt->bindParam(":idUsuario", $idUsuario);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Utilize a senha gerada abaixo para realizar acesso. Ao realizar o acesso, a senha deve ser alterada.
    <br><br>
    <b>Senha: $senha</b></p>";
    } else {
        echo "<p style='color:red;'>Erro ao gerar nova senha.</p>";
    }
}
