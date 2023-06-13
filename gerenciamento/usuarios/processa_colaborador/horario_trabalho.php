<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../conexoes/conexao_pdo.php";
    $user_id = $_POST['user_id'];

    // Verifica se já existe um registro para o $user_id na tabela colaborador_horario
    $sqlExists = "SELECT * FROM colaborador_horario WHERE user_id = :user_id";
    $stmtExists = $pdo->prepare($sqlExists);
    $stmtExists->execute(['user_id' => $user_id]);

    // Verifica se já existe um registro com o $user_id
    if ($stmtExists->rowCount() > 0) {
        // Atualiza o registro existente na tabela colaborador_horario
        $sqlUpdate = "UPDATE colaborador_horario SET 
    seg_ini_p1 = :seg_inicio_p1,
    seg_fim_p1 = :seg_fim_p1,
    seg_ini_p2 = :seg_inicio_p2,
    seg_fim_p2 = :seg_fim_p2,
    ter_ini_p1 = :ter_inicio_p1,
    ter_fim_p1 = :ter_fim_p1,
    ter_ini_p2 = :ter_inicio_p2,
    ter_fim_p2 = :ter_fim_p2,
    qua_ini_p1 = :qua_inicio_p1,
    qua_fim_p1 = :qua_fim_p1,
    qua_ini_p2 = :qua_inicio_p2,
    qua_fim_p2 = :qua_fim_p2,
    qui_ini_p1 = :qui_inicio_p1,
    qui_fim_p1 = :qui_fim_p1,
    qui_ini_p2 = :qui_inicio_p2,
    qui_fim_p2 = :qui_fim_p2,
    sex_ini_p1 = :sex_inicio_p1,
    sex_fim_p1 = :sex_fim_p1,
    sex_ini_p2 = :sex_inicio_p2,
    sex_fim_p2 = :sex_fim_p2,
    sab_ini_p1 = :sab_inicio_p1,
    sab_fim_p1 = :sab_fim_p1,
    sab_ini_p2 = :sab_inicio_p2,
    sab_fim_p2 = :sab_fim_p2,
    dom_ini_p1 = :dom_inicio_p1,
    dom_fim_p1 = :dom_fim_p1,
    dom_ini_p2 = :dom_inicio_p2,
    dom_fim_p2 = :dom_fim_p2
WHERE user_id = :user_id";

        // Prepara a declaração PDO para atualização
        $stmtUpdate = $pdo->prepare($sqlUpdate);

        // Obtém os valores dos campos enviados pelo formulário
        $seg_inicio_p1 = $_POST['segunda_inicio_p1'];
        $seg_fim_p1 = $_POST['segunda_fim_p1'];
        $seg_inicio_p2 = $_POST['segunda_inicio_p2'];
        $seg_fim_p2 = $_POST['segunda_fim_p2'];

        $ter_inicio_p1 = $_POST['terca_inicio_p1'];
        $ter_fim_p1 = $_POST['terca_fim_p1'];
        $ter_inicio_p2 = $_POST['terca_inicio_p2'];
        $ter_fim_p2 = $_POST['terca_fim_p2'];

        $qua_inicio_p1 = $_POST['quarta_inicio_p1'];
        $qua_fim_p1 = $_POST['quarta_fim_p1'];
        $qua_inicio_p2 = $_POST['quarta_inicio_p2'];
        $qua_fim_p2 = $_POST['quarta_fim_p2'];

        $qui_inicio_p1 = $_POST['quinta_inicio_p1'];
        $qui_fim_p1 = $_POST['quinta_fim_p1'];
        $qui_inicio_p2 = $_POST['quinta_inicio_p2'];
        $qui_fim_p2 = $_POST['quinta_fim_p2'];

        $sex_inicio_p1 = $_POST['sexta_inicio_p1'];
        $sex_fim_p1 = $_POST['sexta_fim_p1'];
        $sex_inicio_p2 = $_POST['sexta_inicio_p2'];
        $sex_fim_p2 = $_POST['sexta_fim_p2'];

        $sab_inicio_p1 = $_POST['sabado_inicio_p1'];
        $sab_fim_p1 = $_POST['sabado_fim_p1'];
        $sab_inicio_p2 = $_POST['sabado_inicio_p2'];
        $sab_fim_p2 = $_POST['sabado_fim_p2'];

        $dom_inicio_p1 = $_POST['domingo_inicio_p1'];
        $dom_fim_p1 = $_POST['domingo_fim_p1'];
        $dom_inicio_p2 = $_POST['domingo_inicio_p2'];
        $dom_fim_p2 = $_POST['domingo_fim_p2'];

        // Atribui os valores como parâmetros para a declaração preparada de atualização
        $stmtUpdate->bindParam(':user_id', $user_id);
        $stmtUpdate->bindParam(':seg_inicio_p1', $seg_inicio_p1);
        $stmtUpdate->bindParam(':seg_fim_p1', $seg_fim_p1);
        $stmtUpdate->bindParam(':seg_inicio_p2', $seg_inicio_p2);
        $stmtUpdate->bindParam(':seg_fim_p2', $seg_fim_p2);

        $stmtUpdate->bindParam(':ter_inicio_p1', $ter_inicio_p1);
        $stmtUpdate->bindParam(':ter_fim_p1', $ter_fim_p1);
        $stmtUpdate->bindParam(':ter_inicio_p2', $ter_inicio_p2);
        $stmtUpdate->bindParam(':ter_fim_p2', $ter_fim_p2);

        $stmtUpdate->bindParam(':qua_inicio_p1', $qua_inicio_p1);
        $stmtUpdate->bindParam(':qua_fim_p1', $qua_fim_p1);
        $stmtUpdate->bindParam(':qua_inicio_p2', $qua_inicio_p2);
        $stmtUpdate->bindParam(':qua_fim_p2', $qua_fim_p2);

        $stmtUpdate->bindParam(':qui_inicio_p1', $qui_inicio_p1);
        $stmtUpdate->bindParam(':qui_fim_p1', $qui_fim_p1);
        $stmtUpdate->bindParam(':qui_inicio_p2', $qui_inicio_p2);
        $stmtUpdate->bindParam(':qui_fim_p2', $qui_fim_p2);

        $stmtUpdate->bindParam(':sex_inicio_p1', $sex_inicio_p1);
        $stmtUpdate->bindParam(':sex_fim_p1', $sex_fim_p1);
        $stmtUpdate->bindParam(':sex_inicio_p2', $sex_inicio_p2);
        $stmtUpdate->bindParam(':sex_fim_p2', $sex_fim_p2);

        $stmtUpdate->bindParam(':sab_inicio_p1', $sab_inicio_p1);
        $stmtUpdate->bindParam(':sab_fim_p1', $sab_fim_p1);
        $stmtUpdate->bindParam(':sab_inicio_p2', $sab_inicio_p2);
        $stmtUpdate->bindParam(':sab_fim_p2', $sab_fim_p2);

        $stmtUpdate->bindParam(':dom_inicio_p1', $dom_inicio_p1);
        $stmtUpdate->bindParam(':dom_fim_p1', $dom_fim_p1);
        $stmtUpdate->bindParam(':dom_inicio_p2', $dom_inicio_p2);
        $stmtUpdate->bindParam(':dom_fim_p2', $dom_fim_p2);

        if ($stmtUpdate->execute()) {
            echo "Atualizado com sucesso!";
        } else {
            echo "Erro: Falha ao atualizar!";
        }
    } else {

        $sql = "INSERT INTO colaborador_horario (user_id, seg_ini_p1, seg_fim_p1, seg_ini_p2, seg_fim_p2,
                                            ter_ini_p1, ter_fim_p1, ter_ini_p2, ter_fim_p2,
                                            qua_ini_p1, qua_fim_p1, qua_ini_p2, qua_fim_p2,
                                            qui_ini_p1, qui_fim_p1, qui_ini_p2, qui_fim_p2,
                                            sex_ini_p1, sex_fim_p1, sex_ini_p2, sex_fim_p2,
                                            sab_ini_p1, sab_fim_p1, sab_ini_p2, sab_fim_p2,
                                            dom_ini_p1, dom_fim_p1, dom_ini_p2, dom_fim_p2) 
                                    VALUES (:user_id, :seg_inicio_p1, :seg_fim_p1, :seg_inicio_p2, :seg_fim_p2,
                                            :ter_inicio_p1, :ter_fim_p1, :ter_inicio_p2, :ter_fim_p2,
                                            :qua_inicio_p1, :qua_fim_p1, :qua_inicio_p2, :qua_fim_p2,
                                            :qui_inicio_p1, :qui_fim_p1, :qui_inicio_p2, :qui_fim_p2,
                                            :sex_inicio_p1, :sex_fim_p1, :sex_inicio_p2, :sex_fim_p2,
                                            :sab_inicio_p1, :sab_fim_p1, :sab_inicio_p2, :sab_fim_p2,
                                            :dom_inicio_p1, :dom_fim_p1, :dom_inicio_p2, :dom_fim_p2)";


        // Prepara a declaração PDO
        $stmt = $pdo->prepare($sql);

        // Obtém os valores dos campos enviados pelo formulário
        $seg_inicio_p1 = $_POST['segunda_inicio_p1'];
        $seg_fim_p1 = $_POST['segunda_fim_p1'];
        $seg_inicio_p2 = $_POST['segunda_inicio_p2'];
        $seg_fim_p2 = $_POST['segunda_fim_p2'];

        $ter_inicio_p1 = $_POST['terca_inicio_p1'];
        $ter_fim_p1 = $_POST['terca_fim_p1'];
        $ter_inicio_p2 = $_POST['terca_inicio_p2'];
        $ter_fim_p2 = $_POST['terca_fim_p2'];

        $qua_inicio_p1 = $_POST['quarta_inicio_p1'];
        $qua_fim_p1 = $_POST['quarta_fim_p1'];
        $qua_inicio_p2 = $_POST['quarta_inicio_p2'];
        $qua_fim_p2 = $_POST['quarta_fim_p2'];

        $qui_inicio_p1 = $_POST['quinta_inicio_p1'];
        $qui_fim_p1 = $_POST['quinta_fim_p1'];
        $qui_inicio_p2 = $_POST['quinta_inicio_p2'];
        $qui_fim_p2 = $_POST['quinta_fim_p2'];

        $sex_inicio_p1 = $_POST['sexta_inicio_p1'];
        $sex_fim_p1 = $_POST['sexta_fim_p1'];
        $sex_inicio_p2 = $_POST['sexta_inicio_p2'];
        $sex_fim_p2 = $_POST['sexta_fim_p2'];

        $sab_inicio_p1 = $_POST['sabado_inicio_p1'];
        $sab_fim_p1 = $_POST['sabado_fim_p1'];
        $sab_inicio_p2 = $_POST['sabado_inicio_p2'];
        $sab_fim_p2 = $_POST['sabado_fim_p2'];

        $dom_inicio_p1 = $_POST['domingo_inicio_p1'];
        $dom_fim_p1 = $_POST['domingo_fim_p1'];
        $dom_inicio_p2 = $_POST['domingo_inicio_p2'];
        $dom_fim_p2 = $_POST['domingo_fim_p2'];

        // Atribui os valores como parâmetros para a declaração preparada
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':seg_inicio_p1', $seg_inicio_p1);
        $stmt->bindParam(':seg_fim_p1', $seg_fim_p1);
        $stmt->bindParam(':seg_inicio_p2', $seg_inicio_p2);
        $stmt->bindParam(':seg_fim_p2', $seg_fim_p2);

        $stmt->bindParam(':ter_inicio_p1', $ter_inicio_p1);
        $stmt->bindParam(':ter_fim_p1', $ter_fim_p1);
        $stmt->bindParam(':ter_inicio_p2', $ter_inicio_p2);
        $stmt->bindParam(':ter_fim_p2', $ter_fim_p2);

        $stmt->bindParam(':qua_inicio_p1', $qua_inicio_p1);
        $stmt->bindParam(':qua_fim_p1', $qua_fim_p1);
        $stmt->bindParam(':qua_inicio_p2', $qua_inicio_p2);
        $stmt->bindParam(':qua_fim_p2', $qua_fim_p2);

        $stmt->bindParam(':qui_inicio_p1', $qui_inicio_p1);
        $stmt->bindParam(':qui_fim_p1', $qui_fim_p1);
        $stmt->bindParam(':qui_inicio_p2', $qui_inicio_p2);
        $stmt->bindParam(':qui_fim_p2', $qui_fim_p2);

        $stmt->bindParam(':sex_inicio_p1', $sex_inicio_p1);
        $stmt->bindParam(':sex_fim_p1', $sex_fim_p1);
        $stmt->bindParam(':sex_inicio_p2', $sex_inicio_p2);
        $stmt->bindParam(':sex_fim_p2', $sex_fim_p2);

        $stmt->bindParam(':sab_inicio_p1', $sab_inicio_p1);
        $stmt->bindParam(':sab_fim_p1', $sab_fim_p1);
        $stmt->bindParam(':sab_inicio_p2', $sab_inicio_p2);
        $stmt->bindParam(':sab_fim_p2', $sab_fim_p2);

        $stmt->bindParam(':dom_inicio_p1', $dom_inicio_p1);
        $stmt->bindParam(':dom_fim_p1', $dom_fim_p1);
        $stmt->bindParam(':dom_inicio_p2', $dom_inicio_p2);
        $stmt->bindParam(':dom_fim_p2', $dom_fim_p2);

        if ($stmt->execute()) {
            echo "Salvo com sucesso!";
        } else {
            echo "Error: Falha ao salvar!";
        }
    }
}
