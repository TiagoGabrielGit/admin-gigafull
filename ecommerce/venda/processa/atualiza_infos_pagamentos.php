<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../conexoes/conexao_pdo.php";

        // Recupere os dados do formulário
        $pedido_id = $_POST['id_pedido_infs_pgto'];
        $tipo_pagamento = $_POST['tipo_pagamento'];
        $parcelamento = $_POST['parcelamento'];
        $valor_desconto = $_POST['valor_desconto'];
        $mao_de_obra = $_POST['mao_de_obra'];

        // Crie a consulta SQL para atualizar os dados na tabela ecommerce_pedido
        $sql = "UPDATE ecommerce_pedido SET ";
        $params = array();

        if (!empty($tipo_pagamento) || !empty($parcelamento) || !empty($valor_desconto) || !empty($mao_de_obra)) {


            // Adicione apenas os campos que têm valor
            if (!empty($tipo_pagamento)) {
                $sql .= "tipo_pagamento = :tipo_pagamento, ";
                $params[':tipo_pagamento'] = $tipo_pagamento;
            }
            if (!empty($parcelamento)) {
                $sql .= "parcelamento = :parcelamento, ";
                $params[':parcelamento'] = $parcelamento;
            }
            if (!empty($valor_desconto)) {
                $sql .= "valor_desconto = :valor_desconto, ";
                $params[':valor_desconto'] = $valor_desconto;
            }
            if (!empty($mao_de_obra)) {
                $sql .= "mao_de_obra = :mao_de_obra, ";
                $params[':mao_de_obra'] = $mao_de_obra;
            }

            // Remova a vírgula extra no final da string SQL
            $sql = rtrim($sql, ', ');

            // Adicione a condição WHERE para o pedido_id
            $sql .= " WHERE id = :pedido_id";

            // Prepare a consulta
            $stmt = $pdo->prepare($sql);

            // Bind os parâmetros
            foreach ($params as $key => &$value) {
                $stmt->bindParam($key, $value);
            }
            $stmt->bindParam(':pedido_id', $pedido_id);

            // Execute a consulta
            if ($stmt->execute()) {
                header("Location: /ecommerce/venda/pedido.php?pedido_id=$pedido_id");
                exit();
            } else {
                header("Location: /ecommerce/venda/pedido.php?pedido_id=$pedido_id");
                exit();
            }
        } else {
            header("Location: /ecommerce/venda/pedido.php?pedido_id=$pedido_id");
            exit();
        }
    } else {
        header("Location: /ecommerce/venda/pedido.php?pedido_id=$pedido_id");
        exit();
    }
}
