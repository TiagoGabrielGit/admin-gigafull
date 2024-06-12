<?php
session_start();
if (isset($_SESSION['id'])) {

    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    // Função para verificar e limpar os dados
    function limparDados($data) {
        return htmlspecialchars(trim($data));
    }

    // Função para converter orçamento
    function converterOrcamento($orcamento) {
        // Remove espaços em branco
        $orcamento = trim($orcamento);
        
        // Substitui vírgula por ponto, se presente
        $orcamento = str_replace(',', '.', $orcamento);

        // Se após a substituição ainda for numérico, retorna o valor
        if (is_numeric($orcamento)) {
            return $orcamento;
        } else {
            // Se não for numérico, retorna null para tratamento posterior
            return null;
        }
    }

    // Verificar se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Obter e limpar os dados do formulário
        $tarefa_id = isset($_POST['tarefa_id']) ? limparDados($_POST['tarefa_id']) : null;
        $descricao = isset($_POST['descricao']) ? limparDados($_POST['descricao']) : null;
        $status = isset($_POST['status']) ? limparDados($_POST['status']) : null;
        $area_planejamento = isset($_POST['area_planejamento']) ? limparDados($_POST['area_planejamento']) : null;

        // Obter e converter o orçamento
        $orcamento = isset($_POST['orcamento']) ? converterOrcamento($_POST['orcamento']) : null;

        // Verificar se o ID da tarefa está presente
        if ($tarefa_id === null) {
            echo "ID da tarefa não fornecido.";
            exit;
        }

        // Validar os campos obrigatórios
        if (empty($descricao) || empty($status)) {
            echo "Por favor, preencha todos os campos obrigatórios.";
            exit;
        }

        // Validação específica para o orçamento
        if ($orcamento === null && $_POST['orcamento'] !== '') {
            echo "Por favor, forneça um valor numérico válido para o orçamento.";
            exit;
        }

        try {
            // Preparar a consulta de atualização da tarefa
            $sql = "
            UPDATE tarefas 
            SET descricao = :descricao, 
                orcamento = :orcamento, 
                status = :status, 
                area_planejamento = :area_planejamento 
            WHERE id = :tarefa_id
            ";

            // Preparar o array de dados para a execução
            $data = [
                'descricao' => $descricao,
                'orcamento' => $orcamento === '' ? null : $orcamento, // Tratar orçamento vazio como NULL
                'status' => $status,
                'tarefa_id' => $tarefa_id
            ];

            // Tratar o campo area_planejamento: se for vazio, definir como NULL
            $data['area_planejamento'] = empty($area_planejamento) ? null : $area_planejamento;

            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);

            // Redirecionar de volta para a página da tarefa ou exibir uma mensagem de sucesso
            header("Location: tarefa.php?id=$tarefa_id");
            exit;
        } catch (PDOException $e) {
            echo "Erro ao atualizar a tarefa: " . $e->getMessage();
        }
    } else {
        echo "Método de requisição inválido.";
    }
} else {
    header("Location: /index.php");
    exit();
}
