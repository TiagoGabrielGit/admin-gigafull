<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$submenu_id = "69";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";
$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();
$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

$orcamento_id = $_GET['id'];

$consulta_orcamento = "
    SELECT o.orcamento
    FROM cc_orcamento as o
    WHERE o.id = :orcamento_id AND o.created_by = :uid
";

$exec_consulta_orcamento = $pdo->prepare($consulta_orcamento);
$exec_consulta_orcamento->bindParam(':orcamento_id', $orcamento_id, PDO::PARAM_INT);
$exec_consulta_orcamento->bindParam(':uid', $uid, PDO::PARAM_INT);
$exec_consulta_orcamento->execute();

if ($rowCount_permissions_submenu > 0 & $exec_consulta_orcamento->rowCount() > 0) {
    $resultado = $exec_consulta_orcamento->fetch(PDO::FETCH_ASSOC);
    $orcamento = $resultado['orcamento'];

    // Recuperar filtros
    $agrupamento_filter = filter_input(INPUT_POST, 'filtro_agrupamento', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '%';
    $centro_de_custo_filter = filter_input(INPUT_POST, 'filtro_centro_de_custo', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '%';
    $categoria_filter = filter_input(INPUT_POST, 'filtro_categoria', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '%';
    $mes_competencia_filter = filter_input(INPUT_POST, 'filtro_mes_competencia', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '%';
    $ano_competencia_filter = filter_input(INPUT_POST, 'filtro_ano_competencia', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '%';

?>

    <style>
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
    </style>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Orçamento - <?= $orcamento ?></h1>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <h5 class="card-title">Filtros</h5>
                        </div>
                        <div class="col-2">
                            <a href="/financeiro/orcamento/orcamentos/index.php">
                                <button style="margin-top: 15px;" class="btn btn-sm btn-danger" type="button">Voltar à Orçamentos</button>
                            </a>
                        </div>
                    </div>

                    <form action="#" method="POST">

                        <div class="row">

                            <div class="col-4">
                                <label class="form-label" for="filtro_agrupamento">Agrupamento</label>
                                <select id="filtro_agrupamento" name="filtro_agrupamento" class="form-select">
                                    <option value="%">Todos</option>
                                    <?php
                                    // Preencher o select com agrupamentos
                                    $sql = "SELECT id, agrupamento FROM cc_agrupamentos ORDER BY agrupamento ASC";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        // Verifica se o valor do filtro é igual ao valor atual do loop
                                        $selected = (isset($agrupamento_filter) && $agrupamento_filter == $row['id']) ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($row['id']) . "' $selected>" . htmlspecialchars($row['agrupamento']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-4">
                                <label class="form-label" for="filtro_categoria">Categoria</label>
                                <select id="filtro_categoria" name="filtro_categoria" class="form-select">
                                    <option value="%">Todos</option>
                                    <?php
                                    // Preencher o select com categorias
                                    $sql = "SELECT id, categoria FROM cc_categoria ORDER BY categoria ASC";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        // Verifica se o valor do filtro é igual ao valor atual do loop
                                        $selected = (isset($categoria_filter) && $categoria_filter == $row['id']) ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($row['id']) . "' $selected>" . htmlspecialchars($row['categoria']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-4">
                                <label class="form-label" for="filtro_centro_de_custo">Centro de Custo</label>
                                <select id="filtro_centro_de_custo" name="filtro_centro_de_custo" class="form-select">
                                    <option value="%">Todos</option>
                                    <?php
                                    // Preencher o select com centros de custo
                                    $sql = "SELECT id, centro_de_custo FROM cc_centro_de_custo ORDER BY centro_de_custo ASC";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        // Verifica se o valor do filtro é igual ao valor atual do loop
                                        $selected = (isset($centro_de_custo_filter) && $centro_de_custo_filter == $row['id']) ? 'selected' : '';
                                        echo "<option value='" . htmlspecialchars($row['id']) . "' $selected>" . htmlspecialchars($row['centro_de_custo']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-4">
                                <label class="form-label" for="filtro_mes_competencia">Mês Competência</label>
                                <select id="filtro_mes_competencia" name="filtro_mes_competencia" class="form-select">
                                    <option value="%">Todos</option>
                                    <?php
                                    $meses = [
                                        "01" => "Janeiro",
                                        "02" => "Fevereiro",
                                        "03" => "Março",
                                        "04" => "Abril",
                                        "05" => "Maio",
                                        "06" => "Junho",
                                        "07" => "Julho",
                                        "08" => "Agosto",
                                        "09" => "Setembro",
                                        "10" => "Outubro",
                                        "11" => "Novembro",
                                        "12" => "Dezembro"
                                    ];
                                    foreach ($meses as $num => $nome) {
                                        // Verifica se o valor do filtro é igual ao valor atual do loop
                                        $selected = (isset($mes_competencia_filter) && $mes_competencia_filter == $num) ? 'selected' : '';
                                        echo "<option value='$num' $selected>$nome</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-4">
                                <label class="form-label" for="filtro_ano_competencia">Ano Competência</label>
                                <select id="filtro_ano_competencia" name="filtro_ano_competencia" class="form-select">
                                    <option value="%">Todos</option>
                                    <?php
                                    $ano_atual = date("Y");
                                    $ano_final = $ano_atual + 5;
                                    for ($year = $ano_atual; $year <= $ano_final; $year++) {
                                        // Verifica se o valor do filtro é igual ao valor atual do loop
                                        $selected = (isset($ano_competencia_filter) && $ano_competencia_filter == $year) ? 'selected' : '';
                                        echo "<option value='$year' $selected>$year</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <br><br>
                            <div class="text-center">
                                <br><br>
                                <button type="submit" class="btn btn-sm btn-danger">Aplicar Filtro</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <h5 class="card-title">Orçados</h5>

                        </div>
                        <div class="col-lg-2">
                            <button style="margin-top: 15px;" type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal_inserir_orcamento">Inserir Novo</button>
                        </div>
                    </div>
                    <br>
                    <?php
                    // Construir a consulta com base nos filtros
                    $sql = "SELECT
                        o.id,
                        a.agrupamento,
                        c.categoria,
                        cc.centro_de_custo,
                        o.descricao,
                        o.fornecedor,
                        o.orcado,
                        o.mes_competencia,
                        o.ano_competencia
                    FROM cc_orcamentos o
                    JOIN cc_agrupamentos a ON o.agrupamento = a.id
                    JOIN cc_categoria c ON o.categoria = c.id
                    JOIN cc_centro_de_custo cc ON o.centro_de_custo = cc.id
                    WHERE (a.id LIKE :agrupamento)
                      AND (cc.id LIKE :centro_de_custo)
                      AND (c.id LIKE :categoria)
                      AND (o.mes_competencia LIKE :mes_competencia)
                      AND (o.ano_competencia LIKE :ano_competencia)
                      AND o.orcamento_id = :orcamento_id
                    ORDER BY o.mes_competencia ASC, ano_competencia ASC";

                    $stmt = $pdo->prepare($sql);

                    // Bind dos parâmetros
                    $stmt->bindParam(':agrupamento', $agrupamento_filter, PDO::PARAM_STR);
                    $stmt->bindParam(':centro_de_custo', $centro_de_custo_filter, PDO::PARAM_STR);
                    $stmt->bindParam(':categoria', $categoria_filter, PDO::PARAM_STR);
                    $stmt->bindParam(':mes_competencia', $mes_competencia_filter, PDO::PARAM_STR);
                    $stmt->bindParam(':ano_competencia', $ano_competencia_filter, PDO::PARAM_STR);
                    $stmt->bindParam(':orcamento_id', $orcamento_id, PDO::PARAM_STR);

                    $stmt->execute();
                    ?>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr style="text-align: center;">
                                <th scope="col">Agrupamento</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Centro de Custo</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Fornecedor</th>
                                <th scope="col">Orçado</th>
                                <th scope="col">Mês Competência</th>
                                <th scope="col">Ano Competência</th>
                                <th scope="col">Ações</th> <!-- Nova coluna para botões -->

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalOrcado = 0; // Inicializa o total

                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $orcado = $row['orcado'];
                                $totalOrcado += $orcado; // Adiciona o valor ao total

                                echo "<tr style='vertical-align: middle; text-align: center;'>";
                                echo "<td>" . htmlspecialchars($row['agrupamento']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['categoria']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['centro_de_custo']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['descricao']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['fornecedor']) . "</td>";
                                echo "<td>R$ " . number_format($orcado, 2, ',', '.') . "</td>";
                                echo "<td>" . htmlspecialchars($row['mes_competencia']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['ano_competencia']) . "</td>";
                                echo "<td>
                            <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modal_editar_orcamento' data-id='" . htmlspecialchars($row['id']) . "'>Editar</button>
                            <button class='btn btn-danger btn-sm' onclick='confirmDelete(" . htmlspecialchars($row['id']) . ")'>Excluir</button>
                        </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr style="text-align: center;">
                                <td colspan="5"><strong>Total</strong></td>
                                <td><strong>R$ <?php echo number_format($totalOrcado, 2, ',', '.'); ?></strong></td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>


                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="modal_inserir_orcamento" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inserir Orçado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="processa/novo_orcado.php">
                        <input hidden readonly id="orcamento_id" name="orcamento_id" value="<?= $orcamento_id ?>">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="agrupamento">Agrupamento</label>
                                <select required class="form-select" id="agrupamento" name="agrupamento">
                                    <option disabled selected value="">Selecione</option>
                                    <?php
                                    // Consulta para buscar os agrupamentos
                                    $sql = "SELECT id, agrupamento FROM cc_agrupamentos WHERE active = 1 ORDER BY agrupamento ASC";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();

                                    // Loop para preencher o select com os agrupamentos
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['agrupamento']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="centro_de_custo">Centro de Custo</label>
                                <select required class="form-select" id="centro_de_custo" name="centro_de_custo">
                                    <option disabled selected value="">Selecione</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="categoria">Categoria</label>
                                <select required class="form-select" id="categoria" name="categoria">
                                    <option disabled selected value="">Selecione</option>
                                    <?php
                                    $sql = "SELECT id, categoria FROM cc_categoria WHERE active = 1 ORDER BY categoria ASC";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['categoria']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="descricao">Descrição</label>
                                <input required id="descricao" name="descricao" class="form-control">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-9">
                                <label class="form-label" for="fornecedor">Fornecedor</label>
                                <input required id="fornecedor" name="fornecedor" class="form-control">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label" for="mes_competencia">Mês Competência</label>
                                <select required class="form-select" id="mes_competencia" name="mes_competencia">
                                    <option disabled selected value="">Selecione</option>
                                    <?php
                                    $meses = [
                                        "01" => "Janeiro",
                                        "02" => "Fevereiro",
                                        "03" => "Março",
                                        "04" => "Abril",
                                        "05" => "Maio",
                                        "06" => "Junho",
                                        "07" => "Julho",
                                        "08" => "Agosto",
                                        "09" => "Setembro",
                                        "10" => "Outubro",
                                        "11" => "Novembro",
                                        "12" => "Dezembro"
                                    ];
                                    foreach ($meses as $num => $nome) {
                                        echo "<option value='$num'>$nome</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-4">
                                <label class="form-label" for="ano_competencia">Ano Competência</label>
                                <select required class="form-select" id="ano_competencia" name="ano_competencia">
                                    <option disabled selected value="">Selecione</option>
                                    <?php
                                    $ano_atual = date("Y");
                                    $ano_final = $ano_atual + 5;
                                    for ($year = $ano_atual; $year <= $ano_final; $year++) {
                                        echo "<option value='$year'>$year</option>";
                                    }
                                    ?>
                                </select>
                            </div>


                            <div class="col-4">
                                <label class="form-label" for="orcado">Orçado</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="orcado">R$</span>
                                    <input type="text" class="form-control" id="orcado" name="orcado">
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-danger">Salvar</button>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div><!-- End Large Modal-->

    <div class="modal fade" id="modal_editar_orcamento" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Orçamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_editar_orcamento" method="POST" action="processa/editar_orcamento.php">
                        <input type="hidden" id="orcamento_id" name="orcamento_id">

                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="descricao-edit">Descrição</label>
                                <input class="form-control" required id="descricao-edit" name="descricao-edit">
                            </div>

                            <div class="col-6">
                                <label class="form-label" for="fornecedor-edit">Fornecedor</label>
                                <input class="form-control" required id="fornecedor-edit" name="fornecedor-edit">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label" for="mes_competencia-edit">Mês Competência</label>
                                <select required class="form-select" id="mes_competencia-edit" name="mes_competencia-edit">
                                    <option disabled value="">Selecione</option>
                                    <?php
                                    $meses = [
                                        "01" => "Janeiro",
                                        "02" => "Fevereiro",
                                        "03" => "Março",
                                        "04" => "Abril",
                                        "05" => "Maio",
                                        "06" => "Junho",
                                        "07" => "Julho",
                                        "08" => "Agosto",
                                        "09" => "Setembro",
                                        "10" => "Outubro",
                                        "11" => "Novembro",
                                        "12" => "Dezembro"
                                    ];
                                    foreach ($meses as $num => $nome) {
                                        echo "<option value='$num'>$nome</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-4">
                                <label class="form-label" for="ano_competencia-edit">Ano Competência</label>
                                <select required class="form-select" id="ano_competencia-edit" name="ano_competencia-edit">
                                    <option disabled value="">Selecione</option>
                                    <?php
                                    // Preencher com uma gama de anos, por exemplo, de 2020 a 2030
                                    $anoAtual = date('Y');
                                    for ($ano = $anoAtual - 10; $ano <= $anoAtual + 10; $ano++) {
                                        echo "<option value='$ano'>$ano</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="orcado-edit">Orçado</label>
                                <input id="orcado-edit" name="orcado-edit" class="form-control">
                            </div>
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-danger">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Função para confirmar a exclusão
        function confirmDelete(id) {
            if (confirm('Tem certeza que deseja excluir este orçamento?')) {
                window.location.href = 'processa/excluir_orcamento.php?id=' + id;
            }
        }

        // Preencher o modal de edição com os dados
        document.getElementById('modal_editar_orcamento').addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Botão que acionou o modal
            var id = button.getAttribute('data-id'); // Obter o ID do orçamento

            var form = document.getElementById('form_editar_orcamento');
            form.querySelector('#orcamento_id').value = id;

            // Opcional: Carregar dados do orçamento via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'processa/get_orcamento.php?id=' + id, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    var orcamento = JSON.parse(this.responseText);
                    document.getElementById('orcado-edit').value = orcamento.orcado;
                    document.getElementById('descricao-edit').value = orcamento.descricao;
                    document.getElementById('fornecedor-edit').value = orcamento.fornecedor;

                    // Preencher o select com todos os meses e selecionar o mês de competência
                    var mesSelect = document.getElementById('mes_competencia-edit');
                    for (var i = 0; i < mesSelect.options.length; i++) {
                        if (mesSelect.options[i].value === orcamento.mes_competencia) {
                            mesSelect.options[i].selected = true;
                        }
                    }

                    // Preencher o select com todos os anos e selecionar o ano de competência
                    var anoSelect = document.getElementById('ano_competencia-edit');
                    for (var i = 0; i < anoSelect.options.length; i++) {
                        if (anoSelect.options[i].value === orcamento.ano_competencia) {
                            anoSelect.options[i].selected = true;
                        }
                    }
                }
            };
            xhr.send();
        });
    </script>




    <script>
        document.getElementById('agrupamento').addEventListener('change', function() {
            var agrupamentoId = this.value;
            var centroDeCustoSelect = document.getElementById('centro_de_custo');

            // Limpar o select de centros de custo
            centroDeCustoSelect.innerHTML = '<option disabled selected value="">Selecione</option>';

            if (agrupamentoId) {
                // Fazer a requisição Ajax para buscar os centros de custo
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'processa/get_centros_de_custo.php?agrupamento_id=' + agrupamentoId, true);
                xhr.onload = function() {
                    if (this.status === 200) {
                        var centrosDeCusto = JSON.parse(this.responseText);
                        centrosDeCusto.forEach(function(centro) {
                            var option = document.createElement('option');
                            option.value = centro.id;
                            option.textContent = centro.nome;
                            centroDeCustoSelect.appendChild(option);
                        });
                    }
                };
                xhr.send();
            }
        });
    </script>
<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>