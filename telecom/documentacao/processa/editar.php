<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../conexoes/conexao_pdo.php";

    $idDocument = $_POST['idDocument'];
    $document_content = $_POST['document_content'];

    // Query SQL para atualizar o conteúdo do documento
    $sql = "UPDATE documentation SET document = :content WHERE id = :id";

    // Preparar a consulta
    $stmt = $pdo->prepare($sql);

    // Bind dos parâmetros
    $stmt->bindParam(':content', $document_content);
    $stmt->bindParam(':id', $idDocument);

    // Executar a consulta
    if ($stmt->execute()) {
        echo "Atualização realizada com sucesso.";
    } else {
        echo "Erro ao atualizar o documento.";
    }
}
