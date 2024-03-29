<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "sql.php";
?>

<?php
$id_equipe = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql_equipe =
    "SELECT
e.equipe as equipe,
e.id as idEquipe,
CASE
WHEN e.active = 1 THEN 'Ativo'
WHEN e.active = 0 THEN 'Inativo'
END as active
FROM
equipe as e
WHERE
e.id = '$id_equipe'
";

$resultado = mysqli_query($mysqli, $sql_equipe);
$row = mysqli_fetch_assoc($resultado);
$nameEquipe = $row['equipe'];
$statusEquipe = $row['active'];

if ($statusEquipe  == 'Ativo') {
    $checkStatusAtivo = "checked";
    $checkStatusInativo = "";
} else if ($statusEquipe  == 'Inativo') {
    $checkStatusAtivo = "";
    $checkStatusInativo = "checked";
}
?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Código <?= $row['idEquipe']; ?> -
                            <?= $row['equipe']; ?></h5>

                        <form id="formEditEquipe" method="POST" class="row g-3">

                            <input name="idEquipe" type="text" class="form-control" id="idEquipe" value="<?php echo $row['idEquipe']; ?>" hidden>
                            <input name="active" type="text" class="form-control" id="active" value="0" hidden>

                            <div class="col-4">
                                <label for="editEquipe" class="form-label">Equipe*</label>
                                <input name="editEquipe" type="text" class="form-control" id="editEquipe" value="<?= $row['equipe']; ?>" required>
                            </div>

                            <div class="col-2">
                                <label for="editActive" class="form-label">Status</label>
                                <input name="editActive" type="text" class="form-control" id="editActive" style="text-align: center;" value="<?= $row['active']; ?>" disabled>
                            </div>

                            <div class="col-3">
                                <label for="editStatus" class="form-label">Status</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="editStatus" id="editStatus" value="1" <?= $checkStatusAtivo ?>>
                                    <label class="form-check-label" for="editStatus" value="1">Ativo</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="editStatus" id="editStatus" value="0" <?= $checkStatusInativo ?>>
                                    <label class="form-check-label" for="editStatus" value="0">Inativo</label>
                                </div>
                            </div>

                            <div class="col-12" style="text-align: center;">
                                <input id="btnEditEquipe" name="btnEditEquipe" type="button" value="Salvar" class="btn btn-danger"></input>
                                <a href="/gerenciamento/equipes/index.php"><input type="button" value="Voltar" class="btn btn-secondary"></a>
                            </div>
                        </form><!-- Vertical Form -->

                        <hr class="sidebar-divider">
                        <div class="row">

                            <div class="col-lg-6"> <!-- Adiciona integrante na equipe -->
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Adicionar integrante na equipe</h5>
                                        <form>
                                            <div class="row mb-5">
                                                <div class="col-sm-10">
                                                    <?php
                                                    $sql_nao_integrantes =
                                                        "  SELECT
                                                        u.id AS usuarioID,
                                                        p.nome AS nomePessoa
                                                    FROM
                                                        usuarios AS u
                                                    LEFT JOIN
                                                        pessoas AS p ON u.pessoa_id = p.id
                                                    WHERE
                                                        u.active = 1
                                                        AND u.id NOT IN (
                                                            SELECT
                                                                integrante_id
                                                            FROM
                                                                equipes_integrantes
                                                        )
                                                    GROUP BY
                                                        u.id, p.nome
                                                    ORDER BY
                                                        p.nome ASC";

                                                    $result_n_int = mysqli_query($mysqli, $sql_nao_integrantes) or die("Erro ao retornar dados");

                                                    while ($nao_integrantes = $result_n_int->fetch_array()) {
                                                        $usuarioID = $nao_integrantes['usuarioID'];
                                                        $nomePessoa = $nao_integrantes['nomePessoa']; ?>
                                                        <div class="form-check form-switch">
                                                            <input onclick="AddIntegrante(<?= $id_equipe ?>, '<?= $usuarioID ?>', '<?= $nameEquipe ?>', '<?= $nomePessoa ?>')" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" data-bs-toggle="modal" data-bs-target="#modalConfirm">
                                                            <label class="form-check-label" for="flexSwitchCheckDefault"><?= $nomePessoa ?></label>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6"> <!-- Remove integrante na equipe -->
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Remover integrante da equipe</h5>
                                        <form>
                                            <div class="row mb-5">
                                                <div class="col-sm-10">
                                                    <?php
                                                    $sql_integrantes_equipe =
                                                        "SELECT
                                                            ei.id as id,
                                                            ei.equipe_id as equipeID,
                                                            ei.integrante_id as integranteID,
                                                            p.nome as nomePessoa,
                                                            e.equipe as nomeEquipe
                                                        FROM
                                                            equipes_integrantes as ei
                                                        LEFT JOIN
                                                            usuarios as u
                                                        ON
                                                            u.id = ei.integrante_id
                                                        LEFT JOIN
                                                            pessoas as p
                                                        ON
                                                            p.id = u.pessoa_id
                                                        LEFT JOIN
                                                            equipe as e
                                                        ON
                                                            e.id = ei.equipe_id
                                                        WHERE
                                                            ei.equipe_id = '$id_equipe'
                                                        ORDER BY    
                                                        p.nome ASC
                                                        ";

                                                    $resultado = mysqli_query($mysqli, $sql_integrantes_equipe) or die("Erro ao retornar dados");

                                                    while ($integrantes = $resultado->fetch_array()) {
                                                        $id_cad_int = $integrantes['id'];
                                                        $nomePessoa = $integrantes['nomePessoa'];
                                                        $nomeEquipe = $integrantes['nomeEquipe'];
                                                    ?>
                                                        <div class="form-check form-switch">
                                                            <input onclick="removeIntegrante(<?= $id_cad_int ?>, '<?= $nomePessoa ?>', '<?= $nomeEquipe ?>')" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked data-bs-toggle="modal" data-bs-target="#modalConfirmRemove">
                                                            <label class="form-check-label" for="flexSwitchCheckChecked"><?= $integrantes['nomePessoa']; ?></label>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row"> <!-- Chamados permitidos abrir -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Chamados Permitidos Abertura</h5>
                                        <div class="row mb-4">
                                            <?php
                                            $lista_chamados =
                                                "SELECT tc.id as idTipoChamado, tc.tipo as tipoChamado
                                                FROM tipos_chamados as tc
                                                WHERE tc.active = 1
                                                ORDER BY tc.tipo ASC";
                                            $r_lista_chamados = mysqli_query($mysqli, $lista_chamados);
                                            while ($c_lista_chamados = mysqli_fetch_assoc($r_lista_chamados)) {
                                                $idTipoChamado_abertura = $c_lista_chamados['idTipoChamado'];
                                                $tipoChamado_abertura = $c_lista_chamados['tipoChamado'];

                                                // Verifica se há registro no banco de dados para este tipo de chamado e equipe
                                                $query_verificar_registro = "SELECT COUNT(*) AS total FROM chamados_autorizados_abertura WHERE tipo_id = $idTipoChamado_abertura AND equipe_id = $id_equipe";
                                                $resultado_verificar = mysqli_query($mysqli, $query_verificar_registro);
                                                $registro_existente = mysqli_fetch_assoc($resultado_verificar)['total'];

                                                // Verifica se o checkbox deve estar marcado inicialmente
                                                $checkbox_marcado = $registro_existente > 0 ? 'checked' : '';
                                            ?>
                                                <div class="col-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input chamado-abertura-checkbox" type="checkbox" id="chamadoAbertura<?= $idTipoChamado_abertura ?>" data-tipo-id="<?= $idTipoChamado_abertura ?>" data-equipe-id="<?= $id_equipe ?>" <?= $checkbox_marcado ?>>
                                                        <label class="form-check-label" for="chamadoAbertura<?= $idTipoChamado_abertura ?>"><?= $c_lista_chamados['tipoChamado'] ?></label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row"> <!-- Chamados permitidos interagir -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Chamados Permitidos Interagir</h5>
                                        <div class="row mb-4">
                                            <?php
                                            $lista_chamados =
                                                "SELECT tc.id as idTipoChamado, tc.tipo as tipoChamado
                                                FROM tipos_chamados as tc
                                                WHERE tc.active = 1
                                                ORDER BY tc.tipo ASC";
                                            $r_lista_chamados = mysqli_query($mysqli, $lista_chamados);
                                            while ($c_lista_chamados = mysqli_fetch_assoc($r_lista_chamados)) {
                                                $idTipoChamado_interagir = $c_lista_chamados['idTipoChamado'];
                                                $tipoChamado_interagir = $c_lista_chamados['tipoChamado'];

                                                // Verifica se há registro no banco de dados para este tipo de chamado e equipe
                                                $query_verificar_registro = "SELECT COUNT(*) AS total FROM chamados_autorizados_interagir WHERE tipo_id = $idTipoChamado_interagir AND equipe_id = $id_equipe";
                                                $resultado_verificar = mysqli_query($mysqli, $query_verificar_registro);
                                                $registro_existente = mysqli_fetch_assoc($resultado_verificar)['total'];

                                                // Verifica se o checkbox deve estar marcado inicialmente
                                                $checkbox_marcado = $registro_existente > 0 ? 'checked' : '';
                                            ?>
                                                <div class="col-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input chamado-interagir-checkbox" type="checkbox" id="chamadoInteragir<?= $idTipoChamado_interagir ?>" data-tipo-id="<?= $idTipoChamado_interagir ?>" data-equipe-id="<?= $id_equipe ?>" <?= $checkbox_marcado ?>>
                                                        <label class="form-check-label" for="chamadoInteragir<?= $idTipoChamado_interagir ?>"><?= $c_lista_chamados['tipoChamado'] ?></label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row"> <!-- Chamados permitidos atender -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Chamados Permitidos Atender</h5>
                                        <div class="row mb-4">
                                            <?php
                                            $lista_chamados =
                                                "SELECT tc.id as idTipoChamado, tc.tipo as tipoChamado
                                                FROM tipos_chamados as tc
                                                WHERE tc.active = 1
                                                ORDER BY tc.tipo ASC";
                                            $r_lista_chamados = mysqli_query($mysqli, $lista_chamados);
                                            while ($c_lista_chamados = mysqli_fetch_assoc($r_lista_chamados)) {
                                                $idTipoChamado_atender = $c_lista_chamados['idTipoChamado'];
                                                $tipoChamado_atender = $c_lista_chamados['tipoChamado'];

                                                // Verifica se há registro no banco de dados para este tipo de chamado e equipe
                                                $query_verificar_registro = "SELECT COUNT(*) AS total FROM chamados_autorizados_atender WHERE tipo_id = $idTipoChamado_atender AND equipe_id = $id_equipe";
                                                $resultado_verificar = mysqli_query($mysqli, $query_verificar_registro);
                                                $registro_existente = mysqli_fetch_assoc($resultado_verificar)['total'];

                                                // Verifica se o checkbox deve estar marcado inicialmente
                                                $checkbox_marcado = $registro_existente > 0 ? 'checked' : '';
                                            ?>
                                                <div class="col-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input chamado-atender-checkbox" type="checkbox" id="chamadoAtender<?= $idTipoChamado_atender ?>" data-tipo-id="<?= $idTipoChamado_atender ?>" data-equipe-id="<?= $id_equipe ?>" <?= $checkbox_marcado ?>>
                                                        <label class="form-check-label" for="chamadoAtender<?= $idTipoChamado_atender ?>"><?= $c_lista_chamados['tipoChamado'] ?></label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
        $('.chamado-atender-checkbox').click(function() {
            var tipo_id = $(this).data('tipo-id');
            var equipe_id = $(this).data('equipe-id');
            var isChecked = $(this).prop('checked');

            if (isChecked) {
                if (confirm('Tem certeza que deseja permitir este chamado?')) {
                    // Se o usuário confirmar, envie uma solicitação AJAX para o script PHP
                    $.ajax({
                        type: 'POST',
                        url: 'processa/permitirChamadoAtender.php',
                        data: {
                            tipo_id: tipo_id,
                            equipe_id: equipe_id
                        },
                        success: function(response) {
                            // Exibir mensagem de sucesso ou redirecionar para outra página
                            alert('Chamado permitido com sucesso!');
                            window.location.href = '/gerenciamento/equipes/view.php?id=' + equipe_id;
                        },
                        error: function(xhr, status, error) {
                            // Lidar com erros
                            alert('Erro ao permitir chamado: ' + error);
                        }
                    });
                } else {
                    // Se o usuário cancelar, desmarque o checkbox
                    $(this).prop('checked', false);
                }
            } else {
                if (confirm('Tem certeza que deseja desabilitar este chamado?')) {
                    // Se o usuário confirmar, envie uma solicitação AJAX para o script PHP
                    $.ajax({
                        type: 'POST',
                        url: 'processa/despermitirChamadoAtender.php',
                        data: {
                            tipo_id: tipo_id,
                            equipe_id: equipe_id
                        },
                        success: function(response) {
                            // Exibir mensagem de sucesso ou redirecionar para outra página
                            alert('Chamado desabilitado com sucesso!');
                            window.location.href = '/gerenciamento/equipes/view.php?id=' + equipe_id;
                        },
                        error: function(xhr, status, error) {
                            // Lidar com erros
                            alert('Erro ao desabilitar chamado: ' + error);
                        }
                    });
                } else {
                    // Se o usuário cancelar, marque o checkbox novamente
                    $(this).prop('checked', true);
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.chamado-interagir-checkbox').click(function() {
            var tipo_id = $(this).data('tipo-id');
            var equipe_id = $(this).data('equipe-id');
            var isChecked = $(this).prop('checked');

            if (isChecked) {
                if (confirm('Tem certeza que deseja permitir este chamado?')) {
                    // Se o usuário confirmar, envie uma solicitação AJAX para o script PHP
                    $.ajax({
                        type: 'POST',
                        url: 'processa/permitirChamadoInteragir.php',
                        data: {
                            tipo_id: tipo_id,
                            equipe_id: equipe_id
                        },
                        success: function(response) {
                            // Exibir mensagem de sucesso ou redirecionar para outra página
                            alert('Chamado permitido com sucesso!');
                            window.location.href = '/gerenciamento/equipes/view.php?id=' + equipe_id;
                        },
                        error: function(xhr, status, error) {
                            // Lidar com erros
                            alert('Erro ao permitir chamado: ' + error);
                        }
                    });
                } else {
                    // Se o usuário cancelar, desmarque o checkbox
                    $(this).prop('checked', false);
                }
            } else {
                if (confirm('Tem certeza que deseja desabilitar este chamado?')) {
                    // Se o usuário confirmar, envie uma solicitação AJAX para o script PHP
                    $.ajax({
                        type: 'POST',
                        url: 'processa/despermitirChamadoInteragir.php',
                        data: {
                            tipo_id: tipo_id,
                            equipe_id: equipe_id
                        },
                        success: function(response) {
                            // Exibir mensagem de sucesso ou redirecionar para outra página
                            alert('Chamado desabilitado com sucesso!');
                            window.location.href = '/gerenciamento/equipes/view.php?id=' + equipe_id;
                        },
                        error: function(xhr, status, error) {
                            // Lidar com erros
                            alert('Erro ao desabilitar chamado: ' + error);
                        }
                    });
                } else {
                    // Se o usuário cancelar, marque o checkbox novamente
                    $(this).prop('checked', true);
                }
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.chamado-abertura-checkbox').click(function() {
            var tipo_id = $(this).data('tipo-id');
            var equipe_id = $(this).data('equipe-id');
            var isChecked = $(this).prop('checked');

            if (isChecked) {
                if (confirm('Tem certeza que deseja permitir este chamado?')) {
                    // Se o usuário confirmar, envie uma solicitação AJAX para o script PHP
                    $.ajax({
                        type: 'POST',
                        url: 'processa/permitirChamadoAbertura.php',
                        data: {
                            tipo_id: tipo_id,
                            equipe_id: equipe_id
                        },
                        success: function(response) {
                            // Exibir mensagem de sucesso ou redirecionar para outra página
                            alert('Chamado permitido com sucesso!');
                            window.location.href = '/gerenciamento/equipes/view.php?id=' + equipe_id;
                        },
                        error: function(xhr, status, error) {
                            // Lidar com erros
                            alert('Erro ao permitir chamado: ' + error);
                        }
                    });
                } else {
                    // Se o usuário cancelar, desmarque o checkbox
                    $(this).prop('checked', false);
                }
            } else {
                if (confirm('Tem certeza que deseja desabilitar este chamado?')) {
                    // Se o usuário confirmar, envie uma solicitação AJAX para o script PHP
                    $.ajax({
                        type: 'POST',
                        url: 'processa/despermitirChamadoAbertura.php',
                        data: {
                            tipo_id: tipo_id,
                            equipe_id: equipe_id
                        },
                        success: function(response) {
                            // Exibir mensagem de sucesso ou redirecionar para outra página
                            alert('Chamado desabilitado com sucesso!');
                            window.location.href = '/gerenciamento/equipes/view.php?id=' + equipe_id;
                        },
                        error: function(xhr, status, error) {
                            // Lidar com erros
                            alert('Erro ao desabilitar chamado: ' + error);
                        }
                    });
                } else {
                    // Se o usuário cancelar, marque o checkbox novamente
                    $(this).prop('checked', true);
                }
            }
        });
    });
</script>

<?php
require "confirmEdit.php";
require "modalConfirmAdd.php";
require "modalConfirmRemove.php";
require "../../includes/footer.php";
?>