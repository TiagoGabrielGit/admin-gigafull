<div class="row">
    <div class="col-lg-9">
    </div>
    <div class="col-lg-3">
        <div class="row">
            <div class="col-12" style="text-align: center;">
                <br>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalAdicionarService">
                    Adicionar
                </button>
            </div>
        </div>
    </div>
</div>

<table class="table table-striped" id="styleTable">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Serviço</th>
            <th scope="col">Permite Item</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $sql_contract_service =
            "SELECT
            cs.id as idCS,
            cs.active as activeIDCS,
            CASE
            WHEN cs.active = 1 THEN 'Ativo'
            WHEN cs.active = 0 THEN 'Inativo'
            END as activeCS,
            s.service as service,
            CASE
            WHEN s.item_service = 1 THEN 'Sim'
            WHEN s.item_service = 0 THEN 'Não'
            END as permiteItem
            FROM
            contract_service as cs
            LEFT JOIN
            service as s
            ON
            s.id = cs.service_id
            WHERE
            cs.contract_id = $idContrato
            ";

        $r_contract_service = mysqli_query($mysqli, $sql_contract_service);
        while ($c_contract_service = $r_contract_service->fetch_array()) { ?>

            <tr>
                <td><?= $c_contract_service['idCS']; ?></td>
                <td><?= $c_contract_service['service']; ?></td>
                <td><?= $c_contract_service['permiteItem']; ?></td>


                <td><?= $c_contract_service['activeCS']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<div class="modal fade" id="modalAdicionarService" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Serviço ao Contrato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="card-body">
                    <form id="adicionaServico" method="POST" class="row g-3">

                        <span id="serviceMsgAdiciona"></span>

                        <input hidden id="serviceContratoID" name="serviceContratoID" value="<?= $c_contrato['idContrato']; ?>"></input>

                        <div class="row">
                            <div class="col-5">
                                <div class="col-12">
                                    <label for="serviceContract" class="form-label">Serviços</label>
                                    <select id="serviceContract" name="serviceContract" class="form-select" required>
                                        <option selected disabled value="">Selecione</option>

                                        <?php
                                        $sql_services =
                                            "SELECT
                                            s.id as idServico,
                                            s.service as service,
                                            s.description as description
                                            FROM
                                            service as s
                                            WHERE
                                            s.active = 1
                                            ORDER BY
                                            s.service ASC
                                            ";

                                        $r_services = mysqli_query($mysqli, $sql_services);
                                        while ($c_services = mysqli_fetch_object($r_services)) :
                                            echo "<option value='$c_services->idServico'> $c_services->service</option>";
                                        endwhile;
                                        ?>

                                    </select>
                                </div>
                            </div>

                            <div class="col-3"></div>

                        </div>

                        <hr class="sidebar-divider">

                        <div class="col-4"></div>

                        <div class="col-4" style="text-align: center;">
                            <input id="adicionarService" name="adicionarService" type="button" value="Adicionar" class="btn btn-danger"></input>
                        </div>

                        <div class="col-4"></div>
                    </form><!-- End Horizontal Form -->
                </div>
            </div>
        </div>
    </div>
</div>