<?php
ob_start(); // Início do buffer de saída
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: /login.php");
    exit;
}

require "../tcpdf.php";
require "../../conexoes/conexao_pdo.php";

$pedido_id = $_GET['id'];

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT e.fantasia, e.site, e.email, e.cnpj FROM empresas AS e WHERE e.atributoEmpresaPrincipal";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $dados_empresa = $stmt->fetch(PDO::FETCH_ASSOC);
    $fantasia = $dados_empresa['fantasia'];
    $site = $dados_empresa['site'];
    $email = $dados_empresa['email'];
    $cnpj = $dados_empresa['cnpj'];

    $stmt = $pdo->prepare('SELECT ep.mao_de_obra, ep.valor_desconto, ep.tipo_pagamento, DATE_FORMAT(ep.date, "%d/%m/%Y") as date, ep.parcelamento, e.fantasia, e.cnpj, e.email, ca.cep, ca.street, ca.neighborhood, ca.city, ca.state, ca.number, ca.complement
        FROM ecommerce_pedido AS ep
        LEFT JOIN empresas as e ON e.id = ep.cliente_id
        LEFT JOIN company_address as ca ON e.id = ca.company_id
        WHERE ep.id = :id');
    $stmt->bindParam(':id', $pedido_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $date = $row['date'];

    $forma_pagamento = $row['tipo_pagamento'];
    switch ($forma_pagamento) {
        case 1:
            $forma_pagamento = "Boleto";
            break;
        case 2:
            $forma_pagamento = "Cartão de Crédito";
            break;
        case 3:
            $forma_pagamento = "Dinheiro";
            break;
        case 4:
            $forma_pagamento = "PIX";
            break;
        case 5:
            $forma_pagamento = "Transferência";
            break;
        default:
            $forma_pagamento = "Não Definido";
            break;
    }

    $condicao_pagamento = $row['parcelamento'];

    switch ($condicao_pagamento) {
        case 100:
            $condicao_pagamento = "À Vista";
            break;
        case 1:
            $condicao_pagamento = "1x (30 dias)";
            break;
        case 2:
            $condicao_pagamento = "2x (30/60 dias)";
            break;
        case 3:
            $condicao_pagamento = "3x (30/60/90 dias)";
            break;
        case 4:
            $condicao_pagamento = "4x (30/60/90/120 dias)";
            break;
        case 5:
            $condicao_pagamento = "5x (30/60/90/120/150 dias)";
            break;
        case 6:
            $condicao_pagamento = "6x (30/60/90/120/150/180 dias)";
            break;
        case 7:
            $condicao_pagamento = "7x (30/60/90/120/150/180/... dias)";
            break;
        case 8:
            $condicao_pagamento = "8x (30/60/90/120/150/180/... dias)";
            break;
        case 9:
            $condicao_pagamento = "9x (30/60/90/120/150/180/... dias)";
            break;
        case 10:
            $condicao_pagamento = "10x (30/60/90/120/150/180/... dias)";
            break;
        case 11:
            $condicao_pagamento = "11x (30/60/90/120/150/180/... dias)";
            break;
        case 12:
            $condicao_pagamento = "12x (30/60/90/120/150/180/... dias)";
            break;
        default:
            echo "<p style='text-align: right;' class='card-text'>Condição: Não Definido</p>";
            break;
    }

    $fantasia_cliente = $row['fantasia'];
    $cnpj_cliente = $row['cnpj'];
    $email_cliente = $row['email'];
    $cep = $row['cep'];
    $street = $row['street'];
    $neighborhood = $row['neighborhood'];
    $city = $row['city'];
    $state = $row['state'];
    $number = $row['number'];
    $complement = $row['complement'];

    class PedidoPDF extends TCPDF
    {
        public function Header()
        {
        }

        public function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('helvetica', 'I', 8);
            $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }

    $pdf = new PedidoPDF();
    $pdf->AddPage();

    $pdf->Image('../../assets/img/logo.png', 10, 10, 20, 0, 'PNG');

    // Defina os dados da sua empresa na parte superior central
    $pdf->SetFont('helvetica', 'B', 15);
    $pdf->Cell(0, 5, $fantasia, 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 5, $cnpj, 0, 1, 'C');
    $pdf->Cell(0, 5, $site, 0, 1, 'C');
    $pdf->Cell(0, 5, $email, 0, 1, 'C');

    // Adiciona uma linha horizontal após as informações da sua empresa
    $pdf->SetLineWidth(0.2);
    $pdf->Line(10, $pdf->GetY(), $pdf->getPageWidth() - 10, $pdf->GetY());

    $pdf->Ln(2);

    // Adicione as informações do pedido
    $pdf->SetFont('helvetica', '', 10);

    $pdf->Cell(0, 6, 'Cliente: ' . $fantasia_cliente . '                ' . 'CNPJ: ' . $cnpj_cliente, 0, 1, 'L');
    $pdf->Cell(0, 6, 'Endereço: ' . $street . ', ' . $number . ' - ' . $neighborhood . ', ' . $city . ' ' . $state . ' - ' . $cep, 0, 1, 'L');

    // Adicione uma linha em branco
    $pdf->Ln(5);

    $pdf->Cell(0, 5, 'Número Pedido: ' . $pedido_id . '                           ' . 'Data Pedido: ' . $date, 0, 1, 'L');
    $pdf->Cell(0, 5, 'Forma de Pagamento: ' . $forma_pagamento . '                           ' . 'Condição de Pagamento: ' . $condicao_pagamento, 0, 1, 'L');
    $pdf->Ln(2);

    $pdf->SetLineWidth(0.2);
    $pdf->Line(10, $pdf->GetY(), $pdf->getPageWidth() - 10, $pdf->GetY());

    $pdf->Ln(5);

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(15, 8, 'Código', 0, 0, 'C'); // Alterado o estilo da borda para 0
    $pdf->Cell(80, 8, 'Produto', 0, 0, 'C'); // Alterado o estilo da borda para 0
    $pdf->Cell(15, 8, 'QTDE', 0, 0, 'C'); // Alterado o estilo da borda para 0
    $pdf->Cell(40, 8, 'Preço Unitário', 0, 0, 'C'); // Alterado o estilo da borda para 0
    $pdf->Cell(40, 8, 'Total', 0, 1, 'C'); // Alterado o estilo da borda para 0

    $pdf->SetFont('helvetica', '', 10);

    // Consulta para obter os produtos do pedido
    $stmtProdutos = $pdo->prepare('SELECT p.id, p.descricao AS produto_nome, pp.quantidade, pp.valor_unitario, pp.subtotal
    FROM ecommerce_pedido_produto AS pp
    LEFT JOIN ecommerce_produtos AS p ON pp.produto_id = p.id
    WHERE pp.pedido_id = :id');
    $stmtProdutos->bindParam(':id', $pedido_id, PDO::PARAM_INT);
    $stmtProdutos->execute();

    // Loop para adicionar as linhas da tabela de produtos
    while ($produto = $stmtProdutos->fetch(PDO::FETCH_ASSOC)) {
        $valor_unitario = $produto['valor_unitario'];
        $subtotal = $produto['subtotal'];
        $valor_unitario = number_format($valor_unitario, 2, ',', '.');
        $subtotal = number_format($subtotal, 2, ',', '.');

        $pdf->Cell(15, 8, $produto['id'], 0, 0, 'C'); // ID
        $pdf->Cell(80, 8, $produto['produto_nome'], 0, 0); // Produto
        $pdf->Cell(15, 8, $produto['quantidade'], 0, 0, 'C'); // Quantidade
        $pdf->Cell(40, 8, 'R$ ' . $valor_unitario, 0, 0, 'C'); // Preço Unitário
        $pdf->Cell(40, 8, 'R$ ' . $subtotal, 0, 1, 'C'); // Total
    }

    $pdf->Ln(2);

    $pdf->SetLineWidth(0.2);
    $pdf->Line(10, $pdf->GetY(), $pdf->getPageWidth() - 10, $pdf->GetY());

    // Consulta para obter a soma dos subtotais e o valor de desconto
    $stmtSubtotal = $pdo->prepare('SELECT SUM(pp.subtotal) AS total_subtotal
    FROM ecommerce_pedido_produto AS pp 
    LEFT JOIN ecommerce_pedido AS ep ON pp.pedido_id = ep.id
    WHERE pp.pedido_id = :id');
    $stmtSubtotal->bindParam(':id', $pedido_id, PDO::PARAM_INT);
    $stmtSubtotal->execute();
    $result = $stmtSubtotal->fetch(PDO::FETCH_ASSOC);

    $totalSubtotal = $result['total_subtotal'];
    $valorDesconto = $row['valor_desconto'];
    if (is_null($valorDesconto)) {
        $valorDesconto = "0";
        $valorDesconto_formatado = "0,00";
    } else {
        $valorDesconto_formatado = number_format($valorDesconto, 2, ',', '.');
    }

    $mao_de_obra = $row['mao_de_obra'];
    if (is_null($mao_de_obra)) {
        $mao_de_obra = "0";
        $mao_de_obra_formatado = "0,00";
    } else {
        $mao_de_obra_formatado = number_format($mao_de_obra, 2, ',', '.');
    }
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(160, 8, 'Mão de Obra: ', 0, 0, 'R');
    $pdf->Cell(40, 8, 'R$ ' . ($mao_de_obra_formatado), 0, 1, 'C');

    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(160, 8, 'Desconto: ', 0, 0, 'R');
    $pdf->Cell(40, 8, 'R$ ' . ($valorDesconto_formatado), 0, 1, 'C');

    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(160, 8, 'Valor Total: ', 0, 0, 'R');
    $valor_final = (($totalSubtotal + $mao_de_obra) - $valorDesconto);
    $valor_final = number_format($valor_final, 2, ',', '.');
    $pdf->Cell(40, 8, 'R$ ' . ($valor_final), 0, 1, 'C');

    // Gere o arquivo PDF
    $nome_arquivo = "pedido_$pedido_id.pdf";
    ob_end_clean(); // Limpeza do buffer de saída antes de enviar o PDF

    $pdf->Output($nome_arquivo, 'I');
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}