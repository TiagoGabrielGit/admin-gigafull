<?php
session_start();
// Verifica se existem os dados da sessão de login
if (!isset($_SESSION["id"])) {
    // Usuário não logado! Redireciona para a página de login
    header("Location: /login.php");
    exit;
}

// Inclua o arquivo TCPDF
require_once('../tcpdf.php');
require("../../conexoes/conexao_pdo.php");

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
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}

$idChamado = $_GET['id'];

try {

    class relatorioChamado extends TCPDF
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

    $pdf = new relatorioChamado();

    // Adiciona uma página
    $pdf->AddPage();

    $pdf->Image('../../assets/img/logo.png', 10, 10, 30, 0, 'PNG');

    // Defina os dados da sua empresa na parte superior central
    $pdf->SetFont('helvetica', 'B', 16); // Define a fonte como negrito
    $pdf->Cell(0, 5, $fantasia, 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 12); // Volta para a fonte normal
    $pdf->Cell(0, 5, $cnpj, 0, 1, 'C');
    $pdf->Cell(0, 5, $site, 0, 1, 'C');
    $pdf->Cell(0, 5, $email, 0, 1, 'C');

    $pdf->Ln(15); // Adiciona um espaço vertical de 15 unidades

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta os dados do chamado usando Prepared Statements
    $stmt = $pdo->prepare(
        "SELECT
            c.id as 'id',
            c.assuntoChamado as 'assuntoChamado',
            c.relato_inicial as 'relato_inicial',
            DATE_FORMAT(c.data_abertura, '%d/%m/%Y %H:%i:%s') as 'data_abertura',
            e.fantasia as 'fantasia',
            tc.tipo as 'tipo',
            TIME_FORMAT(SEC_TO_TIME(c.seconds_worked), '%H:%i:%s') as 'seconds_worked',
            CASE
            WHEN C.status_id = 3 THEN 'Fechado'
            WHEN C.status_id <> 3 THEN 'Em Andamento'
            END as 'status'
        FROM 
            chamados as c
        LEFT JOIN
            empresas as e
        ON
            e.id = c.empresa_id
        LEFT JOIN
            tipos_chamados as tc
        ON               
            tc.id = c.tipochamado_id
        WHERE 
            c.id = :id
        "
    );
    $stmt->bindParam(':id', $idChamado);
    $stmt->execute();

    $chamado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($chamado) {
        // Obtém as coordenadas atuais do cursor
        $cursorX = $pdf->GetX();
        $cursorY = $pdf->GetY();

        // Define a posição inicial e final da linha horizontal
        $lineStartX = $cursorX;
        $lineStartY = $cursorY + 2;
        $lineEndX = $pdf->getPageWidth() - 20; // Defina o valor desejado para a margem direita
        $lineEndY = $lineStartY;

        // Define a largura da linha
        $pdf->SetLineWidth(0.2);

        // Desenha a linha horizontal
        $pdf->Line($lineStartX, $lineStartY, $lineEndX, $lineEndY);
        $pdf->Ln(4); // Adiciona uma linha em branco
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 5, 'Dados do Chamado:', 0, 1, 'L');
        $pdf->Ln(2); // Adiciona uma linha em branco
        $pdf->SetFont('helvetica', '', 12);

        $pdf->MultiCell(80, 5, 'ID do Chamado: ' . $chamado['id'], 0, 'L');
        $pdf->MultiCell(80, 5, 'Empresa: ' . $chamado['fantasia'], 0, 'L');
        $pdf->MultiCell(80, 5, 'Tipo do Chamado: ' . $chamado['tipo'], 0, 'L');
        $pdf->MultiCell(80, 5, 'Assunto: ' . $chamado['assuntoChamado'], 0, 'L');
        $pdf->MultiCell(80, 5, 'Data de Abertura: ' . $chamado['data_abertura'], 0, 'L');
        $pdf->MultiCell(80, 5, 'Tempo Total Trabalhado: ' . $chamado['seconds_worked'], 0, 'L');
        $pdf->MultiCell(80, 5, 'Status do Chamado: ' . $chamado['status'], 0, 'L');

        // Obtém as coordenadas atuais do cursor
        $cursorX = $pdf->GetX();
        $cursorY = $pdf->GetY();

        // Define a posição inicial e final da linha horizontal
        $lineStartX = $cursorX;
        $lineStartY = $cursorY + 2;
        $lineEndX = $pdf->getPageWidth() - 20; // Defina o valor desejado para a margem direita
        $lineEndY = $lineStartY;

        // Define a largura da linha
        $pdf->SetLineWidth(0.2);

        // Desenha a linha horizontal
        $pdf->Line($lineStartX, $lineStartY, $lineEndX, $lineEndY);

        $pdf->Ln(10); // Adiciona uma linha em branco
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 5, 'Descrição da abertura:', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 5, $chamado['relato_inicial'], 0, 1, 'L');
        $pdf->Ln(10); // Adiciona uma linha em branco

        // Consulta os relatos do chamado usando Prepared Statements
        $stmtRelatos = $pdo->prepare(
            "SELECT
                cr.id as 'id_relato',
                IF(cr.private = 2, 'Relato Privado', cr.relato) AS 'relato',
                TIME_FORMAT(SEC_TO_TIME(cr.seconds_worked), '%H:%i:%s') as 'seconds_worked',
                DATE_FORMAT(cr.relato_hora_inicial, '%d/%m/%Y %H:%i:%s') as 'relato_hora_inicial',
                DATE_FORMAT(cr.relato_hora_final, '%d/%m/%Y %H:%i:%s') as 'relato_hora_final',
                cr.private as 'privacidade'
             FROM 
                chamado_relato as cr
             WHERE 
                cr.chamado_id = :id_chamado
            ORDER BY
            cr.id ASC"
        );
        $stmtRelatos->bindParam(':id_chamado', $idChamado);
        $stmtRelatos->execute();

        $relatos = $stmtRelatos->fetchAll(PDO::FETCH_ASSOC);
        $pdf->SetFont('helvetica', 'B', 12);
        if ($relatos) {
            $pdf->Cell(0, 10, 'Relatos do chamado:', 0, 1, 'L');
            $pdf->SetFont('helvetica', '', 12);
            foreach ($relatos as $relato) {
                $pdf->Cell(0, 5, 'Relato' . ' #' . $relato['id_relato'], 0, 1, 'L');
                $pdf->Cell(0, 5, 'Horário: ' . $relato['relato_hora_inicial'] . ' à ' . $relato['relato_hora_final'], 0, 1, 'L');
                $pdf->Cell(0, 5, 'Tempo trabalhado: ' . $relato['seconds_worked'], 0, 1, 'L');
                $pdf->Cell(0, 5, '=> ' . $relato['relato'], 0, 1, 'L');
                $pdf->Ln(6); // Adiciona uma linha em branco

            }
        }
    } else {
        $pdf->Cell(0, 10, 'Chamado não encontrado', 0, 1, 'L');
    }

    // Fecha a conexão com o banco de dados
    $pdo = null;

    // Saída do PDF para o navegador
    $pdf->Output('exemplo.pdf', 'I');
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
