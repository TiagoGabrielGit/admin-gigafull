<?php
$lista_servicos =
    "SELECT
rpp.perfil as perfil,
rps.servico as service
FROM
redeneutra_onu_provisionadas as rop
LEFT JOIN
redeneutra_profile_parceiro as rpp
ON
rpp.id = rop.profile
LEFT JOIN
redeneutra_profile_service as rps
ON
rop.profile = rps.profile_id
WHERE
rop.id = $idProvisionamento";
$r_lista_servicos = mysqli_query($mysqli, $lista_servicos);

$lista_servicos2 =
    "SELECT
rps.id as idServico,    
rpp.perfil as perfil,
rps.servico as service
FROM
redeneutra_onu_provisionadas as rop
LEFT JOIN
redeneutra_profile_parceiro as rpp
ON
rpp.id = rop.profile
LEFT JOIN
redeneutra_profile_service as rps
ON
rop.profile = rps.profile_id
WHERE
rop.id = $idProvisionamento";
$r_lista_servicos2 = mysqli_query($mysqli, $lista_servicos2);

$sql_perfil =
    "SELECT
rpp.perfil as perfil
FROM
redeneutra_onu_provisionadas as rop
LEFT JOIN
redeneutra_profile_parceiro as rpp
ON
rpp.id = rop.profile
WHERE
rop.id = $idProvisionamento";
$r_perfil = mysqli_query($mysqli, $sql_perfil);
$c_parfil = $r_perfil->fetch_array();
?>

<div class="row">
    <div class="col-lg-10">
        <h5 class="card-title">ONU: <?= $campos['descricaoONU'] ?></h5>
    </div>
</div>
<input id="idProvisionamento" value="<?= $idProvisionamento ?>" type="text" class="form-control" hidden>

<!--<span>Serviços do profile <b><?= $c_parfil['perfil'] ?></b></span>-->
<hr class="sidebar-divider">

<div class="row">
    <div class="col-lg-6">
        <table class="table">

            <span><b>Serviços do Profile <?= $c_parfil['perfil'] ?></b></span>
            
            <tbody>

                <?php
                while ($c_lista_servicos = $r_lista_servicos->fetch_array()) { ?>
                    <tr>
                        <td><?= $c_lista_servicos['service'] ?></td>
                        <td>
                            <button disabled type="button" class="btn btn-info rounded-pill">Atribuir Serviço</button>
                            <button disabled type="button" class="btn btn-secondary rounded-pill">Serviço Atribuido</button>
                            <button disabled type="button" class="btn btn-danger rounded-pill">Remover Serviço</button>
                        </td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
    </div>
    <div class="col-lg-6">

        <?php
        while ($c_lista_servicos2 = $r_lista_servicos2->fetch_array()) { ?>
            <div class="col-12">
                <label class="form-label"><b>Serviço: <?=$c_lista_servicos2['service']?></b></label>
                <textarea id="resultadoServico<?=$c_lista_servicos2['idServico']?>" rows="5" type="text" class="form-control" disabled></textarea>
            </div>
        <?php }
        ?>

    </div>

</div>