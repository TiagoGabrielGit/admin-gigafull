<?php
require "../../includes/menu.php";

$idPerfil = $_GET['id'];

$sql_perfil =
    "SELECT
rnpp.id as idPerfil,
rnpp.perfil as perfil,
e.fantasia as parceiro,
rno.olt_name as olt,
rnpp.redeneutra_olt_id as oltId,
rnpp.line_profile_id as lineProfile,
rnpp.srv_profile_id as srvProfile,
CASE
    WHEN rnpp.active = 1 THEN 'Ativado'
    WHEN rnpp.active = 0 THEN 'Inativado'
END AS active
FROM
redeneutra_profile_parceiro as rnpp
LEFT JOIN
redeneutra_parceiro as rnp
ON
rnpp.redeneutra_parceiro_id = rnp.id
LEFT JOIN
empresas as e
ON
e.id = rnp.empresa_id
LEFT JOIN
redeneutra_olts as rno
ON
rno.id = rnpp.redeneutra_olt_id
WHERE
rnpp.id = $idPerfil
";

$r_sql_perfil = mysqli_query($mysqli, $sql_perfil) or die("Erro ao retornar dados");
$campos = $r_sql_perfil->fetch_array();

?>

<style>
    .bi.bi-dash-circle-fill {
        font-size: 20px;
        color: red;
    }
