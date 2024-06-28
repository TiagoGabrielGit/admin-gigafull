<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

// Identificação do menu e do usuário
$menu_id = "1";
$uid = $_SESSION['id'];

// Verificação de permissões do usuário
$permissions = "
    SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_menu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = :uid AND pp.url_menu = :menu_id
";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->bindParam(':uid', $uid, PDO::PARAM_INT);
$exec_permissions->bindParam(':menu_id', $menu_id, PDO::PARAM_STR);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {
    // Obter o ID do serviço da URL e validar
    $idServico = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($idServico) {
        // Consulta para buscar informações do contrato e serviço associado
        $busca_informacoes = "
            SELECT 
                cs.id AS idServico, 
                c.id AS idContrato, 
                e.fantasia AS nomeEmpresa, 
                c.active AS statusContrato,
                s.service as service,
                cs.tipo_cobranca as tipoCobranca,
                cs.valor_hora as valorHora,
                cs.valor_mensal as valorMensal,
                cs.valor_fixo as valorFixo,
                cs.horas_inclusas as horasInclusas,
                cs.valor_hora_excedente as valorHoraExcedente
            FROM contract_service AS cs
            LEFT JOIN contract AS c ON c.id = cs.contract_id
            LEFT JOIN empresas AS e ON e.id = c.empresa_id
            LEFT JOIN service as s ON s.id = cs.service_id
            WHERE cs.id = :servico_id
        ";

        $stmt = $pdo->prepare($busca_informacoes);
        $stmt->bindParam(':servico_id', $idServico, PDO::PARAM_INT);
        $stmt->execute();
        $informacoes = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($informacoes) {
            // Formatar os valores para exibição
            $valorHoraFormatado = $informacoes['valorHora'] !== null ? number_format($informacoes['valorHora'], 2, ',', '') : '';
            $valorMensalFormatado = $informacoes['valorMensal'] !== null ? number_format($informacoes['valorMensal'], 2, ',', '') : '';
            $valorFixoFormatado = $informacoes['valorFixo'] !== null ? number_format($informacoes['valorFixo'], 2, ',', '') : '';
            $horasInclusasFormatado = $informacoes['horasInclusas'] !== null ? $informacoes['horasInclusas'] : '';
            $valorHoraExcedenteFormatado = $informacoes['valorHoraExcedente'] !== null ? number_format($informacoes['valorHoraExcedente'], 2, ',', '') : '';
?>

            <main id="main" class="main">
                <section class="section">
                    <div class="pagetitle">
                        <h1>Contrato #<?= htmlspecialchars($informacoes['idContrato']) . ' - ' . htmlspecialchars($informacoes['nomeEmpresa']) . ' - ' . htmlspecialchars($informacoes['service']) ?></h1>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-10">
                                    <h5 class="card-title">Detalhes do Contrato</h5>
                                </div>

                                <div class="col-2">
                                    <br>
                                    <a href="/contrato/view_info.php?id=<?= htmlspecialchars($informacoes['idContrato']) ?>">
                                        <button type="button" class="btn btn-sm btn-danger">Voltar ao Contrato</button>
                                    </a>
                                </div>
                            </div>

                            <form action="processa/atualizar_servico.php" method="post">
                                <!-- Adicionar campo hidden para enviar o idServico -->
                                <input type="hidden" name="id_servico" value="<?= htmlspecialchars($informacoes['idServico']) ?>">

                                <div class="row">
                                    <div class="col-4">
                                        <label for="empresa" class="form-label">Empresa</label>
                                        <input disabled readonly class="form-control" value="<?= htmlspecialchars($informacoes['nomeEmpresa']) ?>">
                                    </div>

                                    <div class="col-4">
                                        <label for="servico" class="form-label">Serviço</label>
                                        <input disabled readonly class="form-control" value="<?= htmlspecialchars($informacoes['service']) ?>">
                                    </div>

                                    <div class="col-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" name="status" id="status">
                                            <option value="1" <?= $informacoes['statusContrato'] == 1 ? 'selected' : '' ?>>Ativado</option>
                                            <option value="0" <?= $informacoes['statusContrato'] == 0 ? 'selected' : '' ?>>Inativado</option>
                                        </select>
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-3">
                                        <label for="tipo_cobranca" class="form-label">Tipo de Cobrança</label>
                                        <select class="form-select" name="tipo_cobranca" id="tipo_cobranca" onchange="atualizaCamposCobranca()">
                                            <option value="1" <?= $informacoes['tipoCobranca'] == 1 ? 'selected' : '' ?>>Isento</option>
                                            <option value="2" <?= $informacoes['tipoCobranca'] == 2 ? 'selected' : '' ?>>Recorrente Mensal</option>
                                            <option value="3" <?= $informacoes['tipoCobranca'] == 3 ? 'selected' : '' ?>>Hora Trabalhada</option>
                                            <option value="4" <?= $informacoes['tipoCobranca'] == 4 ? 'selected' : '' ?>>Fixo + Hora Excedente</option>
                                        </select>
                                    </div>

                                    <div class="col-3" id="campo_valor_hora" style="display: none;">
                                        <label for="valor_hora" class="form-label">Valor da Hora</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">R$</span>
                                            <input type="text" class="form-control" id="valor_hora" name="valor_hora" value="<?= htmlspecialchars($valorHoraFormatado) ?>">
                                        </div>
                                    </div>

                                    <div class="col-3" id="campo_valor_mensal" style="display: none;">
                                        <label for="valor_mensal" class="form-label">Valor Mensal</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">R$</span>
                                            <input type="text" class="form-control" id="valor_mensal" name="valor_mensal" value="<?= htmlspecialchars($valorMensalFormatado) ?>">
                                        </div>
                                    </div>
                                    
                                    <div id="campo_fixo_hora_excedente" style="display: none;">
                                    <br>
                                        <div class="row">
                                            <div class="col-2">
                                                <label for="valor_fixo" class="form-label">Valor Fixo</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">R$</span>
                                                    <input type="text" class="form-control" id="valor_fixo" name="valor_fixo" value="<?= htmlspecialchars($valorFixoFormatado) ?>">
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <label for="horas_inclusas" class="form-label">Horas Inclusas</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="horas_inclusas" name="horas_inclusas" value="<?= htmlspecialchars($horasInclusasFormatado) ?>">
                                                    <span class="input-group-text">horas</span>
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <label for="valor_hora_excedente" class="form-label">Valor Hora Excedente</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">R$</span>
                                                    <input type="text" class="form-control" id="valor_hora_excedente" name="valor_hora_excedente" value="<?= htmlspecialchars($valorHoraExcedenteFormatado) ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </section>
            </main>

            <script>
                // Função para atualizar a visibilidade dos campos de cobrança
                function atualizaCamposCobranca() {
                    const tipoCobranca = document.getElementById('tipo_cobranca').value;
                    const campoValorHora = document.getElementById('campo_valor_hora');
                    const campoValorMensal = document.getElementById('campo_valor_mensal');
                    const campoFixoHoraExcedente = document.getElementById('campo_fixo_hora_excedente');

                    // Esconder todos os campos de cobrança inicialmente
                    campoValorHora.style.display = 'none';
                    campoValorMensal.style.display = 'none';
                    campoFixoHoraExcedente.style.display = 'none';

                    // Exibir os campos apropriados com base no tipo de cobrança selecionado
                    switch (tipoCobranca) {
                        case '1':
                            // Isento
                            break;
                        case '2':
                            // Recorrente Mensal
                            campoValorMensal.style.display = 'block';
                            break;
                        case '3':
                            // Hora Trabalhada
                            campoValorHora.style.display = 'block';
                            break;
                        case '4':
                            // Fixo + Hora Excedente
                            campoFixoHoraExcedente.style.display = 'block';
                            break;
                    }
                }

                // Chamar a função para definir o estado inicial dos campos
                document.addEventListener('DOMContentLoaded', function() {
                    atualizaCamposCobranca();
                });
            </script>

<?php
        } else {
            // Exibir mensagem caso as informações do serviço não sejam encontradas
            echo "<p>Informações do serviço não encontradas.</p>";
        }
    } else {
        // Exibir mensagem caso o ID do serviço seja inválido
        echo "<p>ID de serviço inválido.</p>";
    }
} else {
    // Redirecionar para a página de acesso negado se o usuário não tiver permissão
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}

// Incluir rodapé de segurança
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>