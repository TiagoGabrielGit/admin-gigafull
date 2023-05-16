<?php
require "../../../conexoes/conexao_pdo.php";

$qtdeEquipamentos = $_POST['qtdeEquipamentos'];

if (
    empty($_POST['idPOPVistoria']) || empty($_POST['dataVistoria']) || empty($_POST['responsavelVistoria']) || empty($_POST['limpezaPOP']) ||
    empty($_POST['organizacaoPOP']) || empty($_POST['observacoesGerais'])
) {
    echo "<p style='color:red;'>Campos obrigatórios não preenchidos</p>";
} else {

    $pop_id = $_POST['idPOPVistoria'];
    $dataVistoria = $_POST['dataVistoria'];
    $responsavelVistoria = $_POST['responsavelVistoria'];
    $limpezaPOP = $_POST['limpezaPOP'];
    $organizacaoPOP = $_POST['organizacaoPOP'];
    $observacoesGerais = $_POST['observacoesGerais'];

    $cont_insert = false;

    $sql = "INSERT INTO vistoria (pop_id, responsavel_id, limpeza, organizacao, obs_geral, date)
            VALUES (:pop_id, :responsavel_id, :limpeza, :organizacao, :obs_geral, :date)";
    $stmt1 = $pdo->prepare($sql);
    $stmt1->bindParam(':pop_id', $pop_id);
    $stmt1->bindParam(':responsavel_id', $responsavelVistoria);
    $stmt1->bindParam(':limpeza', $limpezaPOP);
    $stmt1->bindParam(':organizacao', $organizacaoPOP);
    $stmt1->bindParam(':obs_geral', $observacoesGerais);
    $stmt1->bindParam(':date', $dataVistoria);

    if ($stmt1->execute()) {
        $cont_insert = true;
        $vistoria_id = $pdo->lastInsertId();

        if ($qtdeEquipamentos > 0) {
            for ($i = 1; $i < $qtdeEquipamentos; $i++) {
                $equipamento_id = $_POST['equipamento_id' . $i];
                $energiaEquipamento = $_POST['energiaEquipamento' . $i];
                $limpezaAdequada = $_POST['limpezaAdequada' . $i];
                $detalhesFonte = $_POST['detalhesFonte' . $i];
                $observacaoEquipamento = $_POST['observacaoEquipamento' . $i];

                // Preparar declaração SQL para o item atual
                $sqlItem = "INSERT INTO vistoria_equipamento (vistoria_id, equipamento_id, energia, limpeza, detalhes_fonte, observacao) 
        VALUES (:vistoria_id, :equipamento_id, :energia, :limpeza, :detalhes_fonte, :observacao)";
                $stmtItem = $pdo->prepare($sqlItem);
                $stmtItem->bindParam(':vistoria_id', $vistoria_id);
                $stmtItem->bindParam(':equipamento_id', $equipamento_id);
                $stmtItem->bindParam(':energia', $energiaEquipamento);
                $stmtItem->bindParam(':limpeza', $limpezaAdequada);
                $stmtItem->bindParam(':detalhes_fonte', $detalhesFonte);
                $stmtItem->bindParam(':observacao', $observacaoEquipamento);

                if ($stmtItem->execute()) {
                    $insert_Equipamento = true;
                } else {
                    $insert_Equipamento = false;
                    break; // Se ocorrer um erro, interrompe o loop
                }
            }
        } else {
            $insert_Equipamento = true;
        }
    } else {
        $cont_insert = false;
    }

    if ($cont_insert && $insert_Equipamento) {
        echo "<p style='color:green;'>Vistoria cadastrada!</p>";
    } else {
        echo "<p style='color:red;'>Erro ao cadastrar vistoria</p>";
    }
}
