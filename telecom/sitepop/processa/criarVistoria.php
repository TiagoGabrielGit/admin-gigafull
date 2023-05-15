<?php
require "../../../conexoes/conexao_pdo.php";


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
    } else {
        $cont_insert = false;
    }

    if ($cont_insert) {
        echo "<p style='color:green;'>Vistoria cadastrada!</p>";
    } else {
        echo "<p style='color:red;'>Erro ao cadastrar vistoria</p>";
    }
}
