<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $chamadoID = $_POST['uploadChamadoID'];
        $targetDirectory = '../../../../uploads/chamados/chamado' . $chamadoID . '/'; // Diretório de destino
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true); // Crie o diretório se não existir
        }

        $uploadedFile = $_FILES['fileInput']; // Arquivo enviado
        $fileName = $uploadedFile['name'];
        $targetPath = $targetDirectory . $fileName; // Caminho completo para o arquivo de destino

        // Verifique se o arquivo é uma imagem, arquivo de texto ou PDF (adapte as verificações de tipo conforme necessário)
        $fileType = pathinfo($targetPath, PATHINFO_EXTENSION);
        $allowedTypes = array('jpg', 'jpeg', 'png', 'txt', 'pdf', 'csv', 'xlsx', 'xls', 'docx');

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
                header("Location: /servicedesk/chamados/visualizar_chamado.php?id=$chamadoID");
                exit;
            } else {
                header("Location: /servicedesk/chamados/visualizar_chamado.php?id=$chamadoID");
                exit;            }
        } else {
            header("Location: /servicedesk/chamados/visualizar_chamado.php?id=$chamadoID");
            exit;        }
    }
}
