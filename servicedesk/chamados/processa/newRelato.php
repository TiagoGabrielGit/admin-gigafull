<?php
session_start();
if (isset($_SESSION['id'])) {

    require "../../../conexoes/conexao.php";
    require "../../../conexoes/conexao_pdo.php";

    if (empty($_POST['privateChamado']) || empty($_POST['chamadoID']) || empty($_POST['relatorID']) || empty($_POST['novoRelato']) || empty($_POST['statusChamado'])) {
        echo "<p style='color:red;'>Error: Dados obrigatórios não preenchidos.</p>";
    } else {
        #Recebe os parametros do relato
        $chamadoID = $_POST['chamadoID'];
        $relatorID = $_POST['relatorID'];
        $novoRelato = $_POST['novoRelato'];
        $statusChamado = $_POST['statusChamado'];
        $private = $_POST['privateChamado'];
        $horaInicial = $_POST['startTime'];
        $relato_hora_final = date("Y-m-d H:i:s");

        $calcula_tempo =
            "SELECT TIMESTAMPDIFF(SECOND, in_execution_start, NOW()) as tempo from chamados where id = $chamadoID";
        $calculo = mysqli_query($mysqli, $calcula_tempo);
        $res_calc = $calculo->fetch_array();
        $seconds_worked = $res_calc['tempo'];

        #Calcula o tempo total de execucao do chamado
        $calcula_segudos =
            "SELECT SUM(seconds_worked) as second from chamado_relato where chamado_id = $chamadoID";
        $calc_sec = mysqli_query($mysqli, $calcula_segudos);
        $res_sec = $calc_sec->fetch_array();
        $seconds = $res_sec['second'];
        $total_seconds_worked = ($seconds_worked + $seconds);

        #Prepara a a insercao do relato no chamado
        $sql1 = "INSERT INTO chamado_relato (chamado_id, relator_id, relato, relato_hora_inicial, relato_hora_final, seconds_worked, private)
            VALUES (:chamado_id, :relator_id, :relato, :relato_hora_inicial, :relato_hora_final, :seconds_worked, :private)";
        $stmt1 = $pdo->prepare($sql1);
        $stmt1->bindParam(':chamado_id', $chamadoID);
        $stmt1->bindParam(':private', $private);
        $stmt1->bindParam(':relator_id', $relatorID);
        $stmt1->bindParam(':relato_hora_inicial', $horaInicial);
        $stmt1->bindParam(':relato_hora_final', $relato_hora_final);
        $stmt1->bindParam(':relato', $novoRelato);
        $stmt1->bindParam(':seconds_worked', $seconds_worked);

        #Seleciona onde vai ser inserido de acordo com IF
        if ($statusChamado == 3) {
            $data = [
                'seconds_worked' => $total_seconds_worked,
                'status_id' => $_POST['statusChamado'],
                'in_execution' => 0,
                'in_execution_atd_id' => 0,
            ];

            $sql2 = "UPDATE chamados SET seconds_worked=:seconds_worked, status_id=:status_id, in_execution=:in_execution, in_execution_atd_id=:in_execution_atd_id, in_execution_start=NULL, data_fechamento=NOW(), prioridade=NULL WHERE id=$chamadoID";
            $stmt2 = $pdo->prepare($sql2);
            if (isset($_POST['chamadoPrioridade'])) {
                $prioridade_alvo = $_POST['chamadoPrioridade'];

                $sql_update_prioridade = "UPDATE chamados SET prioridade = prioridade - 1 WHERE prioridade > $prioridade_alvo";
                $stmt_prioridade = $pdo->prepare($sql_update_prioridade);
                $stmt_prioridade->execute();
            }
        } else {
            $data = [
                'seconds_worked' => $total_seconds_worked,
                'status_id' => $_POST['statusChamado'],
                'in_execution' => 0,
                'in_execution_atd_id' => 0,
            ];

            $sql2 = "UPDATE chamados SET seconds_worked=:seconds_worked, status_id=:status_id, in_execution=:in_execution, in_execution_atd_id=:in_execution_atd_id, in_execution_start=NULL WHERE id=$chamadoID";
            $stmt2 = $pdo->prepare($sql2);
        }

        if ($stmt1->execute() && $stmt2->execute($data)) {
            echo "<p style='color:green;'>Success: Relato salvo com sucesso.</p>";
        } else {
            echo "<p style='color:red;'>Error: Erro ao salvar.</p>";
        }
    }
} else {
    header("Location: /index.php");
    exit();
}
