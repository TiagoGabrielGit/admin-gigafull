<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    // Verificar se os dados foram enviados via POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $idServico = filter_input(INPUT_POST, 'id_servico', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $tipoCobranca = filter_input(INPUT_POST, 'tipo_cobranca', FILTER_VALIDATE_INT);
        $valorHora = filter_input(INPUT_POST, 'valor_hora', FILTER_DEFAULT, FILTER_FLAG_ALLOW_FRACTION);
        $valorMensal = filter_input(INPUT_POST, 'valor_mensal', FILTER_DEFAULT, FILTER_FLAG_ALLOW_FRACTION);
        $valorFixo = filter_input(INPUT_POST, 'valor_fixo', FILTER_DEFAULT, FILTER_FLAG_ALLOW_FRACTION);
        $horasInclusas = filter_input(INPUT_POST, 'horas_inclusas', FILTER_VALIDATE_INT);
        $valorHoraExcedente = filter_input(INPUT_POST, 'valor_hora_excedente', FILTER_DEFAULT, FILTER_FLAG_ALLOW_FRACTION);

        if ($idServico) {
            // Preparar a consulta SQL para atualizar os dados do serviço
            if ($tipoCobranca == 4) {
                // Se o tipo de cobrança for Fixo + Hora Excedente
                $update_query = "
                UPDATE contract_service 
                SET tipo_cobranca = :tipoCobranca, valor_fixo = :valorFixo, horas_inclusas = :horasInclusas, valor_hora_excedente = :valorHoraExcedente, active = :active
                WHERE id = :idServico
            ";
            } else {
                // Para outros tipos de cobrança
                $update_query = "
                UPDATE contract_service 
                SET tipo_cobranca = :tipoCobranca, valor_hora = :valorHora, valor_mensal = :valorMensal, active = :active
                WHERE id = :idServico
            ";
            }

            $stmt = $pdo->prepare($update_query);
            $stmt->bindParam(':tipoCobranca', $tipoCobranca, PDO::PARAM_INT);
            $stmt->bindParam(':active', $status, PDO::PARAM_INT);
            $stmt->bindParam(':idServico', $idServico, PDO::PARAM_INT);

            if ($tipoCobranca == 4) {
                // Se o tipo de cobrança for Fixo + Hora Excedente
                $stmt->bindParam(':valorFixo', $valorFixo);
                $stmt->bindParam(':horasInclusas', $horasInclusas, PDO::PARAM_INT);
                $stmt->bindParam(':valorHoraExcedente', $valorHoraExcedente);
            } else {
                // Para outros tipos de cobrança
                $stmt->bindParam(':valorHora', $valorHora);
                $stmt->bindParam(':valorMensal', $valorMensal);
            }

            // Executar a consulta
            if ($stmt->execute()) {
                // Redirecionar de volta à página de detalhes do contrato com uma mensagem de sucesso
                header("Location: /contrato/contrato_servico.php?id=$idServico");
                exit();
            } else {
                echo "Erro ao atualizar o serviço. Por favor, tente novamente.";
            }
        } else {
            echo "ID de serviço inválido.";
        }
    } else {
        echo "Requisição inválida.";
    }
} else {
    header("Location: /index.php");
    exit();
}