</style>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Perfil: <?= $campos['perfil']; ?></h5>
                        <form id="formEditPerfil" method="POST">
                            <div class="row">
                                <div class="col-lg-6">

                                    <input type="Text" name="id" id="id" value="<?= $campos['idPerfil']; ?>" hidden>

                                    <div class="col-6">
                                        <label class="form-label">Perfil </label>
                                        <input type="Text" name="perfil" id="perfil" class="form-control" value="<?= $campos['perfil']; ?>">
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <label class="form-label">Parceiro</label>
                                            <input type="Text" class="form-control" value="<?= $campos['parceiro']; ?>" disabled>
                                        </div>

                                        <div class="col-4">
                                            <label class="form-label">OLT</label>
                                            <input type="Text" class="form-control" value="<?= $campos['olt']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if ($campos['active'] == "Ativado") {
                                    $checkSituacao1 = "checked";
                                    $checkSituacao0 = "";
                                } else if ($campos['active'] == "Inativado") {
                                    $checkSituacao0 = "checked";
                                    $checkSituacao1 = "";
                                }
                                ?>

                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label">Line Profile ID</label>
                                            <input name="lineprofile" id="lineprofile" type="Text" class="form-control" value="<?= $campos['lineProfile']; ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label">SRV Profile ID</label>
                                            <input name="srvprofile" id="srvprofile" type="Text" class="form-control" value="<?= $campos['srvProfile']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="col-4">
                                        <label for="situacao" class="form-label">Situação</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="situacao" id="situacao" value="1" <?= $checkSituacao1 ?>>
                                            <label class="form-check-label" for="situacao" value="1">Ativo</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="situacao" id="situacao" value="0" <?= $checkSituacao0 ?>>
                                            <label class="form-check-label" for="situacao" value="0">Inativo</label>
                                        </div>
                                    </div>
                                    <br><br><br>
                                </div>

                                <hr class="sidebar-divider">

                                <div class="col-lg-12" style="text-align: center;">
                                    <input id="btnEditPerfil" name="btnEditPerfil" type="button" value="Aplicar Alterações" class="btn btn-danger"></input>
                                    <a class="btn btn-secondary" href="/redeNeutra/olts/view.php?idOLT=<?= $campos['oltId']; ?>">Voltar</a>
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
                        <hr class="sidebar-divider">

                        <?php
                        $sql_contagem = "SELECT
                        count(*) as quantidade
                        FROM
                        redeneutra_profile_service as rnps
                        WHERE
                        rnps.profile_id = $idPerfil";
                        $r_sql_contagem = mysqli_query($mysqli, $sql_contagem);
                        $c_sql_contagem = $r_sql_contagem->fetch_array();

                        if ($c_sql_contagem['quantidade'] < 1) { ?>
                            <div class="col-lg-4">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalNovoServico">Novo Serviço</button>
                            </div>
                        <?php } ?>


                        <span><?= $c_sql_contagem['quantidade']; ?> de 1 serviço cadastrado</span>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Serviço</th>
                                    <th style="text-align: center;">CVLAN</th>
                                    <th style="text-align: center;">SVLAN</th>
                                    <th style="text-align: center;">GEMPORT</th>
                                    <th style="text-align: center;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_servico =
                                    "SELECT
                                    rnps.id as idServico,
                                    rnps.servico as servico,
                                    rnps.cvlan as cvlan,
                                    rnps.svlan as svlan,
                                    rnps.gemport as gemport
                                    FROM
                                    redeneutra_profile_service as rnps
                                    WHERE
                                    rnps.profile_id = $idPerfil";

                                $r_sql_servico = mysqli_query($mysqli, $sql_servico);
                                while ($c_sql_servico = $r_sql_servico->fetch_array()) { ?>
                                    <tr>
                                        <td style="text-align: center;"><?= $c_sql_servico['servico']; ?></td>
                                        <td style="text-align: center;"><?= $c_sql_servico['cvlan']; ?></td>
                                        <td style="text-align: center;"><?= $c_sql_servico['svlan']; ?></td>
                                        <td style="text-align: center;"><?= $c_sql_servico['gemport']; ?></td>
                                        <td style="text-align: left;">
                                            <a href="deleta_servico.php?id=<?= $c_sql_servico['idServico'] ?>" onclick="return confirm('Tem certeza que deseja deletar este registro?')" class="bi bi-dash-circle-fill"></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </section>

</main><!-- End #main -->

<div class="modal fade" id="modalNovoServico" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Serviço</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <span id="msgAlerta"></span>
                    <form id="formCriaServico">
                        <span id="msgAlertaErroCad"></span>

                        <input name="profile_id" type="text" class="form-control" id="profile_id" value="<?= $idPerfil ?>" hidden>

                        <div class="row">
                            <div class="col-4">
                                <label for="servico" class="form-label">Serviço</label>
                                <input name="servico" type="text" class="form-control" id="servico">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <label for="cvlan" class="form-label">CVLAN</label>
                                <input name="cvlan" type="text" class="form-control" id="cvlan">
                            </div>
                            <div class="col-4">
                                <label for="svlan" class="form-label">SVLAN</label>
                                <input name="svlan" type="text" class="form-control" id="svlan">
                            </div>
                            <div class="col-4">
                                <label for="gemport" class="form-label">GEMPORT</label>
                                <input name="gemport" type="text" class="form-control" id="gemport">
                            </div>
                        </div>

                        <br><br>
                        <div class="row">
                            <div class="col-12" style="text-align: center; margin-top: 2px;">
                                <input type="submit" class="btn btn-danger" id="btnCriarServico" value="Criar Serviço"></input>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    const cadForm = document.getElementById("formCriaServico");
    const msgAlertaErroCad = document.getElementById("msgAlertaErroCad");
    const msgAlerta = document.getElementById("msgAlerta");

    cadForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const dadosForm = new FormData(cadForm);

        document.getElementById("btnCriarServico").value = "Salvando...";

        const dados = await fetch("cadastra_servico.php", {
            method: "POST",
            body: dadosForm,
        });

        const resposta = await dados.json();

        if (resposta['erro']) {
            msgAlertaErroCad.innerHTML = resposta['msg'];
        } else {
            msgAlerta.innerHTML = resposta['msg'];
            cadForm.reset();

            setTimeout(function() {
                window.location.reload(1);
            }, 1200);
        }
        document.getElementById("btnCriarServico").value = "Criar Serviço";
    });
</script>

<script>
    document.getElementById("btnEditPerfil").addEventListener("click", eventoFuncaoEditPerfil);

    function eventoFuncaoEditPerfil() {
        let obg = {}
        obg.id = document.getElementById("id").value;
        obg.perfil = document.getElementById("perfil").value;
        obg.lineprofile = document.getElementById("lineprofile").value;
        obg.srvprofile = document.getElementById("srvprofile").value;
        obg.situacao = document.querySelector("#situacao").checked;
        funcaoEditPerfil('/api/update_rn_perfil.php', 'GET', obg)
    }

    function funcaoEditPerfil(url, metodo, obg) {
        $.ajax({
            url: url,
            method: metodo,
            dataType: "HTML",
            data: obg,
        })
        window.location.replace("/redeNeutra/olts/perfilOlt.php?id=<?= $idPerfil ?>");
    }
</script>

<?php
require "../../includes/footer.php";
?>