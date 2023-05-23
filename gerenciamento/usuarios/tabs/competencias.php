<h5 class="card-title">Selecione as competências</h5>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <?php
                        $competencias =
                            "SELECT
                            c.id as idCompetencia,
                            c.competencia as competencia
                            FROM
                            competencias as c
                            WHERE
                            c.active = 1
                            ORDER BY 
                            c.competencia ASC";
                        $r_competencias = mysqli_query($mysqli, $competencias);
                        while ($c_competencias = mysqli_fetch_assoc($r_competencias)) {
                            $idCompetencia = $c_competencias['idCompetencia'];
                            $competencia = $c_competencias['competencia'];
                            $valida_check =
                                "SELECT
                                count(*) as validaCheck,
                                uc.id as idUC
                                FROM
                                usuario_competencia as uc
                                WHERE
                                uc.id_competencia = $idCompetencia
                                and
                                uc.id_usuario = $idUsuario";
                            $r_valida_check = mysqli_query($mysqli, $valida_check);
                            $c_valida_check = mysqli_fetch_assoc($r_valida_check);

                            if ($c_valida_check['validaCheck'] <> "0") { ?>
                                <div class="col-3">
                                    <div class="form-check">
                                        <input onclick="retirarCompetencia(<?= $c_valida_check['idUC'] ?>, '<?= $campos['nome']; ?>', '<?= $competencia ?>')" class="form-check-input" type="checkbox" id="competencia<?= $idCompetencia ?>" checked data-bs-toggle="modal" data-bs-target="#modalRetirarCompetencia">
                                        <label class="form-check-label" for="competencia<?= $idCompetencia ?>"><?= $competencia ?></label>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="col-3">
                                    <div class="form-check">
                                        <input onclick="incluirCompetencia(<?= $idCompetencia ?>, '<?= $idUsuario ?>', '<?= $campos['nome']; ?>', '<?= $competencia ?>')" class="form-check-input" type="checkbox" id="competencia<?= $idCompetencia ?>" data-bs-toggle="modal" data-bs-target="#modalIncluirCompetencia">
                                        <label class="form-check-label" for="competencia<?= $idCompetencia ?>"><?= $competencia ?></label>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalIncluirCompetencia" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <form id="formIncluiCompetencia" method="POST" class="row g-3">
                                    <input type="Text" name="idIncluirCompetencia" class="form-control" id="idIncluirCompetencia" hidden>
                                    <input type="Text" name="idUsuarioCompetencia" class="form-control" id="idUsuarioCompetencia" hidden>
                                    <div class="text-center">
                                        <span id="msgConfirmCompetencia"></span>
                                    </div>
                                    <div class="text-center">
                                        <input id="btnConfirmCompetencia" name="btnConfirmCompetencia" type="button" value="Confirmar" class="btn btn-danger"></input>
                                        <a href="/gerenciamento/usuarios/view.php?id=<? $idUsuario ?>"> <input type="button" value="Cancelar" class="btn btn-secondary"></input></a>
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


<div class="modal fade" id="modalRetirarCompetencia" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <form id="formRetirarCompetencia" method="POST" class="row g-3">
                                    <input type="Text" name="idUC" class="form-control" id="idUC" hidden readonly>

                                    <div class="text-center">
                                        <span id="msgRetirarCompetencia"></span>
                                    </div>
                                    <div class="text-center">
                                        <input id="btnRetirarCompetencia" name="btnRetirarCompetencia" type="button" value="Confirmar" class="btn btn-danger"></input>
                                        <a href="/gerenciamento/usuarios/view.php?id=<? $idUsuario ?>"> <input type="button" value="Cancelar" class="btn btn-secondary"></input></a>
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