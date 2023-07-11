<?php

// Verifica se a requisição é um POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtém os dados brutos do corpo da requisição
  $json = file_get_contents('php://input');
  
  // Decodifica o JSON em um objeto PHP
  $data = json_decode($json);

  // Verifica se a propriedade "imageUrl" existe no objeto
  if (isset($data->imageUrl)) {
    $imageUrl = $data->imageUrl;

    // Remove a barra extra no final do diretório
    $imageUrl = rtrim($imageUrl, '/');

    // Verifica se o arquivo existe
    if (file_exists($imageUrl)) {
      // Tenta excluir o arquivo
      if (unlink($imageUrl)) {
        // Exclusão bem-sucedida
        echo json_encode(['success' => true]);
        exit;
      } else {
        // Falha na exclusão
        echo json_encode(['success' => false, 'error' => 'Failed to delete the image']);
        exit;
      }
    } else {
      // Arquivo não encontrado
      echo json_encode(['success' => false, 'error' => 'Image not found']);
      exit;
    }
  }
}

// Se o fluxo de execução chegar aqui, significa que ocorreu um erro ou a requisição não é um POST válido
echo json_encode(['success' => false, 'error' => 'Invalid request']);
exit;
?>
