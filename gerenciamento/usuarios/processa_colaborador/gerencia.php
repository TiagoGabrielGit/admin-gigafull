<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../conexoes/conexao_pdo.php";
    $user_id = $_POST['user_id_gerencia'];

    // Verifica se já existe um registro para o $user_id na tabela colaborador_horario
    $sqlExists = "SELECT * FROM colaborador_gerencia WHERE user_id = :user_id";
    $stmtExists = $pdo->prepare($sqlExists);
    $stmtExists->execute(['user_id' => $user_id]);

    // Verifica se já existe um registro com o $user_id
    if ($stmtExists->rowCount() > 0) {
        // Atualiza o registro existente na tabela colaborador_horario
        $sqlUpdate = "UPDATE colaborador_gerencia SET 
                        gerente_id = :gerente_id,
                        coordenador_id = :coordenador_id
                        WHERE user_id = :user_id";

        // Prepara a declaração PDO para atualização
        $stmtUpdate = $pdo->prepare($sqlUpdate);

        // Obtém os valores dos campos enviados pelo formulário
        $gerente = isset($_POST['gerente']) ? $_POST['gerente'] : null;
        $coordenador = isset($_POST['coordenador']) ? $_POST['coordenador'] : null;

        $stmtUpdate->bindParam(':user_id', $user_id);
        $stmtUpdate->bindParam(':gerente_id', $gerente);
        $stmtUpdate->bindParam(':coordenador_id', $coordenador);

        if ($stmtUpdate->execute()) {
            echo "Atualizado com sucesso!";
        } else {
            echo "Erro: Falha ao atualizar!";
        }
    } else {
        $gerente = isset($_POST['gerente']) ? $_POST['gerente'] : null;
        $coordenador = isset($_POST['coordenador']) ? $_POST['coordenador'] : null;

        $sql = "INSERT INTO colaborador_gerencia (user_id, gerente_id, coordenador_id) VALUES (:user_id, :gerente_id, :coordenador_id)";

        // Prepara a declaração PDO
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':gerente_id', $gerente);
        $stmt->bindParam(':coordenador_id', $coordenador);

        if ($stmt->execute()) {
            echo "Salvo com sucesso!";
        } else {
            echo "Error: Falha ao salvar!";
        }
    }
}
