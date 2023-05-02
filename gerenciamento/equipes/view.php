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

                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Adicionar integrante na equipe</h5>
                                        <form>
                                            <div class="row mb-5">
                                                <div class="col-sm-10">
                                                    <?php
                                                    $sql_nao_integrantes =
                                                        "SELECT
                                                        u.id as usuarioID,
                                                        p.nome as nomePessoa,
                                                        e.id as idEquipe,
                                                        e.equipe as nomeEquipe
                                                    FROM
                                                        usuarios as u
                                                    LEFT JOIN
                                                        pessoas as p
                                                    ON
                                                        u.pessoa_id = p.id	
                                                    LEFT JOIN
                                                        equipes_integrantes as ei
                                                    ON
                                                        ei.integrante_id = u.id
                                                    LEFT JOIN
                                                        equipe as e
                                                    ON
                                                        e.id = ei.equipe_id
                                                    WHERE
                                                        u.active = 1
                                                    AND
                                                        ei.integrante_id NOT IN (
                                                            SELECT
                                                                integrante_id
                                                            FROM
                                                                equipes_integrantes
                                                            WHERE
                                                                equipe_id = $id_equipe)
                                                    OR
                                                        u.active = 1
                                                    AND
                                                        ei.equipe_id IS NULL
                                                    GROUP BY
                                                    p.nome
                                                    ORDER BY
                                                    p.nome asc";

                                                    $result_n_int = mysqli_query($mysqli, $sql_nao_integrantes) or die("Erro ao retornar dados");

                                                    while ($nao_integrantes = $result_n_int->fetch_array()) {
                                                        $usuarioID = $nao_integrantes['usuarioID'];
                                                        $nomePessoa = $nao_integrantes['nomePessoa'];
                                                        $nomeEquipe = $nao_integrantes['nomeEquipe'];  ?>
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

                            <div class="col-lg-6">
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

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Chamados Permitidos Abertura</h5>
                                        <form>
                                            <div class="row mb-4">
                                                <?php
                                                $chamados =
                                                    "SELECT
                                                        tc.id as idTipoChamado,
                                                        tc.tipo as tipoChamado
                                                    FROM
                                                        tipos_chamados as tc
                                                    WHERE
                                                        tc.active = 1
                                                    ORDER BY 
                                                        tc.tipo ASC";
                                                $r_chamados = mysqli_query($mysqli, $chamados);
                                                while ($c_chamados = mysqli_fetch_assoc($r_chamados)) {
                                                    $idTipoChamado = $c_chamados['idTipoChamado'];
                                                    $tipoChamado = $c_chamados['tipoChamado'];
                                                    $valida_check =
                                                        "SELECT
                                                            count(*) as validaCheck,
                                                            ca.id as idPermissao
                                                        FROM
                                                                chamados_autorizados as ca
                                                        WHERE
                                                                ca.tipo_id = $idTipoChamado
                                                                and
                                                                ca.equipe_id = $id_equipe";
                                                    $r_valida_check = mysqli_query($mysqli, $valida_check);
                                                    $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                                                    if ($c_valida_check['validaCheck'] <> "0") { ?>
                                                        <div class="col-3">
                                                            <div class="form-check">
                                                                <input onclick="despermitirChamado(<?= $c_valida_check['idPermissao'] ?>, '<?= $nameEquipe ?>', '<?= $tipoChamado ?>')" class="form-check-input" type="checkbox" id="chamado<?= $idTipoChamado ?>" checked data-bs-toggle="modal" data-bs-target="#modalDespermitirChamado">
                                                                <label class="form-check-label" for="chamado<?= $idTipoChamado ?>"><?= $c_chamados['tipoChamado'] ?></label>
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-3">
                                                            <div class="form-check">
                                                                <input onclick="permitirChamado(<?= $idTipoChamado ?>, '<?= $id_equipe ?>', '<?= $nameEquipe ?>', '<?= $tipoChamado ?>')" class="form-check-input" type="checkbox" id="chamado<?= $idTipoChamado ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirChamado">
                                                                <label class="form-check-label" for="chamado<?= $idTipoChamado ?>"><?= $c_chamados['tipoChamado'] ?></label>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->


<?php
require "confirmEdit.php";
require "modalConfirmAdd.php";
require "modalConfirmRemove.php";
require "modalPermiteChamado.php";
require "modalDespermiteChamado.php";
require "../../includes/footer.php";
?>