<?php
session_start();

if (isset($_SESSION['id'])) {
    require "../../../conexoes/conexao_pdo.php";
    require "../../../conexoes/conexao_voalle.php";

    // Recupere os dados das caixas do banco de dados Voalle
    $query_ctos =
        "SELECT asp.id as id, asp.title as title, asp.lat as lat, asp.lng as lng, aap.title as patitle, aap.integration_code as paintegration_code, nb.integration_code as nbintegration_code
    FROM authentication_splitters as ASP
    JOIN authentication_access_points as AAP ON AAP.id = ASP.authentication_access_point_id
    JOIN network_boxes as nb ON nb.id = asp.network_box_id

    WHERE asp.type = 1 AND asp.deleted = false
    ORDER BY asp.title ASC";

    $stmt = $pgsql_pdo->query($query_ctos);
    $caixas_voalle = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Iterar sobre as caixas do Voalle
    foreach ($caixas_voalle as $caixa_voalle) {
        // Verifique se a caixa já existe no seu banco de dados
        $id_caixa_voalle = $caixa_voalle['id'];
        $query_verificacao = "SELECT id, title, lat, lng, patitle, paintegration_code, nbintegration_code FROM gpon_ctos WHERE id = :id_caixa_voalle";
        $stmt = $pdo->prepare($query_verificacao); // Use a conexão do seu sistema
        $stmt->bindParam(":id_caixa_voalle", $id_caixa_voalle);
        $stmt->execute();
        $caixa_existente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($caixa_existente) {
            if (
                $caixa_existente['title'] != $caixa_voalle['title'] ||
                $caixa_existente['lat'] != $caixa_voalle['lat'] ||
                $caixa_existente['lng'] != $caixa_voalle['lng'] ||
                $caixa_existente['patitle'] != $caixa_voalle['patitle'] ||
                $caixa_existente['paintegration_code'] != $caixa_voalle['paintegration_code'] ||
                $caixa_existente['nbintegration_code'] != $caixa_voalle['nbintegration_code']
            ) {
                // Algum campo foi alterado, execute a atualização
                $query_atualizacao = "UPDATE gpon_ctos SET
                title = :title,
                lat = :lat,
                lng = :lng,
                patitle = :patitle,
                paintegration_code = :paintegration_code,
                nbintegration_code = :nbintegration_code
                WHERE id = :id_caixa_voalle";

                $stmt = $pdo->prepare($query_atualizacao); // Use a conexão do seu sistema
                $stmt->bindParam(":title", $caixa_voalle['title']);
                $stmt->bindParam(":lat", $caixa_voalle['lat']);
                $stmt->bindParam(":lng", $caixa_voalle['lng']);
                $stmt->bindParam(":patitle", $caixa_voalle['patitle']);
                $stmt->bindParam(":paintegration_code", $caixa_voalle['paintegration_code']);
                $stmt->bindParam(":nbintegration_code", $caixa_voalle['nbintegration_code']);
                $stmt->bindParam(":id_caixa_voalle", $id_caixa_voalle);
                $stmt->execute();
            }
        } else {
            // A caixa não existe, insira-a
            $query_insercao = "INSERT INTO gpon_ctos (id, title, lat, lng, patitle, paintegration_code, nbintegration_code)
            VALUES (:id, :title, :lat, :lng, :patitle, :paintegration_code, :nbintegration_code)";

            $stmt = $pdo->prepare($query_insercao); // Use a conexão do seu sistema
            $stmt->bindParam(":id", $caixa_voalle['id']);
            $stmt->bindParam(":title", $caixa_voalle['title']);
            $stmt->bindParam(":lat", $caixa_voalle['lat']);
            $stmt->bindParam(":lng", $caixa_voalle['lng']);
            $stmt->bindParam(":patitle", $caixa_voalle['patitle']);
            $stmt->bindParam(":paintegration_code", $caixa_voalle['paintegration_code']);
            $stmt->bindParam(":nbintegration_code", $caixa_voalle['nbintegration_code']);
            $stmt->execute();
        }
    }

    // Responda com uma mensagem indicando o término da importação
    echo "Importação concluída.";
} else {
    echo "Usuário não autenticado";
}
