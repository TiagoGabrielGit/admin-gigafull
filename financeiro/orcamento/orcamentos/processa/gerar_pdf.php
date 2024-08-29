<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/tcpdf/tcpdf.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

// Receber variáveis do formulário
$orcamento = isset($_POST['orcamento']) ? $_POST['orcamento'] : '';
$agrupamento_filter = isset($_POST['agrupamento_filter']) ? $_POST['agrupamento_filter'] : '';
$centro_de_custo_filter = isset($_POST['centro_de_custo_filter']) ? $_POST['centro_de_custo_filter'] : '';
$categoria_filter = isset($_POST['categoria_filter']) ? $_POST['categoria_filter'] : '';
$mes_competencia_filter = isset($_POST['mes_competencia_filter']) ? $_POST['mes_competencia_filter'] : '';
$ano_competencia_filter = isset($_POST['ano_competencia_filter']) ? $_POST['ano_competencia_filter'] : '';

// Substituir '%' por 'Todos'
$orcamento = $orcamento === '%' ? 'Todos' : $orcamento;
$agrupamento_filter = $agrupamento_filter === '%' ? 'Todos' : $agrupamento_filter;
$centro_de_custo_filter = $centro_de_custo_filter === '%' ? 'Todos' : $centro_de_custo_filter;
$categoria_filter = $categoria_filter === '%' ? 'Todos' : $categoria_filter;
$mes_competencia_filter = $mes_competencia_filter === '%' ? 'Todos' : $mes_competencia_filter;
$ano_competencia_filter = $ano_competencia_filter === '%' ? 'Todos' : $ano_competencia_filter;

class MYPDF extends TCPDF {
    private $orcamento;
    private $agrupamento_filter;
    private $centro_de_custo_filter;
    private $categoria_filter;
    private $mes_competencia_filter;
    private $ano_competencia_filter;

    public function __construct($orcamento, $agrupamento_filter, $centro_de_custo_filter, $categoria_filter, $mes_competencia_filter, $ano_competencia_filter) {
        parent::__construct('L', 'mm', 'A4', true, 'UTF-8', false);
        $this->orcamento = $orcamento;
        $this->agrupamento_filter = $agrupamento_filter;
        $this->centro_de_custo_filter = $centro_de_custo_filter;
        $this->categoria_filter = $categoria_filter;
        $this->mes_competencia_filter = $mes_competencia_filter;
        $this->ano_competencia_filter = $ano_competencia_filter;
    }

    // Página header
    public function Header() {
        if ($this->page == 1) {
            // Título do documento
            $this->SetFont('helvetica', 'B', 16);
            $this->Cell(0, 15, 'Relatório de Orçamentos', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
            
            // Subtítulo com informações adicionais
            $this->SetFont('helvetica', '', 10);
            $this->Cell(0, 10, 'Orçamento: ' . $this->orcamento, 0, 1, 'C', 0, '', 0, false, 'T', 'M');
            $this->Cell(0, 10, 'Agrupamento: ' . $this->agrupamento_filter . ' | Centro de Custo: ' . $this->centro_de_custo_filter . ' | Categoria: ' . $this->categoria_filter, 0, 1, 'C', 0, '', 0, false, 'T', 'M');
            $this->Cell(0, 10, 'Mês Competência: ' . $this->mes_competencia_filter . ' | Ano Competência: ' . $this->ano_competencia_filter, 0, 1, 'C', 0, '', 0, false, 'T', 'M');
            
            // Adicionar espaçamento para evitar sobreposição
            $this->Ln(10);
        }
    }

    // Página footer
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 6);
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Criar novo documento PDF
$pdf = new MYPDF($orcamento, $agrupamento_filter, $centro_de_custo_filter, $categoria_filter, $mes_competencia_filter, $ano_competencia_filter);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Seu Nome');
$pdf->SetTitle('Relatório de Orçamentos');
$pdf->SetSubject('Relatório de Orçamentos');
$pdf->SetKeywords('TCPDF, PDF, orçamento, relatório');

// Configurações de fonte
$pdf->SetFont('helvetica', '', 10);

// Definir margem superior
$pdf->SetMargins(PDF_MARGIN_LEFT, 50, PDF_MARGIN_RIGHT); // Ajustar a margem superior conforme necessário

// Adicionar uma página
$pdf->AddPage();

// Conectar ao banco de dados e buscar dados
$sql = "SELECT
            a.agrupamento,
            c.categoria,
            cc.centro_de_custo,
            o.descricao,
            o.fornecedor,
            o.orcado,
            o.mes_competencia,
            o.ano_competencia
        FROM cc_orcamentos o
        JOIN cc_agrupamentos a ON o.agrupamento = a.id
        JOIN cc_categoria c ON o.categoria = c.id
        JOIN cc_centro_de_custo cc ON o.centro_de_custo = cc.id
        ORDER BY o.mes_competencia ASC, ano_competencia ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute();

// Iniciar tabela
$html = '<table border="1" cellpadding="5">
            <thead>
                <tr style="text-align: center; font-weight: bold;">
                    <th>Agrupamento</th>
                    <th>Categoria</th>
                    <th>Centro de Custo</th>
                    <th>Descrição</th>
                    <th>Fornecedor</th>
                    <th>Orçado</th>
                    <th>Mês Competência</th>
                    <th>Ano Competência</th>
                </tr>
            </thead>
            <tbody>';

// Preencher dados da tabela
$totalOrcado = 0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $orcado = $row['orcado'];
    $totalOrcado += $orcado;
    
    $html .= '<tr style="text-align: center;">
                <td>' . htmlspecialchars($row['agrupamento']) . '</td>
                <td>' . htmlspecialchars($row['categoria']) . '</td>
                <td>' . htmlspecialchars($row['centro_de_custo']) . '</td>
                <td>' . htmlspecialchars($row['descricao']) . '</td>
                <td>' . htmlspecialchars($row['fornecedor']) . '</td>
                <td>R$ ' . number_format($orcado, 2, ',', '.') . '</td>
                <td>' . htmlspecialchars($row['mes_competencia']) . '</td>
                <td>' . htmlspecialchars($row['ano_competencia']) . '</td>
            </tr>';
}

$html .= '</tbody>
            <tfoot>
                <tr style="text-align: center;">
                    <td colspan="5"><strong>Total</strong></td>
                    <td><strong>R$ ' . number_format($totalOrcado, 2, ',', '.') . '</strong></td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>';

// Adicionar HTML ao PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Fechar e enviar PDF
$pdf->Output('relatorio_orcamentos.pdf', 'I');
