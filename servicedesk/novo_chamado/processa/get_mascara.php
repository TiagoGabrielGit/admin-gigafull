<?php
session_start();
if (isset($_SESSION['id'])) {
    require "../../../conexoes/conexao_pdo.php";

    // Obtenha os parâmetros enviados via GET
    $empresaChamado = $_GET['empresa'] ?? null;
    $tipoChamado = $_GET['tipo'] ?? null;

    // Consulte a tabela tipos_chamados_mascaras para obter a máscara personalizada
    $sql = "SELECT mascara FROM tipos_chamados_mascaras WHERE empresa_id = :empresa AND tipo_chamado_id = :tipo AND active = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['empresa' => $empresaChamado, 'tipo' => $tipoChamado]);
    $mascara = $stmt->fetchColumn();

    // Se não houver máscara personalizada, consulte a tabela tipos_chamados para obter a máscara padrão
    if (!$mascara) {
        $sql = "SELECT mascara FROM tipos_chamados WHERE id = :tipo";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['tipo' => $tipoChamado]);
        $mascara = $stmt->fetchColumn();
    }

    // Retorna a máscara (ou vazio se não houver)
    echo $mascara ?? '';
} else { // 1
    header("Location: /index.php");
    exit();
}
