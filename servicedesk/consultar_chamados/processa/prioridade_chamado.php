<?php
session_start();

if ($_SESSION['id'] && $_SERVER["REQUEST_METHOD"] == "POST") {


    try {
        require "../../../conexoes/conexao_pdo.php";
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Recupera o ID do chamado atual
        $id_chamado = $_POST['conf_id_chamado'];

        // Recupera a nova prioridade selecionada
        $nova_prioridade = $_POST['chamado_prioridade'];

        // Verifica a prioridade atual do chamado
        $sql_prioridade_atual = "SELECT prioridade FROM chamados WHERE id = :id_chamado";
        $stmt_prioridade_atual = $pdo->prepare($sql_prioridade_atual);
        $stmt_prioridade_atual->bindParam(':id_chamado', $id_chamado, PDO::PARAM_INT);
        $stmt_prioridade_atual->execute();
        $prioridade_atual = $stmt_prioridade_atual->fetchColumn();

        // Verifica se a nova prioridade é diferente da prioridade atual do chamado
        if ($nova_prioridade != $prioridade_atual) {

            // Atualiza a prioridade do chamado atual
            $sql_atualiza_prioridade = "UPDATE chamados SET prioridade = :nova_prioridade WHERE id = :id_chamado";
            $stmt_atualiza_prioridade = $pdo->prepare($sql_atualiza_prioridade);
            $stmt_atualiza_prioridade->bindParam(':nova_prioridade', $nova_prioridade, PDO::PARAM_INT);
            $stmt_atualiza_prioridade->bindParam(':id_chamado', $id_chamado, PDO::PARAM_INT);
            $stmt_atualiza_prioridade->execute();

            if ($nova_prioridade > $prioridade_atual) {
                // A nova prioridade é maior que a anterior, diminuir as prioridades dos chamados entre a prioridade atual e a nova prioridade
                $sql_atualiza_demais_prioridades = "UPDATE chamados SET prioridade = prioridade - 1 WHERE prioridade BETWEEN :prioridade_atual AND :nova_prioridade AND id <> :id_chamado";
            } else {
                // A nova prioridade é menor que a anterior, aumentar as prioridades dos chamados entre a nova prioridade e a prioridade atual
                $sql_atualiza_demais_prioridades = "UPDATE chamados SET prioridade = prioridade + 1 WHERE prioridade BETWEEN :nova_prioridade AND :prioridade_atual AND id <> :id_chamado";
            }

            $stmt_atualiza_demais_prioridades = $pdo->prepare($sql_atualiza_demais_prioridades);
            $stmt_atualiza_demais_prioridades->bindParam(':nova_prioridade', $nova_prioridade, PDO::PARAM_INT);
            $stmt_atualiza_demais_prioridades->bindParam(':prioridade_atual', $prioridade_atual, PDO::PARAM_INT);
            $stmt_atualiza_demais_prioridades->bindParam(':id_chamado', $id_chamado, PDO::PARAM_INT);
            $stmt_atualiza_demais_prioridades->execute();
        }

        // Redireciona para a página anterior ou outra página de sua escolha após a atualização.
        header("Location: /servicedesk/consultar_chamados/view.php?id=$id_chamado");
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
