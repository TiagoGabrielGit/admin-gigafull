<?php
session_start();

if (isset($_SESSION['id'])) {

    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtém os dados enviados pelo formulário
        $id_pauta = $_POST['pautaID'];
        $novo_debate = $_POST['debate'];

        // Prepara a consulta de atualização
        $sql = "UPDATE ata_reuniao_pautas SET debate = :debate WHERE id = :id";

        // Executa a atualização
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['debate' => $novo_debate, 'id' => $id_pauta]);

            // Redireciona de volta à página anterior ou exibe uma mensagem de sucesso
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        } catch (PDOException $e) {
            echo "Erro ao atualizar o debate: " . $e->getMessage();
        }
    } else {
        header("Location: /index.php");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
