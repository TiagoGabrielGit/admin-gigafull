<div class="row">
    <div class="col-lg-10">
        <h5 class="card-title">Contrato: <?= $c_contrato['idContrato'] ?></h5>
    </div>
</div>
<input id="idContrato" value="<?= $c_contrato['idContrato'] ?>" type="text" class="form-control" hidden>
<hr class="sidebar-divider">
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">

                <form id="editContractInformation" method="POST" class="row g-3">
                    <span id="msg"></span>

                    <input hidden id="contractIDInformation" name="contractIDInformation" value="<?= $idContrato ?>"></input>

                    <div class="row">
                        <div class="col-4">
                            <label class="form-label">Empresa</label>
                            <input value="<?= $c_contrato['fantasia'] ?>" type="text" class="form-control" disabled>
                        </div>

                        <div class="col-5"></div>
                        <div class="col-3">
                            <label for="statusContrato" class="form-label">Status</label>
                            <select class="form-select" id="statusContrato" name="statusContrato" required>
                                <option value="1" <?= $c_contrato['idActive'] == '1' ? 'selected' : ''; ?>>Ativo</option>
                                <option value="0" <?= $c_contrato['idActive'] == '0' ? 'selected' : ''; ?>>Inativo</option>
                            </select>
                        </div>
                    </div>
                    <hr class="sidebar-divider">

                    <div class="col-4"></div>
                    <div class="col-4" style="text-align: center;">
                        <input id="btnEditContractInformation" name="btnEditContractInformation" type="button" value="Atualizar" class="btn btn-danger"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

