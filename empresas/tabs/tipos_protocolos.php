<div class="card-body">

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
                                    cabc.id as idPermissao
                                    FROM
                                    chamados_autorizados_by_company as cabc
                                    WHERE
                                    cabc.tipo_id = $idTipoChamado
                                    and
                                    cabc.company_id = $id";
                                $r_valida_check = mysqli_query($mysqli, $valida_check);
                                $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                                if ($c_valida_check['validaCheck'] <> "0") { ?>
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input onclick="despermitirChamado(<?= $c_valida_check['idPermissao'] ?>, '<?= $fantasia ?>', '<?= $tipoChamado ?>')" class="form-check-input" type="checkbox" id="chamado<?= $idTipoChamado ?>" checked data-bs-toggle="modal" data-bs-target="#modalDespermitirChamado">
                                            <label class="form-check-label" for="chamado<?= $idTipoChamado ?>"><?= $c_chamados['tipoChamado'] ?></label>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input onclick="permitirChamado(<?= $idTipoChamado ?>, '<?= $id ?>', '<?= $fantasia ?>', '<?= $tipoChamado ?>')" class="form-check-input" type="checkbox" id="chamado<?= $idTipoChamado ?>" data-bs-toggle="modal" data-bs-target="#modalPermitirChamado">
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