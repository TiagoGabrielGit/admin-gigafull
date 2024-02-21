<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];

$submenu_id = "53";

$permissions =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {
?>

    <style>
        #tabelaLista:hover {
            cursor: pointer;
            background-color: #E0FFFF;
        }
    </style>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Mascaras</h1>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">

                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-9"></div>
                                    <div class="col-3">
                                        <div class="card">
                                            <button style="margin-top: 15px" type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                                Novo
                                            </button>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="basicModal" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Nova Mascara</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <form method="POST" action="processa/nova_mascara.php">

                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <label for="empresa" class="form-label">Selecione a Empresa</label>
                                                                    <select required class="form-select" id="empresa" name="empresa">
                                                                        <option selected disabled value="">Selecione...</option>
                                                                        <?php
                                                                        // Consulta SQL para obter as empresas
                                                                        $query_empresas = "SELECT id, fantasia FROM empresas ORDER BY fantasia ASC";
                                                                        $stmt = $conn->prepare($query_empresas);
                                                                        $stmt->execute();

                                                                        // Exibe as opções de empresas no menu suspenso
                                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                            echo "<option value='" . $row['id'] . "'>" . $row['fantasia'] . "</option>";
                                                                        }                                                                        ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-6">
                                                                    <label for="tipoChamado" class="form-label">Selecione o Tipo de Chamado</label>
                                                                    <select required class="form-select" id="tipoChamado" name="tipoChamado">
                                                                        <option selected disabled value="">Selecione...</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="col-12">
                                                                <label for="mascara" class="form-label">Mascara</label>
                                                                <textarea style="resize: none;" rows="10" placeholder="Escreva a mascara de abertura de chamado" id="mascara" name="mascara" class="form-control" required></textarea>
                                                            </div>

                                                            <hr class="sidebar-divider">

                                                            <div class="text-center">
                                                                <button class="btn btn-sm btn-danger" type="submit">Salvar</button>

                                                                <a href="/servicedesk/tipos_chamados/mascaras/index.php"> <input type="button" value="Voltar" class="btn btn-sm btn-secondary"></input></a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="sidebar-divider">

                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;" scope="col">Tipo de chamado</th>
                                        <th style="text-align: center;" scope="col">Empresa</th>
                                        <th style="text-align: center;" scope="col">Ativo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    $query_mascaras = "SELECT tcm.id, tc.tipo, e.fantasia,
                                        CASE
                                        WHEN tcm.active = 1 THEN 'Ativo'
                                        WHEN tcm.active = 0 THEN 'Inativo'
                                        END as active
                                        FROM tipos_chamados_mascaras AS tcm
                                        LEFT JOIN empresas as e ON e.id  = tcm.empresa_id
                                        LEFT JOIN tipos_chamados as tc ON tc.id = tipo_chamado_id";

                                    // Prepare a consulta
                                    $stmt = $pdo->prepare($query_mascaras);

                                    // Execute a consulta
                                    $stmt->execute();

                                    // Loop através dos resultados
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <tr id="tabelaLista" onclick="location.href='view.php?id=<?= $row['id'] ?>'">
                                            <td style="text-align: center;"><?= $row['tipo']; ?></td>
                                            <td style="text-align: center;"><?= $row['fantasia']; ?></td>
                                            <td style="text-align: center;"><?= $row['active']; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function() {
            // Quando o valor da empresa for alterado
            $('#empresa').change(function() {
                var empresa = $(this).val();
                if (empresa) {
                    // Requisição AJAX para obter os tipos de chamados que ainda não possuem máscara para a empresa selecionada
                    $.ajax({
                        url: 'processa/get_tipos_chamados.php', // Substitua pela URL correta do seu arquivo PHP
                        type: 'POST',
                        data: {
                            empresa: empresa
                        },
                        dataType: 'json',
                        success: function(response) {
                            var len = response.length;
                            $("#tipoChamado").empty();
                            $("#tipoChamado").append("<option selected disabled value=''>Selecione...</option>");
                            for (var i = 0; i < len; i++) {
                                $("#tipoChamado").append("<option value='" + response[i]['id'] + "'>" + response[i]['nome'] + "</option>");
                            }
                        }
                    });
                } else {
                    // Se nenhum empresa for selecionada, limpe os tipos de chamado
                    $("#tipoChamado").empty();
                    $("#tipoChamado").append("<option selected disabled value=''>Selecione a empresa primeiro</option>");
                }
            });
        });
    </script>

<?php
} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php"; ?>