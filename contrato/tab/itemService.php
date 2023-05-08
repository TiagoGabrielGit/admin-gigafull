<div class="row">
    <div class="col-lg-9">
    </div>
    <div class="col-lg-3">
        <div class="row">
            <div class="col-12" style="text-align: center;">
                <br>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalAdicionarItem">
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
            <th scope="col">Item de Serviço</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $sql_contract_iten_service =
            "SELECT
            cis.id as idCIS,
            s.service as service,
            isr.item as iten,
            CASE
           WHEN  cis.active = 1 THEN 'Ativo'
           WHEN  cis.active = 1 THEN 'Inativo' 
            END as active
            
            FROM
            contract_iten_service as cis
            LEFT JOIN
            contract_service as  cs
            ON
            cs.id = cis.contract_service_id
            LEFT JOIN
            service as s
            ON
            s.id = cs.service_id
            LEFT JOIN
            iten_service as isr
            ON
            isr.id = cis.iten_service
            WHERE
            cs.contract_id = $idContrato
            ";

        $r_contract_iten_service = mysqli_query($mysqli, $sql_contract_iten_service);
        while ($c_contract_iten_service = $r_contract_iten_service->fetch_array()) { ?>

            <tr>
                <td><?= $c_contract_iten_service['idCIS']; ?></td>
                <td><?= $c_contract_iten_service['service']; ?></td>
                <td><?= $c_contract_iten_service['iten']; ?></td>
                <td><?= $c_contract_iten_service['active']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<div class="modal fade" id="modalAdicionarItem" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Item ao Serviço</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="card-body">
                    <form id="adicionaItem" method="POST" class="row g-3">

                        <span id="itemMsgAdiciona"></span>

                        <input hidden id="itemContratoID" name="itemContratoID" value="<?= $c_contrato['idContrato']; ?>"></input>

                        <div class="row">
                            <div class="col-5">
                                <div class="col-12">
                                    <label for="selectService" class="form-label">Serviço</label>
                                    <select id="selectService" name="selectService" class="form-select" required>
                                        <option selected disabled value="">Selecione</option>
                                        <?php
                                        $sql_services_item =
                                            "SELECT
                                            cs.id as idContractService,
                                            s.service as service
                                            FROM
                                            contract_service as cs
                                            LEFT JOIN
                                            service as s
                                            on
                                            s.id = cs.service_id
                                            WHERE
                                            cs.contract_id = $idContrato
                                            and
                                            s.item_service = 1
                                            and
                                            cs.active = 1
                                            ORDER BY
                                            s.service ASC";

                                        $r_services_item = mysqli_query($mysqli, $sql_services_item);
                                        while ($c_services_item = mysqli_fetch_object($r_services_item)) :
                                            echo "<option value='$c_services_item->idContractService'> $c_services_item->service</option>";
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-5">
                                <div class="col-12">
                                    <label for="itemService" class="form-label">Item de Serviço</label>
                                    <select id="itemService" name="itemService" class="form-select" required>
                                        <option selected disabled value="">Selecione</option>
                                        <?php
                                        $sql_itens =
                                            "SELECT
                                            ise.id as idIten,
                                            ise.item as iten
                                            FROM
                                            iten_service as ise
                                            WHERE
                                            ise.active = 1
                                            ORDER BY
                                            ise.item ASC";

                                        $r_itens = mysqli_query($mysqli, $sql_itens);
                                        while ($c_itens = mysqli_fetch_object($r_itens)) :
                                            echo "<option value='$c_itens->idIten'> $c_itens->iten</option>";
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <hr class="sidebar-divider">

                        <div class="col-4"></div>

                        <div class="col-4" style="text-align: center;">
                            <input id="btnAdicionarIten" name="btnAdicionarIten" type="button" value="Adicionar" class="btn btn-danger"></input>
                        </div>

                        <div class="col-4"></div>
                    </form><!-- End Horizontal Form -->
                </div>
            </div>
        </div>
    </div>
</div>