<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$usuarioID = $_SESSION['id'];
$idPOP = $_GET['id'];

$menu_id = "6";
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
$sql_pop =
    "SELECT
    pop.id as id,
    pop.pop as pop,
    pop.apelidoPop as apelidoPop
    FROM pop as pop
    LEFT JOIN pop_address as endereco ON endereco.pop_id = pop.id
    LEFT JOIN empresas as emp ON emp.id = pop.empresa_id
    WHERE pop.active = 1 and pop.id = $idPOP    
    ORDER BY emp.fantasia asc, endereco.city asc, pop.pop asc
";

$resultado = mysqli_query($mysqli, $sql_pop);
$row = mysqli_fetch_assoc($resultado);

?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">POP <?= $row['pop']; ?></h5>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="informacoes-tab" data-bs-toggle="tab" data-bs-target="#informacoes" type="button" role="tab" aria-controls="informacoes" aria-selected="true" onclick="window.location.href = 'view_informacoes.php?id=<?= $idPOP ?>';">Informacoes</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link " id="equipamentos-tab" data-bs-toggle="tab" data-bs-target="#equipamentos" type="button" role="tab" aria-controls="equipamentos" aria-selected="false" onclick="window.location.href = 'view_equipamentos.php?id=<?= $idPOP ?>';">Equipamentos</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="energia-tab" data-bs-toggle="tab" data-bs-target="#energia" type="button" role="tab" aria-controls="energia" aria-selected="false" onclick="window.location.href = 'view_energia.php?id=<?= $idPOP ?>';">Energia</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="anexo-tab" data-bs-toggle="tab" data-bs-target="#anexo" type="button" role="tab" aria-controls="anexo" aria-selected="false" onclick="window.location.href = 'view_anexo.php?id=<?= $idPOP ?>';">Anexos</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="atividades-tab" data-bs-toggle="tab" data-bs-target="#atividades" type="button" role="tab" aria-controls="atividades" aria-selected="false" onclick="window.location.href = 'view_atividades.php?id=<?= $idPOP ?>';">Atividades</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="vistoria-tab" data-bs-toggle="tab" data-bs-target="#vistoria" type="button" role="tab" aria-controls="vistoria" aria-selected="false" onclick="window.location.href = 'view_vistoria.php?id=<?= $idPOP ?>';">Vistoria</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">
                        <div class="col-lg-12">
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Programar Atividade</h5>
                        <form method="POST" action="processa/add_atividade_programada.php">
                            <input readonly hidden name="atividade_popid" id="atividade_popid" value="<?= $idPOP ?>"></input>
                            <div class="col-12">
                                <label class="form-label">Atividade</label>
                                <select name="atividade_atividade" id="atividade_atividade" class="form-select" required>
                                    <option disabled value="" selected="">Selecione uma atividade</option>
                                    <option value="1">Manutenção Ar Condicionado</option>
                                    <option value="2">Troca de Bateria</option>
                                    <option value="3">Vistoria de POP</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Data Agendamento</label>
                                <input name="atividade_data_agendamento" id="atividade_data_agendamento" type="date" class="form-control" required></input>
                            </div>
                            <br>
                            <div class="text-center">
                                <button class="btn btn-danger" type="submit">Agendar Atividade</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Atividades Programadas</h5>

                    <table class="table datatable">
                        <thead>
                            <!-- ... -->
                        </thead>
                        <tbody>
                            <?php
                            try {
                                // Sua conexão com o banco de dados já deve estar estabelecida aqui

                                // Prepara a instrução SQL de seleção
                                $stmt = $pdo->prepare(
                                    "SELECT
                                        id as id,
                                        CASE
                                        WHEN pap.atividade_id = 1 THEN 'Manutenção de Ar Condicionado'
                                        WHEN pap.atividade_id = 2 THEN 'Troca de Bateria'
                                        WHEN pap.atividade_id = 3 THEN 'Vistoria POP'
                                        END as atividade, 
                                        date, 
                                        case
                                        WHEN pap.statuS = 1 THEN 'Programada'
                                        WHEN pap.statuS = 2 THEN 'Cancelada'
                                        WHEN pap.statuS = 3 THEN 'Executada'
                                        END as status
                                    FROM 
                                        pop_atividade_programada as pap
                                    WHERE 
                                        pap.pop_id = $idPOP
                                    ORDER BY
                                        pap.date ASC"
                                );

                                // Executa a instrução SQL
                                $stmt->execute();

                                // Obtém os resultados da consulta
                                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Itera sobre os resultados e gera as linhas da tabela
                                foreach ($results as $row) {
                                    echo "<tr>";
                                    echo "<td>" . $row['atividade'] . "</td>";
                                    $dataFormatada = date('d/m/Y', strtotime($row['date']));
                                    echo "<td>" . $dataFormatada . "</td>";
                                    echo "<td>" . $row['status'] . "</td>";
                                    if ($row['status'] == 'Programada') {  ?>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalStatus_<?= $row['id'] ?>"><i class="bi bi-pencil-square"></i></button>
                                        </td>
                                    <?php } else {
                                        echo "<td></td>";
                                    }
                                    echo "</tr>";

                                    if ($row['status'] == 'Programada') { ?>
                                        <div class="modal fade" id="modalStatus_<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalStatusLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Alterar Status</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="processa/status_atividade_programada.php">
                                                            <input name="ap_pop_id" id="ap_pop_id" readonly hidden value="<?= $idPOP ?>" required></input>

                                                            <input name="ap_id" id="ap_id" readonly hidden value="<?= $row['id'] ?>" required></input>
                                                            <div class="col-12">
                                                                <label class="form-label">Selecione o novo status</label>
                                                                <select name="ap_status" id="ap_status" class="form-select" required>
                                                                    <option disabled value="" selected>Selecione uma opção</option>
                                                                    <option value="2">Cancelada</option>
                                                                    <option value="3">Executada</option>
                                                                </select>
                                                            </div>
                                                            <br>
                                                            <div class="text-center">
                                                                <button class="btn btn-danger" type="submit">Alterar Status</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            <?php }
                                }
                            } catch (PDOException $e) {
                                echo "Erro ao consultar registros: " . $e->getMessage();
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Melhorias Recomendadas</h5>
            <form method="POST" action="processa/pop_melhoria_conhecida.php">
                <input name="mc_pop_id" id="mc_pop_id" readonly hidden value="<?= $idPOP ?>" required></input>
                <div class="col-12">
                    <label for="melhoriasConhecidas" class="form-label">Anotações</label>
                    <textarea id="melhoriasConhecidas" name="melhoriasConhecidas" class="form-control" maxlength="10000" rows="2"></textarea>
                </div>
                <br>
                <button type="submit" class="btn btn-danger">Adicionar</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table datatable">

                <thead>
                    <tr>
                        <th scope="col">Melhoria Recomendada</th>
                        <th scope="col">Data Criação</th>
                        <th scope="col">Criador</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_consulta_melhorias =
                        "SELECT 
                        pmc.id as 'id',
                        pmc.melhoria_conhecida as 'melhoria_conhecida', 
                        pmc.criado as 'criado',
                        p.nome as 'nome',
                        CASE
                        WHEN pmc.status = 1 THEN 'Pendente'
                        WHEN pmc.status = 2 THEN 'Cancelado'
                        WHEN pmc.status = 3 THEN 'Executado'
                        END as Status,
                        pmc.status as status_id,
                        c.id as chamado_id
                    FROM 
                        pop_melhorias_conhecidas as pmc
                    LEFT JOIN
                            usuarios as u
                        ON
                            u.id = pmc.usuario_criador
                    LEFT JOIN
                            pessoas as p
                        ON
                            p.id = u.pessoa_id
                    LEFT JOIN
						chamados as c
                        ON
                        c.melhoria_recomendada = pmc.id                               
                    WHERE
                        pmc.pop_id = $idPOP
                    ORDER BY
                        pmc.criado ASC    ";

                    $stmt_melhorias = $pdo->query($sql_consulta_melhorias);
                    $r_melhorias = $stmt_melhorias->fetchAll(PDO::FETCH_ASSOC);

                    // Iterar sobre os resultados e gerar as linhas da tabela
                    foreach ($r_melhorias as $row_melhorias) {
                        $melhoria = $row_melhorias['melhoria_conhecida'];
                        echo "<tr>";
                        echo "<td>";

                        if (strlen($melhoria) > 50) {
                            echo substr($melhoria, 0, 50) . "..." ?>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalMelhoria<?= $row_melhorias['id'] ?>">Ler mais</button>

                            <div class="modal fade" id="modalMelhoria<?= $row_melhorias['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalMelhoria<?= $row_melhorias['id'] ?>Label" aria-hidden="true">
                                <div class="modal-dialog modal-xl">

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalMelhoria<?= $row_melhorias['id'] ?>Label">Melhoria</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?= $melhoria ?> </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else {
                            echo $melhoria;
                        } ?>
                        </td>
                        <td><?= date('d/m/Y', strtotime($row_melhorias['criado'])) ?></td>
                        <td><?= $row_melhorias['nome'] ?></td>

                        <td><?= $row_melhorias['Status'] ?></td>
                        <?php if (isset($row_melhorias['chamado_id'])) { ?>
                            <td>

                                <a href="/servicedesk/consultar_chamados/view.php?id=<?= $row_melhorias['chamado_id'] ?>">
                                    <button class="btn btn-warning btn-sm">
                                        <i class="bi bi-gem"></i>
                                    </button>
                                </a>

                            </td>
                        <?php } ?>

                        <?php if ($row_melhorias['status_id'] == 1) { ?>

                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditarStatus<?= $row_melhorias['id'] ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </td>

                            <div class="modal fade" id="modalEditarStatus<?= $row_melhorias['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalEditarStatus<?= $row_melhorias['id'] ?>Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Alterar Status</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="processa/status_melhoria_conhecida.php">
                                                <input name="mc_id" id="mc_id" readonly hidden value="<?= $row_melhorias['id'] ?>" required></input>
                                                <input name="mc_pop_id" id="mc_pop_id" readonly hidden value="<?= $idPOP ?>" required></input>
                                                <div class="col-12">
                                                    <label class="form-label">Selecione o novo status</label>
                                                    <select name="mc_status" id="mc_status" class="form-select" required>
                                                        <option disabled value="" selected>Selecione uma opção</option>
                                                        <option value="2">Cancelada</option>
                                                        <option value="3">Executada</option>
                                                    </select>
                                                </div>
                                                <br>
                                                <div class="text-center">
                                                    <button class="btn btn-danger" type="submit">Alterar Status</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    <?php }

                        echo "</tr>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
                        </div>
                    </div><!-- End Default Tabs -->
                </div>
            </div>
        </div>
    </section>
</main>
<?php
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>