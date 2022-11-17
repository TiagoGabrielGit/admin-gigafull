<?php
require "../../includes/menu.php";
require "../../includes/remove_setas_number.php";
?>

<style>
    .border-color {
        border-color: #dee2e6;
    }
</style>

<?php
$idOLT = $_GET['idOLT'];

$sql_olt =
    "SELECT
rno.id as idOLT,
rno.olt_name as nameOLT,
eqp.ipaddress as ipOLT,
rno.olt_username as userOLT,
rno.olt_password as passOLT
FROM
redeneutra_olts as rno
LEFT JOIN
equipamentospop as eqp
ON
eqp.id = rno.equipamento_id
WHERE
rno.id = $idOLT
";

$r_olt = mysqli_query($mysqli, $sql_olt);
$campos = $r_olt->fetch_array();

$redeneutra_parceiro =
    "SELECT
rnpo.parceiro_id as idParceiro,
e.fantasia as parceiro
FROM
redeneutra_parceiro_olt as rnpo
LEFT JOIN
redeneutra_parceiro as rnp
ON
rnp.id = rnpo.parceiro_id
LEFT JOIN
empresas as e
ON
e.id = rnp.empresa_id   
WHERE
rnpo.active = 1
and
rnpo.olt_id = $idOLT
";
?>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <hr class="sidebar-divider">

                        <div class="row g-3">
                            <div class="col-lg-5 border border-color rounded">
                                <span><b>Informações da OLT</b></span>
                            </div>

                            <div class="col-lg-4 border border-color rounded">
                                <span><b>Novo Profile</b></span>
                            </div>

                            <div class="col-lg-3 border border-color rounded">
                                <span><b>Nova PON</b></span>
                            </div>

                            <div class="col-lg-5 border border-color rounded">
                                <form id="formEditOLT" method="POST">
                                    <div class="row">
                                        <div class="col-3">
                                            <label class="form-label">ID OLT</label>
                                            <input style="text-align: center;" type="text" class="form-control" value="<?= $idOLT ?>" disabled>
                                            <input name="idOLT" type="text" class="form-control" id="idOLT" value="<?= $idOLT ?>" hidden>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="olt" class="form-label">OLT</label>
                                            <input name="olt" type="text" class="form-control" id="olt" value="<?= $campos['nameOLT']; ?>">
                                        </div>
                                        <div class="col-4">
                                            <label for="ipOLT" class="form-label">IP</label>
                                            <input name="ipOLT" type="text" class="form-control" id="ipOLT" value="<?= $campos['ipOLT']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <label for="userOLT" class="form-label">Usuário</label>
                                            <input name="userOLT" type="text" class="form-control" id="userOLT" value="<?= $campos['userOLT']; ?>">
                                        </div>

                                        <div class="col-5">
                                            <label for="passOLT" class="form-label">Senha</label>
                                            <input name="passOLT" type="text" class="form-control" id="passOLT" value="<?= $campos['passOLT']; ?>">
                                        </div>
                                    </div>

                                    <br><br>
                                    <div class="row">
                                        <div class="col-12" style="text-align: center;">
                                            <input id="btnEditOLT" name="btnEditOLT" type="button" value="Aplicar Alterações" class="btn btn-danger"></input>
                                        </div>
                                    </div>

                                </form>
                            </div>

                            <div class="col-lg-4 border border-color rounded">
                                <span id="msgAlerta"></span>
                                <form id="formCriarPerfil">
                                    <span id="msgAlertaErroCad"></span>
                                    <input name="idOLT" type="text" class="form-control" id="idOLT" value="<?= $idOLT ?>" hidden>

                                    <div class="row">
                                        <div class="col-6">
                                            <label for="perfil" class="form-label">Profile</label>
                                            <input name="perfil" type="text" class="form-control" id="perfil" placeholder="Ex: Internet">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-8">
                                            <label for="parceiro" class="form-label">Parceiro</label>
                                            <select id="parceiro" name="parceiro" class="form-select" aria-label="Default select example">
                                                <option disabled selected value="">Selecione o parceiro</option>
                                                <?php
                                                $resultado = mysqli_query($mysqli, $redeneutra_parceiro);
                                                while ($parceiro = mysqli_fetch_object($resultado)) :
                                                    echo "<option value='$parceiro->idParceiro'> $parceiro->parceiro</option>";
                                                endwhile;
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-5">
                                            <label for="lineProfile" class="form-label">Line Profile ID</label>
                                            <input name="lineProfile" type="number" class="form-control" id="lineProfile">
                                        </div>
                                        <div class="col-5">
                                            <label for="srvProfile" class="form-label">SRV Profile ID</label>
                                            <input name="srvProfile" type="number" class="form-control" id="srvProfile">
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-12" style="text-align: center; margin-top: 2px;">
                                            <input type="submit" class="btn btn-danger" id="btnCriarPerfil" value="Criar Profile"></input>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-lg-3 border border-color rounded">
                                <form id="formCriaPON" method="POST">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="slot" class="form-label">SLOT</label>
                                            <input name="slot" type="number" class="form-control" id="slot">
                                        </div>

                                        <div class="col-6">
                                            <label for="pon" class="form-label">PON</label>
                                            <input name="pon" type="number" class="form-control" id="pon">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <label for="codigoIntegracao" class="form-label">Código Integração</label>
                                            <input name="codigoIntegracao" type="number" class="form-control" id="codigoIntegracao" maxlength="4">
                                        </div>
                                    </div>

                                    <br><br><br><br>
                                    <div class="row">
                                        <div class="col-12" style="text-align: center;  margin-top: 22px;">
                                            <input id="btnCriaPON" name="btnCriaPON" type="button" value="Criar PON" class="btn btn-danger"></input>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <hr class="sidebar-divider">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title">Perfil</h1>

                            <table class="table table-striped" id="styleTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Parceiro</th>
                                        <th scope="col">Perfil</th>
                                        <th scope="col">Line Prof.</th>
                                        <th scope="col">SRV Prof.</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_perfil =
                                        "SELECT
                                    rnpp.id as idPerfil,
                                    rnpp.line_profile_id as lineProfile,
                                    rnpp.srv_profile_id as srvProfile,
                                    rnpp.perfil as perfil,
                                    rno.olt_name as nameOLT,
                                    e.fantasia as fantasia,
                                    CASE
                                        WHEN rnpp.active = 1 THEN 'Ativo'
                                        WHEN rnpp.active = 0 THEN 'Inativo'
                                    END as statusPerfil
                                FROM
                                    redeneutra_profile_parceiro AS rnpp
                                LEFT JOIN
                                    redeneutra_olts as rno
                                ON
                                    rno.id = rnpp.redeneutra_olt_id
                                LEFT JOIN
                                    redeneutra_parceiro as rnp
                                ON
                                    rnpp.redeneutra_parceiro_id = rnp.id
                                LEFT JOIN
                                    empresas as e
                                ON
                                    rnp.empresa_id = e.id    
                                WHERE
                                    rnpp.redeneutra_olt_id = $idOLT
                                ";

                                    $r_perfil = mysqli_query($mysqli, $sql_perfil);
                                    while ($campos_perfil = $r_perfil->fetch_array()) {
                                    ?>
                                        <tr>
                                            <td><?= $campos_perfil['fantasia']; ?></td>
                                            <td style="text-align: center;">
                                                <a style="color: red;" href="perfilOlt.php?id=<?= $campos_perfil['idPerfil']; ?>"><?= $campos_perfil['perfil']; ?></a>
                                            </td>
                                            <td><?= $campos_perfil['lineProfile']; ?></td>
                                            <td><?= $campos_perfil['srvProfile']; ?></td>

                                            <td><?= $campos_perfil['statusPerfil']; ?></td>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    document.getElementById("btnEditOLT").addEventListener("click", eventoFuncaoEditOLT);

    function eventoFuncaoEditOLT() {
        let obg = {}
        obg.idOLT = document.getElementById("idOLT").value;
        obg.olt = document.getElementById("olt").value;
        obg.userOLT = document.getElementById("userOLT").value;
        obg.passOLT = document.getElementById("passOLT").value;
        funcaoEditOLT('/api/update_cadastro_olt.php', 'GET', obg)
    }

    function funcaoEditOLT(url, metodo, obg) {
        $.ajax({
            url: url,
            method: metodo,
            dataType: "HTML",
            data: obg,
        })
        window.location.replace("/redeNeutra/olts/view.php?idOLT=<?= $idOLT ?>");
    }
</script>

<script>
    const cadForm = document.getElementById("formCriarPerfil");
    const msgAlertaErroCad = document.getElementById("msgAlertaErroCad");
    const msgAlerta = document.getElementById("msgAlerta");

    cadForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const dadosForm = new FormData(cadForm);

        document.getElementById("btnCriarPerfil").value = "Salvando...";

        const dados = await fetch("cadastra_perfil.php", {
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
        document.getElementById("btnCriarPerfil").value = "Cadastrar";
    });
</script>
<!--
<script>
    function modalProfile() {
        $("#largeModal").modal({
            show: true
        });
    }

    setTimeout(modalProfile, 1000);
</script>
-->

<?php
require "../../includes/footer.php";
?>