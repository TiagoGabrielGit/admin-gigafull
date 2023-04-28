<?php
require "../../includes/menu.php";
require "sql.php";
?>

<?php
$idParceiro = $_GET["idParceiro"];

$sql_parceiro =
    "SELECT
rnp.id as idParceiro,
rnp.codigo as codigoParceiro, 
e.fantasia as fantasia
FROM
redeneutra_parceiro as rnp
LEFT JOIN
empresas as e
ON
e.id = rnp.empresa_id
WHERE
rnp.id  = $idParceiro
";

$r_parceiro = mysqli_query($mysqli, $sql_parceiro);
$campos = $r_parceiro->fetch_array();
?>


<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <hr class="sidebar-divider">

                        <div class="row g-3">

                            <div class="col-lg-6">
                                <span>Informações do parceiro</span>
                            </div>
                            <div class="col-lg-6">
                                <span>OLTs Permitidas</span>
                            </div>

                            <div class="col-lg-6">

                                <div class="row g-3">
                                    <div class="col-3">
                                        <label class="form-label">Código parceiro</label>
                                        <input type="text" class="form-control" value="<?= $campos['codigoParceiro'] ?>" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-8">
                                        <label class="form-label">Parceiro</label>
                                        <input type="text" class="form-control" value="<?= $campos['fantasia'] ?>" disabled>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-6">

                                <div class="row justify-content-between">
                                    <?php
                                    $r_lista_olts = mysqli_query($mysqli, $lista_olts);

                                    while ($campos_olts = $r_lista_olts->fetch_array()) {
                                        $idOLT = $campos_olts['idOLT'];

                                        $sql_PO =
                                            "SELECT
                                            count(*) as countPO,
                                            id as idPermissao
                                        FROM
                                            redeneutra_parceiro_olt as rnpo   
                                        WHERE
                                            rnpo.parceiro_id = $idParceiro
                                            and
                                            rnpo.olt_id = $idOLT
                                            and
                                            rnpo.active = 1";

                                        $r_sql_PO= mysqli_query($mysqli, $sql_PO);
                                        $campos_PO = $r_sql_PO->fetch_array();
                                    ?>
                                        <div class="col-3">
                                            <div class="form-check">
                                                <?php
                                                if ($campos_PO['countPO'] == 1) { ?>
                                                    <input onclick="despermitirOLT(<?=$campos_PO['idPermissao']?>)" class="form-check-input" type="checkbox" id="olt<?= $campos_olts['idOLT'] ?>" checked="" data-bs-toggle="modal" data-bs-target="#modalDespermitirOLT">
                                                <?php } else { ?>
                                                    <input onclick="permiteOLT(<?=$idOLT?>, '<?=$idParceiro?>')" class="form-check-input" type="checkbox" id="olt<?= $campos_olts['idOLT'] ?>" data-bs-toggle="modal" data-bs-target="#modalPermiteOLT">
                                                <?php } ?>
                                                <label class="form-check-label" for="olt<?= $campos_olts['idOLT'] ?>"><?= $campos_olts['nomeOLT'] ?></label>
                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>

                            <hr class="sidebar-divider">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->


<?php
require "modalDespermitir.php";
require "modalPermiteOLT.php";
require "../../includes/footer.php";
?>