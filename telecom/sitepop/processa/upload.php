<?php
if (!empty($_FILES['images'])) {
  $popId = $_POST['popId']; // Obtenha o ID do POP


  $targetDirectory = '../../../uploads/pop' . $popId . '/';

  if (!file_exists($targetDirectory)) {
    mkdir($targetDirectory, 0777, true); // Cria o diretório se ele não existir
  }

  $imageCount = count($_FILES['images']['name']);

  for ($i = 0; $i < $imageCount; $i++) {
    $tempFilePath = $_FILES['images']['tmp_name'][$i];
    $caption = $_POST['captions'][$i]; // Legenda da imagem

    $extension = strtolower(pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION));
    $uploadDate = date('dmYHi'); // Obtém a data atual no formato: AnoMêsDiaHoraMinutoSegundo
    //$newFileName = $uploadDate . '_' . $caption . '.' . $extension; // Novo nome do arquivo
    $newFileName =  $caption . '_' . $uploadDate . '.' . $extension; // Novo nome do arquivo
    $targetPath = $targetDirectory . $newFileName;

    if (move_uploaded_file($tempFilePath, $targetPath)) {
      header("location: /telecom/sitepop/view.php?id=$popId&tab=anexo");
      //echo 'Imagem enviada com sucesso: ' . $newFileName . ' (Legenda: ' . $caption . ')<br>';
    } else {
      header("location: /telecom/sitepop/view.php?id=$popId&tab=anexo'");
      //echo 'Erro ao salvar a imagem: ' . $_FILES['images']['name'][$i] . '<br>';
    }
  }
} else {
  header("location: /telecom/sitepop/view.php?id=$popId&tab=anexo");
  //echo 'Nenhuma imagem enviada.';
}
