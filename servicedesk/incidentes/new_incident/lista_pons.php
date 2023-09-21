<?php
require "../../../conexoes/conexao_pdo.php";

if (isset($_POST['olt_id'])) {
    $olt_id = $_POST['olt_id'];

    $query_pons = "SELECT
        gpp.id as id,
        gpp.slot as slot,
        gpp.pon as pon
        FROM gpon_pon as gpp
        LEFT JOIN gpon_olts as gpo ON gpo.id = gpp.olt_id
        WHERE gpp.active = 1 AND gpo.equipamento_id = :olt_id
        ORDER BY gpp.slot ASC, gpp.pon ASC";

    try {
        $stmt_pons = $pdo->prepare($query_pons);
        $stmt_pons->bindParam(':olt_id', $olt_id, PDO::PARAM_INT);
        $stmt_pons->execute();
        $pons = $stmt_pons->fetchAll(PDO::FETCH_ASSOC);

        // Construa a lista de PONs em formato HTML
        $ponsListHTML = '<label class="form-label">Selecione PON</label>';
        $ponsListHTML .= '<select class="form-select" id="pons" name="pons">';
        $ponsListHTML .= '<option value="" disabled selected>Selecione...</option>';

        foreach ($pons as $pon) {
            $ponsListHTML .= '<option value="' . $pon['id'] . '">SLOT ' . $pon['slot'] . ' - PON ' . $pon['pon'] . '</option>';
        }

        $ponsListHTML .= '</select>';

        echo $ponsListHTML;
    } catch (PDOException $e) {
        echo "Erro na consulta SQL: " . $e->getMessage();
    }
} else {
    echo "Nenhuma OLT selecionada";
}
