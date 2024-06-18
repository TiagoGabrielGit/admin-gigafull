<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$submenu_id = "60"; // ID do submenu específico
$uid = $_SESSION['id']; // ID do usuário logado

// Consulta para verificar permissões do usuário
$permissions_query = "SELECT u.perfil_id
                      FROM usuarios u
                      JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
                      WHERE u.id = :uid AND pp.url_submenu = :submenu_id";

$exec_permissions = $pdo->prepare($permissions_query);
$exec_permissions->bindValue(':uid', $uid, PDO::PARAM_INT);
$exec_permissions->bindValue(':submenu_id', $submenu_id, PDO::PARAM_INT);
$exec_permissions->execute();

if ($exec_permissions->rowCount() > 0) {
    // Se o usuário tem permissão, carregamos a tarefa e suas despesas
    $tarefa_id = isset($_GET['id']) ? (int) $_GET['id'] : 0; // Obtenção do ID da tarefa via GET

    // Consulta para buscar a tarefa
    $consulta_tarefa = "SELECT * FROM tarefas WHERE id = :tarefa_id";
    $stmt_tarefa = $pdo->prepare($consulta_tarefa);
    $stmt_tarefa->bindValue(':tarefa_id', $tarefa_id, PDO::PARAM_INT);
    $stmt_tarefa->execute();
    $tarefa = $stmt_tarefa->fetch(PDO::FETCH_ASSOC);

    // Consulta para buscar as despesas associadas às subcategorias ativas e à tarefa específica
    $busca_valores = "SELECT qd.id, qs.descricao AS subcategoria, qc.descricao AS categoria, qd.valor
                      FROM qt_despesas qd
                      LEFT JOIN qt_subcategoria qs ON qd.id_subcategoria = qs.id
                      LEFT JOIN qt_categorias qc ON qc.id = qs.id_categoria
                      WHERE qd.active = 1 AND qd.id_tarefa = :tarefa_id";

    $stmt = $pdo->prepare($busca_valores);
    $stmt->bindValue(':tarefa_id', $tarefa_id, PDO::PARAM_INT);
    $stmt->execute();
    $despesas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <main id="main" class="main">
        <section class="section">
            <div class="pagetitle">
                <h1>Despesas da Tarefa - <?= htmlspecialchars($tarefa['descricao']); ?></h1>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9"></div>
                        <div class="col-3">
                            <a href="/quadros_tarefas/tarefas/index.php?id=<?= $tarefa_id ?>">
                                <button style="margin-top: 15px; width: 80%;" class="btn btn-sm btn-danger">Voltar a Tarefa</button>
                            </a>
                            <button style="margin-top: 15px; width: 80%;" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalAdicionarValor">Adicionar Valor</button>
                        </div>
                    </div>
                    <br>
                    <table class="table table-striped">
                        <thead>
                            <tr style="text-align: center;">
                                <th scope="col">Categorias</th>
                                <th scope="col">Subcategoria</th>
                                <th scope="col">Valor</th>
                                <th scope="col"></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Itera sobre cada despesa e exibe na tabela
                            if ($despesas) {
                                foreach ($despesas as $despesa) {
                            ?>
                                    <tr style="vertical-align: middle; text-align: center;">
                                        <td><?= htmlspecialchars($despesa['categoria']) ?></td>
                                        <td><?= htmlspecialchars($despesa['subcategoria']) ?></td>
                                        <td>R$ <?= number_format($despesa['valor'], 2, ',', '.') ?></td>
                                        <td>
                                            <a href="processa/inativar_despesa.php?id=<?= $despesa['id'] ?>" onclick="return confirm('Tem certeza que deseja remover esta despesa?');">
                                                <button title="Remover Despesa" type="button" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </a>

                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                // Caso não haja despesas, exibe uma linha indicando isso
                                ?>
                                <tr style="text-align: center;">
                                    <td colspan="4">Nenhuma despesa ativa encontrada.</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal para Adicionar Valor -->
    <div class="modal fade" id="modalAdicionarValor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Despesa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="processa/adicionar_despesa.php">
                    <div class="modal-body">
                        <div class="row">
                            <input id="tarefa_id" name="tarefa_id" hidden readonly value="<?= $tarefa_id ?>">
                            <div class="col-4">
                                <label for="categoria" class="form-label">Categoria</label>
                                <select class="form-select" id="categoria" name="categoria" required onchange="buscarSubcategorias(this.value)">
                                    <option disabled selected value="">Selecione uma opção</option>
                                    <?php
                                    $categoria_query = "SELECT id, descricao FROM qt_categorias WHERE active = 1 ORDER BY descricao ASC";
                                    $stmt_categorias = $pdo->prepare($categoria_query);
                                    $stmt_categorias->execute();
                                    $categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($categorias as $categoria) {
                                        echo '<option value="' . htmlspecialchars($categoria['id']) . '">' . htmlspecialchars($categoria['descricao']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="subcategoria" class="form-label">Subcategoria</label>
                                <select class="form-select" id="subcategoria" name="subcategoria" required>
                                    <option disabled selected value="">Selecione uma categoria</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="valor" class="form-label">Valor</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">R$</span>
                                    <input type="text" class="form-control" id="valor" name="valor" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-danger">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        function formatarValor() {
            var valorInput = document.getElementById('valor');
            var valor = valorInput.value;

            // Remover pontos e substituir a vírgula pelo ponto
            valor = valor.replace(/\./g, '').replace(',', '.');

            // Atualizar o valor no input
            valorInput.value = valor;

            return true;
        }
    </script>

    <script>
        function buscarSubcategorias(categoriaId) {
            // Limpar as opções atuais do select de subcategorias
            var subcategoriaSelect = document.getElementById("subcategoria");
            subcategoriaSelect.innerHTML = '<option disabled selected value="">Carregando...</option>';

            // Fazer uma requisição AJAX para obter as subcategorias da categoria selecionada
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'processa/buscar_subcategorias.php?categoria_id=' + categoriaId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var subcategorias = JSON.parse(xhr.responseText);

                    // Limpar o select de subcategorias
                    subcategoriaSelect.innerHTML = '';

                    // Adicionar a opção inicial "Selecione uma opção" (desabilitada)
                    var optionInicial = document.createElement('option');
                    optionInicial.value = '';
                    optionInicial.textContent = 'Selecione uma opção';
                    optionInicial.disabled = true;
                    optionInicial.selected = true;
                    subcategoriaSelect.appendChild(optionInicial);

                    // Adicionar as opções de subcategorias
                    subcategorias.forEach(function(subcategoria) {
                        var option = document.createElement('option');
                        option.value = subcategoria.id;
                        option.textContent = subcategoria.descricao;
                        subcategoriaSelect.appendChild(option);
                    });
                } else {
                    // Em caso de erro na requisição AJAX
                    console.error('Erro ao buscar subcategorias. Status: ' + xhr.status);
                    subcategoriaSelect.innerHTML = '<option disabled selected value="">Erro ao carregar subcategorias</option>';
                }
            };
            xhr.send();
        }
    </script>
<?php
} else {
    // Caso o usuário não tenha permissão
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}

require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>