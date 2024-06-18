<?php
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$categoria_id = $_GET['categoria_id'];

$subcategorias_query = "SELECT id, descricao FROM qt_subcategoria WHERE id_categoria = :categoria_id AND active = 1";
$stmt_subcategorias = $pdo->prepare($subcategorias_query);
$stmt_subcategorias->bindValue(':categoria_id', $categoria_id, PDO::PARAM_INT);
$stmt_subcategorias->execute();
$subcategorias = $stmt_subcategorias->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($subcategorias);
?>
