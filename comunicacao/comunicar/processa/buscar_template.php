<?php
require "../../../conexoes/conexao.php";

if (isset($_POST['templateId'])) {
    $templateId = $_POST['templateId'];

    // Execute uma consulta SQL para buscar o conteúdo do template com base no ID
    $sql = "SELECT template FROM comunicacao_templates WHERE id = $templateId";
    $result = mysqli_query($mysqli, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        // Retorna apenas o conteúdo do template (HTML)
        echo $row['template'];
    } else {
        echo "Erro ao buscar o template.";
    }
} else {
    echo "ID do template não foi fornecido.";
}
?>
