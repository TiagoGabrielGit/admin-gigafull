<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');


$uid = $_SESSION['id'];
$menu_id = "31";

$permissions =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_menu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_menu = $menu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {

    // Obter o mês e o ano atuais
    $mesAtual = date('n');  // 'n' retorna o mês sem o zero à esquerda (1-12)
    $anoAtual = date('Y');  // 'Y' retorna o ano com 4 dígitos (e.g., 2024)

    // Valores de filtro recebidos via POST (se houver)
    $anoSelecionado = $_POST['ano'] ?? ''; // Recebe o ano selecionado ou uma string vazia
    $mesSelecionado = $_POST['mes'] ?? ''; // Recebe o mês selecionado ou uma string vazia
?>

    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <h5 class="card-title">GERAR FATURAMENTO</h5>
                        </div>
                    </div>

                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label" for="ano">Selecione o ano de competência:</label>
                                <select name="ano" id="ano" class="form-select" required>
                                    <option selected disabled value="">Selecione uma opção</option>
                                    <?php
                                    // Loop para criar as opções de ano desde um ano de início até o ano atual
                                    $anoInicio = 2020; // Defina o ano inicial conforme necessário
                                    for ($i = $anoInicio; $i <= $anoAtual; $i++) {
                                        $selected = ($i == $anoSelecionado) ? 'selected' : '';
                                        echo "<option value='$i' $selected>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="form-label" for="mes">Selecione o mês de competência:</label>
                                <select name="mes" id="mes" class="form-select" required>
                                    <!-- As opções do mês serão preenchidas pelo JavaScript -->
                                </select>
                            </div>
                            <div class="col-4">
                                <button style="margin-top: 30px;" class="btn btn-sm btn-danger" type="submit">Consultar</button>
                            </div>
                        </div>
                    </form>

                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $mes = $_POST['mes'];
                        $ano = $_POST['ano'];

                        try {
                            // Prepara a consulta SQL
                            $consulta = "SELECT
    e.id AS empresa_id,
    e.fantasia AS nome_empresa,
    s.service AS descricao_servico,
    cs.id AS id_servico,
    COALESCE(SUM(cr.seconds_worked), 0) AS segundos_trabalhados,
    CONCAT(
        FLOOR(COALESCE(SUM(cr.seconds_worked), 0) / 3600), 'h ',
        FLOOR((COALESCE(SUM(cr.seconds_worked), 0) % 3600) / 60), 'min ',
        (COALESCE(SUM(cr.seconds_worked), 0) % 60), 'seg'
    ) AS tempo_trabalhado_formatado,
    CONCAT(
        ROUND(COALESCE(SUM(cr.seconds_worked), 0) / 3600)
    ) AS tempo_trabalhado_arredondado,
    cs.contract_id AS contract_id
FROM contract_service cs
LEFT JOIN contract as con ON con.id = cs.contract_id
LEFT JOIN service s ON s.id = cs.service_id
LEFT JOIN empresas e ON e.id = con.empresa_id
LEFT JOIN chamados c ON c.service_id = cs.id
LEFT JOIN chamado_relato cr ON cr.chamado_id = c.id 
    AND MONTH(cr.relato_hora_inicial) = :mes
    AND YEAR(cr.relato_hora_inicial) = :ano
WHERE s.description IS NOT NULL  AND cs.active = 1
GROUP BY cs.id, e.id, e.fantasia, s.service, cs.contract_id
ORDER BY e.fantasia ASC";

                            // Prepara e executa a consulta
                            $stmt = $pdo->prepare($consulta);
                            $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
                            $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
                            $stmt->execute();

                            // Verifica se a consulta retornou resultados
                            if ($stmt->rowCount() > 0) { ?>

                                <br><br>
                                <table class="table table-striped">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th>Empresa</th>
                                            <th>Serviço</th>
                                            <th>ID Serviço</th>
                                            <th>Segundos Trabalhados</th>
                                            <th>Tempo Trabalhado</th>
                                            <th>Tempo Trabalhado Arred.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr style="vertical-align: middle; text-align: center;">
                                                <td><?= htmlspecialchars($row["nome_empresa"]) ?></td>
                                                <td><?= htmlspecialchars($row["descricao_servico"]) ?></td>
                                                <td><?= htmlspecialchars($row["id_servico"]) ?></td>
                                                <td><?= htmlspecialchars($row["segundos_trabalhados"]) ?></td>
                                                <td><?= htmlspecialchars($row["tempo_trabalhado_formatado"]) ?></td>
                                                <td><?= htmlspecialchars($row["tempo_trabalhado_arredondado"]) ?></td>
                                                <td>
                                                    <?php
                                                    $competencia = $mesSelecionado . $anoSelecionado;
                                                    $contrato_id = $row['contract_id'];
                                                    $servico_id = $row["id_servico"];

                                                    // Consulta SQL para verificar se já existe faturamento para a competência, contrato e serviço específicos
                                                    $consulta_faturamento =
                                                        "SELECT valor
                                                    FROM contrato_faturamento
                                                    WHERE competencia = :competencia
                                                      AND contrato_id = :contrato_id
                                                      AND servico_id = :servico_id";

                                                    // Preparando a consulta
                                                    $stmt_faturamento = $pdo->prepare($consulta_faturamento);
                                                    $stmt_faturamento->bindParam(':competencia', $competencia, PDO::PARAM_STR);
                                                    $stmt_faturamento->bindParam(':contrato_id', $contrato_id, PDO::PARAM_STR);
                                                    $stmt_faturamento->bindParam(':servico_id', $servico_id, PDO::PARAM_INT);
                                                    $stmt_faturamento->execute();

                                                    // Verificando se encontrou algum resultado
                                                    if ($stmt_faturamento->rowCount() > 0) {
                                                        // Recuperando o resultado da consulta
                                                        $resultado_faturamento = $stmt_faturamento->fetch(PDO::FETCH_ASSOC);
                                                        $valor_faturamento = $resultado_faturamento['valor'];

                                                        // Aqui você pode usar $valor_faturamento conforme necessário
                                                        echo "Valor Cobrança" . "<br>" . "R$: " . number_format($valor_faturamento, 2, ',', '.');


                                                    ?>
                                                    <?php } else {  ?>
                                                        <a href="processa/processa_faturamento.php?
                                                        mes=<?= $mesSelecionado ?>&
                                                        ano=<?= $anoSelecionado ?>&
                                                        contrato=<?= $row['contract_id'] ?>&
                                                        id_servico=<?= urlencode($row["id_servico"]) ?>&
                                                        tempo_arredondado=<?= urlencode($row["tempo_trabalhado_arredondado"]) ?>" class="btn-faturamento">
                                                            Gerar Faturamento
                                                        </a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                    <?php } else {
                                echo "<p>Nenhum resultado encontrado para o mês $mes/$ano.</p>";
                            }
                        } catch (PDOException $e) {
                            echo "Erro na consulta: " . $e->getMessage();
                        }
                    }
                    ?>

                </div>
            </div>
        </section>
    </main>


    <script>
        // Adiciona um evento de clique aos botões de "Gerar Faturamento"
        document.querySelectorAll('.btn-faturamento').forEach(button => {
            button.addEventListener('click', function() {
                // Captura os dados da linha atual
                const empresa = this.getAttribute('data-empresa');
                const idServico = this.getAttribute('data-id-servico');
                const tempoArredondado = this.getAttribute('data-tempo-arredondado');

                // Envia os dados via AJAX para o arquivo processa_faturamento.php
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'processa/processa_faturamento.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    // Lida com a resposta do servidor, se necessário
                    if (xhr.status >= 200 && xhr.status < 400) {
                        // Aqui você pode lidar com a resposta, se houver
                        console.log(xhr.responseText);
                    }
                };
                // Formata os dados para enviar
                const data = `empresa=${encodeURIComponent(empresa)}&id_servico=${encodeURIComponent(idServico)}&tempo_arredondado=${encodeURIComponent(tempoArredondado)}`;
                // Envia a requisição
                xhr.send(data);
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const mesSelect = document.getElementById("mes");
            const anoSelect = document.getElementById("ano");

            // Função para preencher as opções do mês
            function preencherMeses() {
                const meses = [
                    "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
                    "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
                ];
                const anoSelecionado = parseInt(anoSelect.value);
                const mesAtual = new Date().getMonth() + 1; // getMonth retorna 0-11

                // Limpa as opções atuais
                mesSelect.innerHTML = "<option selected disabled value=''>Selecione uma opção</option>";

                // Preenche as opções com base no ano selecionado
                const limiteMes = (anoSelecionado === <?= $anoAtual ?>) ? mesAtual : 12;

                for (let i = 1; i <= limiteMes; i++) {
                    const selected = (i == <?= json_encode($mesSelecionado) ?>) ? 'selected' : '';
                    mesSelect.innerHTML += `<option value="${i}" ${selected}>${meses[i - 1]}</option>`;
                }
            }

            // Inicializa as opções do mês ao carregar a página
            preencherMeses();

            // Atualiza as opções do mês quando o ano é alterado
            anoSelect.addEventListener("change", preencherMeses);
        });
    </script>

<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>