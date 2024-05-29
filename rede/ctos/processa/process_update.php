<?php
require "../../../conexoes/conexao_pdo.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ids = $_POST['ids'];
    $codigoIntegracao = $_POST['codigoIntegracao'];

    foreach ($ids as $id) {
        if (isset($codigoIntegracao[$id])) {
            $update_query = "UPDATE gpon_ctos SET paintegration_code = :codigoIntegracao WHERE id = :id";
            $stmt = $pdo->prepare($update_query);
            $stmt->bindParam(':codigoIntegracao', $codigoIntegracao[$id], PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
    }
    // Redirecionar de volta para a página principal ou exibir uma mensagem de sucesso
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
