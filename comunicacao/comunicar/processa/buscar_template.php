<?php
require "../../../conexoes/conexao.php";
if (isset($_POST['templateId'])) {
    $templateId = $_POST['templateId'];

    // Execute uma consulta SQL para buscar o conteúdo do template com base no ID
    $sql = "SELECT template, titulo FROM comunicacao_templates WHERE id = $templateId";
    $result = mysqli_query($mysqli, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        // Retorna os dados como JSON
        echo json_encode($row);
    } else {
        echo "Erro ao buscar o template.";
    }
} else {
    echo "ID do template não foi fornecido.";
}
