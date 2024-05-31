<?php
session_start();
if (isset($_SESSION['id'])) {

    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Obter os dados do formulário
        $id_cto = $_POST['id_cto'];
        $caixa = $_POST['caixa'];
        $nbintegration = $_POST['nbintegration'];
        $codigoIntegracao = $_POST['codigoIntegracao'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];

        try {
            // Preparar a consulta de atualização
            $atualiza_cto = "UPDATE gpon_ctos SET 
            title = :caixa,
            nbintegration_code = :nbintegration,
            paintegration_code = :codigoIntegracao,
            lat = :latitude,
            lng = :longitude
            WHERE id = :id_cto";

            $stmt = $pdo->prepare($atualiza_cto);

            // Vincular os parâmetros
            $stmt->bindParam(':caixa', $caixa, PDO::PARAM_STR);
            $stmt->bindParam(':nbintegration', $nbintegration, PDO::PARAM_STR);
            $stmt->bindParam(':codigoIntegracao', $codigoIntegracao, PDO::PARAM_STR);
            $stmt->bindParam(':latitude', $latitude, PDO::PARAM_STR);
            $stmt->bindParam(':longitude', $longitude, PDO::PARAM_STR);
            $stmt->bindParam(':id_cto', $id_cto, PDO::PARAM_INT);

            // Executar a consulta
            if ($stmt->execute()) {
                header("Location: /rede/ctos/visualizar_cto.php?id=$id_cto");
                exit();
            } else {
                header("Location: /rede/ctos/visualizar_cto.php?id=$id_cto");
                exit();
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    } else {
        echo "Método de requisição inválido.";
    }
} else {
    header("Location: /index.php");
    exit();
}
