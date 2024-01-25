<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../conexoes/conexao_pdo.php";

        $pedido_id = $_POST["atualiza_pedido_id"];
        $dataPedido = $_POST["data_pedido"];
        $statusPedido = $_POST["status_pedido"];
        $dataEntrega = $_POST["data_entrega"];
        $archived = isset($_POST["archived"]) ? 1 : 0;
        $information = $_POST["information"];


        $stmt = $pdo->prepare("UPDATE ecommerce_pedido SET information = :information, archived = :archived, date = :dataPedido, status = :statusPedido, date_entrega = :dataEntrega WHERE id = :pedidoId");

        $stmt->bindParam(':dataPedido', $dataPedido);
        $stmt->bindParam(':statusPedido', $statusPedido);
        $stmt->bindParam(':dataEntrega', $dataEntrega);
        $stmt->bindParam(':pedidoId', $pedido_id);
        $stmt->bindParam(':archived', $archived);
        $stmt->bindParam(':information', $information);


        $stmt->execute();

        header("Location: /ecommerce/venda/pedido.php?pedido_id=$pedido_id");
        exit();
    } else {
        header("Location: /ecommerce/venda/pedido.php?pedido_id=$pedido_id");
        exit();
    }
}
