<?php
session_start();
// Verifica se existe os dados da sessão de login
if (!isset($_SESSION["id"])) {
    // Usuário não logado! Redireciona para a página de login
    header("Location: /login.php");
    exit;
}

require "../tcpdf.php";
require "../../conexoes/conexao_pdo.php";

$idPOP = $_GET['id'];

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('SELECT p.pop AS pop, pa.city AS cidade, pa.street AS rua, pa.number AS numero
        FROM pop AS p
        LEFT JOIN pop_address AS pa ON pa.pop_id = p.id
        WHERE p.id = :id');
    $stmt->bindParam(':id', $idPOP, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $popNome = $row['pop'];
    $popCidade = $row['cidade'];
    $popRua = $row['rua'];
    $numero = $row['numero'];


    $stmtEquipamentos = $pdo->prepare('SELECT 
        ep.hostname as "hostname",
        e.equipamento as "equipamento",
        ep.serialEquipamento as "serial"
        FROM 
        equipamentospop as ep
        LEFT JOIN
        equipamentos as e
        ON
        e.id = ep.equipamento_id
        WHERE 
        ep.pop_id = :id
        AND
        ep.deleted = 1');
    $stmtEquipamentos->bindParam(':id', $idPOP, PDO::PARAM_INT);
    $stmtEquipamentos->execute();

    $equipamentos = $stmtEquipamentos->fetchAll(PDO::FETCH_ASSOC);


    class VistoriaPDF extends TCPDF
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

    $pdf = new VistoriaPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);

    $pdf->Image('../../assets/img/logo.png', 10, 10, 20, 0, 'PNG');
    $larguraImagem = 20; // Largura da imagem

    $tamanhoFonte = 20; // Tamanho da fonte do título
    $titulo = 'Formulário de Vistoria';
    $larguraTitulo = $pdf->GetStringWidth($titulo, '', $tamanhoFonte); // Largura do título
    $coordX = (210 - $larguraTitulo - $larguraImagem) / 2; // Cálculo das coordenadas x

    $pdf->SetFont('helvetica', 'B', $tamanhoFonte);
    $pdf->Text($coordX, 15, $titulo);

    // Desenhar retângulo
    $pdf->Rect(10, 35, 190, 45, 'D');

    // Coordenadas para o preenchimento das informações
    $x = 15;
    $y = 38;
    $espacoEntreLinhas = 8;

    // Adicionar informações dentro do retângulo
    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($x, $y);
    $pdf->Cell(40, 10, 'Nome do POP:');
    $pdf->SetXY($x + 40, $y);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, $popNome);
    $pdf->Line($x, $y + $espacoEntreLinhas, $x + 180, $y + $espacoEntreLinhas);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($x, $y + $espacoEntreLinhas);
    $pdf->Cell(40, 10, 'Localização:');
    $pdf->SetXY($x + 40, $y + $espacoEntreLinhas);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, $popCidade . ' - ' . $popRua  . ' , ' . $numero);
    $pdf->Line($x, $y + 2 * $espacoEntreLinhas, $x + 180, $y + 2 * $espacoEntreLinhas);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($x, $y + 2 * $espacoEntreLinhas);
    $pdf->Cell(40, 10, 'Responsável:');
    $pdf->SetXY($x + 40, $y + 2 * $espacoEntreLinhas);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);
    $pdf->Line($x, $y + 3 * $espacoEntreLinhas, $x + 180, $y + 3 * $espacoEntreLinhas);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($x, $y + 3 * $espacoEntreLinhas);
    $pdf->Cell(40, 10, 'Data da Vistoria:');
    $pdf->SetXY($x + 40, $y + 3 * $espacoEntreLinhas);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);
    $pdf->Line($x, $y + 4 * $espacoEntreLinhas, $x + 180, $y + 4 * $espacoEntreLinhas);


    // Desenhar novo retângulo
    $pdf->Rect(10, 85, 190, 65, 'D');

    // Coordenadas para o preenchimento das novas informações
    $xNova = 15;
    $yNova = 88;
    $espacoEntreLinhasNova = 8;

    // Adicionar novas informações dentro do novo retângulo
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->SetXY($xNova, $yNova);
    $pdf->Cell(40, 10, 'Energia e Segurança');
    $pdf->SetXY($xNova + 40, $yNova);
    $pdf->SetFont('helvetica', '', 12);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($xNova, $yNova + $espacoEntreLinhasNova);
    $pdf->Cell(40, 10, 'Baterias:');
    $pdf->SetXY($xNova + 40, $yNova + $espacoEntreLinhasNova);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);
    $pdf->Line($xNova, $yNova + 2 * $espacoEntreLinhasNova, $xNova + 180, $yNova + 2 * $espacoEntreLinhasNova);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($xNova, $yNova + 2 * $espacoEntreLinhasNova);
    $pdf->Cell(40, 10, 'Monitoramento de Energia:');
    $pdf->SetXY($xNova + 40, $yNova + 2 * $espacoEntreLinhasNova);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);
    $pdf->Line($xNova, $yNova + 3 * $espacoEntreLinhasNova, $xNova + 180, $yNova + 3 * $espacoEntreLinhasNova);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($xNova, $yNova + 3 * $espacoEntreLinhasNova);
    $pdf->Cell(40, 10, 'Fonte:');
    $pdf->SetXY($xNova + 40, $yNova + 3 * $espacoEntreLinhasNova);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);
    $pdf->Line($xNova, $yNova + 4 * $espacoEntreLinhasNova, $xNova + 180, $yNova + 4 * $espacoEntreLinhasNova);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($xNova, $yNova + 4 * $espacoEntreLinhasNova);
    $pdf->Cell(40, 10, 'Câmera:');
    $pdf->SetXY($xNova + 40, $yNova + 4 * $espacoEntreLinhasNova);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);
    $pdf->Line($xNova, $yNova + 5 * $espacoEntreLinhasNova, $xNova + 180, $yNova + 5 * $espacoEntreLinhasNova);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($xNova, $yNova + 5 * $espacoEntreLinhasNova);
    $pdf->Cell(40, 10, 'Detalhes Adicionais:');
    $pdf->SetXY($xNova + 40, $yNova + 5 * $espacoEntreLinhasNova);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);
    $pdf->Line($xNova, $yNova + 6 * $espacoEntreLinhasNova, $xNova + 180, $yNova + 6 * $espacoEntreLinhasNova);
    $pdf->Line($xNova, $yNova + 7 * $espacoEntreLinhasNova, $xNova + 180, $yNova + 7 * $espacoEntreLinhasNova);


    // Desenhar terceiro retângulo
    $pdf->Rect(10, 155, 190, 50, 'D');

    // Coordenadas para o preenchimento das novas informações
    $xNova2 = 15;
    $yNova2 = 158;
    $espacoEntreLinhasNova2 = 8;

    // Adicionar novas informações dentro do terceiro retângulo
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->SetXY($xNova2, $yNova2);
    $pdf->Cell(40, 10, 'Ar Condicionado');
    $pdf->SetXY($xNova2 + 40, $yNova2);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($xNova2, $yNova2 + $espacoEntreLinhasNova2);
    $pdf->Cell(40, 10, 'Marca/Modelo/BTU:');
    $pdf->SetXY($xNova2 + 40, $yNova2 + $espacoEntreLinhasNova2);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);
    $pdf->Line($xNova2, $yNova2 + 2 * $espacoEntreLinhasNova2, $xNova2 + 180, $yNova2 + 2 * $espacoEntreLinhasNova2);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($xNova2, $yNova2 + 2 * $espacoEntreLinhasNova2);
    $pdf->Cell(40, 10, 'Funcionamento:');
    $pdf->SetXY($xNova2 + 40, $yNova2 + $espacoEntreLinhasNova2);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);
    $pdf->Line($xNova2, $yNova2 + 3 * $espacoEntreLinhasNova2, $xNova2 + 180, $yNova2 + 3 * $espacoEntreLinhasNova2);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($xNova2, $yNova2 + 3 * $espacoEntreLinhasNova2);
    $pdf->Cell(40, 10, 'Limpeza:');
    $pdf->SetXY($xNova2 + 40, $yNova2 + $espacoEntreLinhasNova2);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);
    $pdf->Line($xNova2, $yNova2 + 4 * $espacoEntreLinhasNova2, $xNova2 + 180, $yNova2 + 4 * $espacoEntreLinhasNova2);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($xNova2, $yNova2 + 4 * $espacoEntreLinhasNova2);
    $pdf->Cell(40, 10, 'Última Manutenção:');
    $pdf->SetXY($xNova2 + 40, $yNova2 + $espacoEntreLinhasNova2);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);
    $pdf->Line($xNova2, $yNova2 + 5 * $espacoEntreLinhasNova2, $xNova2 + 180, $yNova2 + 5 * $espacoEntreLinhasNova2);

    // Desenhar Quarto retângulo
    $pdf->Rect(10, 210, 190, 60, 'D');

    $xNova3 = 15;
    $yNova3 = 212;
    $espacoEntreLinhasNova3 = 8;

    // Adicionar novas informações dentro do terceiro retângulo
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->SetXY($xNova3, $yNova3);
    $pdf->Cell(40, 10, 'Estrutura e Ambiente');
    $pdf->SetXY($xNova3 + 40, $yNova3);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($xNova3, $yNova3 + $espacoEntreLinhasNova3);
    $pdf->Cell(40, 10, 'Marca/Modelo Rack:');
    $pdf->SetXY($xNova3 + 40, $yNova3 + $espacoEntreLinhasNova3);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);
    $pdf->Line($xNova3, $yNova3 + 2 * $espacoEntreLinhasNova3, $xNova3 + 180, $yNova3 + 2 * $espacoEntreLinhasNova3);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($xNova3, $yNova3 + 2 * $espacoEntreLinhasNova3);
    $pdf->Cell(40, 10, 'Tamanho do Rack L/P/A:');
    $pdf->SetXY($xNova3 + 40, $yNova3 + $espacoEntreLinhasNova3);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);
    $pdf->Line($xNova3, $yNova3 + 3 * $espacoEntreLinhasNova3, $xNova3 + 180, $yNova3 + 3 * $espacoEntreLinhasNova3);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($xNova3, $yNova3 + 3 * $espacoEntreLinhasNova3);
    $pdf->Cell(40, 10, 'DIO:');
    $pdf->SetXY($xNova3 + 40, $yNova3 + $espacoEntreLinhasNova3);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);
    $pdf->Line($xNova3, $yNova3 + 4 * $espacoEntreLinhasNova3, $xNova3 + 180, $yNova3 + 4 * $espacoEntreLinhasNova3);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($xNova3, $yNova3 + 4 * $espacoEntreLinhasNova3);
    $pdf->Cell(40, 10, 'Organização do Ambiente e Rack:');
    $pdf->SetXY($xNova3 + 40, $yNova3 + $espacoEntreLinhasNova3);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);
    $pdf->Line($xNova3, $yNova3 + 5 * $espacoEntreLinhasNova3, $xNova3 + 180, $yNova3 + 5 * $espacoEntreLinhasNova3);

    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY($xNova3, $yNova3 + 5 * $espacoEntreLinhasNova3);
    $pdf->Cell(40, 10, 'Organização e Limpeza do Ambiente e Rack:');
    $pdf->SetXY($xNova3 + 40, $yNova3 + $espacoEntreLinhasNova3);
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10,);
    $pdf->Line($xNova3, $yNova3 + 6 * $espacoEntreLinhasNova3, $xNova3 + 180, $yNova3 + 6 * $espacoEntreLinhasNova3);
    $pdf->Line($xNova3, $yNova3 + 7 * $espacoEntreLinhasNova3, $xNova3 + 180, $yNova3 + 7 * $espacoEntreLinhasNova3);


    $pdf->SetFont('helvetica', '', 12);
    $yEquipamentos = 310;
    $equipamentosText = '';
    foreach ($equipamentos as $equipamento) {
        $equipamentosText .= 'Hostname: ' . $equipamento['hostname'] . "\n";
        $equipamentosText .= 'Equipamento: ' . $equipamento['equipamento'] . "\n";
        $equipamentosText .= 'Serial: ' . $equipamento['serial'] . "\n";
        $equipamentosText .= 'Descreva sobre o equipamento (ligação, limpeza, fontes, placas): ' . "\n";

        // Adicionar as quatro linhas para escrever
        $equipamentosText .= 'Ligação:____________________________________________________________________' . "\n";
        $equipamentosText .= 'Limpeza:____________________________________________________________________' . "\n";
        $equipamentosText .= 'Fontes:_____________________________________________________________________' . "\n";
        $equipamentosText .= 'Acessórios:__________________________________________________________________' . "\n";
        $equipamentosText .= 'Observação:____________________________________________________________________________________________________________________________________________' . "\n\n";
    }

    $pdf->SetXY(10, $yEquipamentos);
    $pdf->MultiCell(180, 10, $equipamentosText, 0, 'L');
    $pdf->Output('vistoria.pdf', 'I');
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
