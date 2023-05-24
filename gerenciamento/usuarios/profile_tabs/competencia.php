<div class="col-lg-12">
    <div class="row mb-4">
        <?php
        $sql_lista_competencias =
            "SELECT
        c.id as idCompetencia,
        c.competencia as competencia,
        c.descricao as descricao
        FROM
        competencias as c
        WHERE
        c.active = 1
        ORDER BY
        c.competencia ASC";
        $r_lista_competencias = mysqli_query($mysqli, $sql_lista_competencias);


        while ($c_lista_competencias = mysqli_fetch_assoc($r_lista_competencias)) {
            $idCompetencia = $c_lista_competencias['idCompetencia'];
            $consulta_competencia =
                "SELECT
            count(*) as qtde
            FROM
            usuario_competencia as uc
            WHERE
            uc.id_competencia = $idCompetencia
            and
            uc.id_usuario = $usuarioID";

            $r_consulta_competencia = mysqli_query($mysqli, $consulta_competencia);
            $c_consulta_competencia = mysqli_fetch_assoc($r_consulta_competencia);

            if ($c_consulta_competencia['qtde'] > 0) { ?>

                <div class="col-lg-4">
                    <div class="card">
                        <!-- Basic Modal -->
                        <button style="margin-top: 15px" type="button" class="btn btn-success col-12" data-bs-toggle="modal" data-bs-target="#modalDetalhesCompetencia<?=$idCompetencia?>">
                            <?= $c_lista_competencias['competencia'] ?>
                        </button>
                    </div>
                </div>

                <div class="modal fade" id="modalDetalhesCompetencia<?=$idCompetencia?>" tabindex="-1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= $c_lista_competencias['competencia'] ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <?= $c_lista_competencias['descricao'] ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button title="Nenhuma avaliação disponível" type="button" class="btn btn-danger">Realizar Avaliação</button>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } else { ?>
                <div class="col-lg-4">
                    <div class="card">
                        <!-- Basic Modal -->
                        <button style="margin-top: 15px" type="button" class="btn btn-secondary col-12" data-bs-toggle="modal" data-bs-target="#modalDetalhesCompetencia<?=$idCompetencia?>">
                            <?= $c_lista_competencias['competencia'] ?>
                        </button>
                    </div>
                </div>

                <div class="modal fade" id="modalDetalhesCompetencia<?=$idCompetencia?>" tabindex="-1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= $c_lista_competencias['competencia'] ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?= $c_lista_competencias['descricao'] ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                <button title="Nenhuma avaliação disponível" type="button" class="btn btn-danger">Realizar Avaliação</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        <?php } ?>
    </div>
</div>