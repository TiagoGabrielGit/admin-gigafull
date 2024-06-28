<?php
session_start();
if (isset($_SESSION['id'])) {
    require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Obtém os parâmetros da requisição GET
        $id_servico = $_GET['id_servico'];
        $tempo_arredondado = $_GET['tempo_arredondado'];
        $competencia = $_GET['mes'] . $_GET['ano'];
        $contrato = $_GET['contrato'];

        // Consulta SQL para buscar informações do serviço
        $busca_servico =
            "SELECT
            cs.tipo_cobranca as tipo_cobranca,
            cs.valor_mensal as valor_mensal,
            cs.valor_hora as valor_hora,
            cs.horas_inclusas as horas_inclusas,
            cs.valor_hora_excedente as valor_hora_excedente,
            cs.valor_fixo as valor_fixo
            FROM contract_service as cs
            WHERE cs.id = :id_servico";

        // Preparando e executando a consulta SQL
        $stmt = $pdo->prepare($busca_servico);
        $stmt->bindParam(':id_servico', $id_servico, PDO::PARAM_INT);
        $stmt->execute();

        // Verifica se encontrou algum resultado
        if ($stmt->rowCount() > 0) {
            // Obtém os resultados da consulta
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $tipo_cobranca = $resultado['tipo_cobranca'];

            // Inicializa a variável $faturamento_final com base no tipo de cobrança
            if ($tipo_cobranca == 1) {
                // Tipo de cobrança 1: Faturamento final é "0"
                $faturamento_final = "0";
            } else if ($tipo_cobranca == 2) {
                // Tipo de cobrança 2: Faturamento final é o valor mensal
                $faturamento_final = $resultado['valor_mensal'];
            } else if ($tipo_cobranca == 3) {
                // Tipo de cobrança 3: Faturamento final é o valor hora multiplicado pelo tempo arredondado
                $faturamento_final = ($resultado['valor_hora'] * $tempo_arredondado);
            } else if ($tipo_cobranca == 4) {
                // Tipo de cobrança 4: Calcular horas adicionais e valor adicional
                $horas_adicionais = ($tempo_arredondado - $resultado['horas_inclusas']);

                if ($horas_adicionais < 0) {
                    // Se horas adicionais forem negativas, valor adicional é "0"
                    $valor_adicional = "0";
                } else {
                    // Caso contrário, calcula-se o valor adicional
                    $valor_adicional = ($horas_adicionais * $resultado['valor_hora_excedente']);
                }

                // Faturamento final é o valor fixo mais o valor adicional calculado
                $faturamento_final = ($resultado['valor_fixo'] + $valor_adicional);
            }

            // Inserir o faturamento final na tabela contrato_faturamento
            $inserir_faturamento = "INSERT INTO contrato_faturamento (competencia, contrato_id, servico_id, valor, status) VALUES (:competencia, :contrato_id, :servico_id, :valor, 1)";
            $stmt_insert = $pdo->prepare($inserir_faturamento);
            $stmt_insert->bindParam(':competencia', $competencia, PDO::PARAM_STR);
            $stmt_insert->bindParam(':contrato_id', $contrato, PDO::PARAM_STR);
            $stmt_insert->bindParam(':servico_id', $id_servico, PDO::PARAM_INT);
            $stmt_insert->bindParam(':valor', $faturamento_final, PDO::PARAM_STR); // Assumindo que o valor é uma string

            if ($stmt_insert->execute()) {
?>
                <form id="redirectForm" action="/financeiro/gerar_faturamento/index.php" method="POST">
                    <input type="hidden" name="ano" value="<?= $_GET['ano'] ?>">
                    <input type="hidden" name="mes" value="<?= $_GET['mes'] ?>">

                </form>
                <script>
                    document.getElementById('redirectForm').submit();
                </script>
            <?php
            } else {
            ?>
                <form id="redirectForm" action="/financeiro/gerar_faturamento/index.php" method="POST">
                    <input type="hidden" name="ano" value="<?= $_GET['ano'] ?>">
                    <input type="hidden" name="mes" value="<?= $_GET['mes'] ?>">
                </form>
                <script>
                    document.getElementById('redirectForm').submit();
                </script>
<?php
            }
        } else {
            header("Location: /financeiro/gerar_faturamento/index.php");
            exit();
        }
    } else {
        header("Location: /financeiro/gerar_faturamento/index.php");
        exit();
    }
} else {
    // Se não houver uma sessão ativa, redireciona para a página inicial
    header("Location: /index.php");
    exit();
}
