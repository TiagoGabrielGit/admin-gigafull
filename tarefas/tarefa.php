<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$menu_id = "29";
$uid = $_SESSION['id'];

$permissions_menu =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_menu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_menu = $menu_id";
$exec_permissions_menu = $pdo->prepare($permissions_menu);
$exec_permissions_menu->execute();

$rowCount_permissions_menu = $exec_permissions_menu->rowCount();

if ($rowCount_permissions_menu > 0) {
    $tarefa_id = $_GET['id'];

    $consulta_tarefa =
        "SELECT *
FROM tarefas
WHERE id = :tarefa_id
";

    $stmt_tarefa = $pdo->prepare($consulta_tarefa);
    $stmt_tarefa->execute(['tarefa_id' => $tarefa_id]);
    $tarefa = $stmt_tarefa->fetch(PDO::FETCH_ASSOC);
?>

    <main id="main" class="main">
        <section class="section">
            <div class="pagetitle">
                <h1>Tarefa - <?php echo htmlspecialchars($tarefa['descricao']); ?></h1>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-9">
                            <h3 class="card-title">Detalhes da Tarefa</h3>
                        </div>
                        <div class="col-3">
                            <!-- Botão "Voltar ao Quadro" -->
                            <a href="/tarefas/quadros.php?id=<?= $tarefa['quadro_id'] ?>">
                                <button style="margin-top: 15px; width: 50%;" class="btn btn-sm btn-danger">Voltar ao Quadro</button>
                            </a>
                            <br>
                            <!-- Botão "Anexos" -->
                            <button type="button" style="margin-top: 15px; width: 50%;" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalAnexos">Anexos</button>
                        </div>


                        <div class="modal fade" id="modalAnexos" tabindex="-1" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Anexos</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <form action="upload.php" method="POST" id="uploadForm" enctype="multipart/form-data">
                                            <input id="uploadTarefaID" name="uploadTarefaID" value="<?= $tarefa_id ?>" hidden readonly></input>
                                            <div class="col-lg-12 row">
                                                <div class="col-8">
                                                    <input title="Permitido: jpg, jpeg, png, txt, pdf, csv, xlsx, docx" required class="form-control" type="file" name="fileInput" id="fileInput" multiple>
                                                </div>
                                                <div class="col-4" style="margin-top: 5px;">
                                                    <button class="btn btn-sm btn-danger" type="submit">Enviar</button>
                                                </div>
                                            </div>
                                        </form>
                                        <?php
                                        function getProtocol()
                                        {
                                            return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
                                        }

                                        function getRootDomain($host)
                                        {
                                            $hostParts = explode('.', $host);
                                            $count = count($hostParts);

                                            if ($count > 2) {
                                                if (strlen($hostParts[$count - 2]) <= 3 && strlen($hostParts[$count - 1]) <= 3) {
                                                    return $hostParts[$count - 3] . '.' . $hostParts[$count - 2] . '.' . $hostParts[$count - 1];
                                                }
                                            }

                                            return $hostParts[$count - 2] . '.' . $hostParts[$count - 1];
                                        }

                                        $protocol = getProtocol();
                                        $fullDomain = $_SERVER['HTTP_HOST'];
                                        $rootDomain = getRootDomain($fullDomain);

                                        $finalUrl = $protocol . '://smartuploads.' . $rootDomain;

                                        // Caminho do diretório local onde os arquivos estão armazenados
                                        $localDirectory = '../../uploads/tarefas/tarefa' . $tarefa_id . '/';

                                        // URL base para acessar os arquivos através do novo domínio
                                        $baseURL = $finalUrl . '/tarefas/tarefa' . $tarefa_id . '/';

                                        if (file_exists($localDirectory) && is_dir($localDirectory)) {
                                            $files = scandir($localDirectory);
                                            if ($files !== false) {
                                                echo '<br><ul>';
                                                foreach ($files as $file) {
                                                    if ($file != '.' && $file != '..') {
                                                        // Exiba os arquivos como links para download com a URL correta
                                                        echo '<li><a href="' . $baseURL . rawurlencode($file) . '" target="_blank">' . htmlspecialchars($file) . '</a></li>';
                                                    }
                                                }
                                                echo '</ul>';
                                            } else {
                                                echo '<br>Nenhum arquivo encontrado.';
                                            }
                                        } else {
                                            echo '<br>Nenhum arquivo encontrado.';
                                        }
                                        ?>


                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <form action="update_tarefa.php" method="POST">
                        <input hidden readonly name="tarefa_id" value="<?= $tarefa['id'] ?>">

                        <div class="row">
                            <div class="col-6">
                                <label for="descricao" class="form-label">Descrição</label>
                                <input class="form-control" id="descricao" name="descricao" value="<?= $tarefa['descricao'] ?>"></input>
                            </div>
                            <div class="col-2">
                                <label for="orcamento" class="form-label">Orçamento</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">R$</span>

                                    <input type="text" class="form-control" id="orcamento" name="orcamento" value="<?= $tarefa['orcamento'] !== null ? number_format($tarefa['orcamento'], 2, ',', '.') : "N/A"; ?>">
                                </div>
                            </div>
                            <div class="col-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="1" <?= ($tarefa['status'] == 1) ? 'selected' : '' ?>>Andamento</option>
                                    <option value="2" <?= ($tarefa['status'] == 2) ? 'selected' : '' ?>>Concluído</option>
                                    <option value="3" <?= ($tarefa['status'] == 3) ? 'selected' : '' ?>>Cancelado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <label class="form-label" for="area_planejamento"><b>Área de Planejamento</b></label>
                            <textarea rows="20" id="area_planejamento" name="area_planejamento" class="form-control"><?= htmlspecialchars($tarefa['area_planejamento'] ?? '') ?></textarea>

                        </div>
                        <br><br>
                        <div class="text-center">
                            <button class="btn btn-sm btn-danger" type="submit">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}

require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>