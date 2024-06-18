<?php
session_start();

if (isset($_SESSION["id"]) && isset($_GET['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
    require_once('../tcpdf.php');

    $id_quadro = $_GET['id'];

    $query = "SELECT e.fantasia, e.site, e.email, e.cnpj FROM empresas AS e WHERE e.atributoEmpresaPrincipal = 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $dados_empresa = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dados_empresa) {
        $fantasia = $dados_empresa['fantasia'];
        $site = $dados_empresa['site'];
        $email = $dados_empresa['email'];
        $cnpj = $dados_empresa['cnpj'];
    } else {
        $fantasia = "Empresa Não Encontrada";
        $site = "";
        $email = "";
        $cnpj = "";
    }

    $consulta_quadro = "SELECT titulo, status FROM quadros WHERE id = :quadro_id";
    $stmt_quadro = $pdo->prepare($consulta_quadro);
    $stmt_quadro->execute(['quadro_id' => $id_quadro]);
    $quadro = $stmt_quadro->fetch(PDO::FETCH_ASSOC);

    $consulta_tarefas = "SELECT id, descricao, ordem, created, status FROM tarefas WHERE quadro_id = :quadro_id ORDER BY ordem";
    $stmt_tarefas = $pdo->prepare($consulta_tarefas);
    $stmt_tarefas->execute(['quadro_id' => $id_quadro]);
    $tarefas = $stmt_tarefas->fetchAll(PDO::FETCH_ASSOC);

    class relatorioQuadroTarefas extends TCPDF
    {
        public function Header()
        {
            $this->SetFont('helvetica', 'B', 20);
        }

        public function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('helvetica', 'I', 8);
            $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }

    $pdf = new relatorioQuadroTarefas();

    $pdf->AddPage();
    $pdf->Image('../../assets/img/logo.png', 10, 10, 30, 0, 'PNG');

    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 5, $fantasia, 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 5, $cnpj, 0, 1, 'C');
    $pdf->Cell(0, 5, $site, 0, 1, 'C');
    $pdf->Cell(0, 5, $email, 0, 1, 'C');

    $pdf->Ln(10);

    $pdf->SetLineWidth(0.2);
    $pdf->Line(10, $pdf->GetY(), $pdf->getPageWidth() - 10, $pdf->GetY());
    $pdf->Ln(5);

    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'Quadro: ' . $quadro['titulo'], 0, 1, 'L');
    $pdf->Cell(0, 10, 'Status: ' . ($quadro['status'] == 1 ? 'Aberto' : 'Arquivado'), 0, 1, 'L');

    $pdf->Ln(6);

    foreach ($tarefas as $tarefa) {
        $tarefa_id = $tarefa['id'];
        $consulta_despesas = "SELECT SUM(valor) as total FROM qt_despesas WHERE id_tarefa = :id_tarefa";
        $stmt_despesas = $pdo->prepare($consulta_despesas);
        $stmt_despesas->execute(['id_tarefa' => $tarefa_id]);
        $despesas = $stmt_despesas->fetch(PDO::FETCH_ASSOC);

        $createdDate = date("d/m/Y", strtotime($tarefa['created']));
        $status = $tarefa['status'] == 1 ? 'Andamento' : ($tarefa['status'] == 2 ? 'Concluído' : 'Cancelado');
        $orcamento = isset($despesas['total']) ? number_format($despesas['total'], 2, ',', '.') : "N/A";

        $pdf->Ln(5);

        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 5, 'Descrição: ' . htmlspecialchars($tarefa['descricao']), 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 5, 'Status: ' . $status, 0, 1, 'L');
        $pdf->Cell(0, 5, 'Data Criação: ' . $createdDate, 0, 1, 'L');
        $pdf->Cell(0, 5, 'Orçamento (R$): ' . $orcamento, 0, 1, 'L');
        $pdf->Ln(2);

        $pdf->SetLineWidth(0.2);
        $pdf->Line(10, $pdf->GetY(), $pdf->getPageWidth() - 10, $pdf->GetY());
        $pdf->Ln(2);
    }

    $pdf->Output('relatorio_tarefas.pdf', 'I');
} else {
    header("Location: /login.php");
    exit;
}
?>
