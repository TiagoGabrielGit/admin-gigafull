<?php
session_start();

// Verifica se o ID da sessão está definido e é válido
if (isset($_SESSION['id']) && $_SESSION['id'] !== '') {
    require "../../../conexoes/conexao_pdo.php";

    // Obtenha os parâmetros enviados via GET
    $empresaChamado = $_SESSION['empresa_id'];
    //$empresaChamado = isset($_GET['empresa']) ? intval($_GET['empresa']) : null;
    $tipoChamado = isset($_GET['tipo']) ? intval($_GET['tipo']) : null;

    if ($empresaChamado !== null && $tipoChamado !== null) {
        try {
            // Consulta preparada para evitar injeção SQL
            $sql = "SELECT CASE 
                            WHEN tcm.active = 1 THEN tcm.mascara 
                            ELSE tc.mascara 
                        END AS mascara
                        FROM tipos_chamados as tc
                        LEFT JOIN tipos_chamados_mascaras as tcm ON tcm.tipo_chamado_id = tc.id AND tcm.active = 1 AND tcm.empresa_id = :empresaChamado
                        WHERE tc.id = :tipoChamado";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':empresaChamado', $empresaChamado, PDO::PARAM_INT);
            $stmt->bindParam(':tipoChamado', $tipoChamado, PDO::PARAM_INT);
            $stmt->execute();
            $mascara = $stmt->fetchColumn();

            // Retorna a máscara (ou vazio se não houver)
            //echo 'Empresa:' . $empresaChamado . '<br>' . 'Tipo Chamado: ' . $tipoChamado;
            echo $mascara ?? '';
        } catch (PDOException $e) {
            // Tratamento de erro
            echo "Erro ao executar a consulta: " . $e->getMessage();
        }
    } else {
        echo "Parâmetros inválidos.";
    }
} else { // Se o ID da sessão não estiver definido ou for inválido
    header("Location: /index.php");
    exit();
}
