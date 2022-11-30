<h5 class="card-title">ONU: <?= $campos['descricaoONU'] ?></h5>
<input id="idProvisionamento" value="<?= $idProvisionamento ?>" type="text" class="form-control" hidden>
<hr class="sidebar-divider">
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-4">
                        <label class="form-label">Descrição Provisionamento</label>
                        <input value="<?= $campos['descricaoONU'] ?>" type="text" class="form-control" disabled>
                    </div>

                    <div class="col-4">
                        <label class="form-label">Parceiro</label>
                        <input value="<?= $campos['fantasia'] ?>" type="text" class="form-control" disabled>
                    </div>
                </div>

                <div class="row">

                    <div class="col-3">
                        <label class="form-label">Serial ONU</label>
                        <input value="<?= $campos['serialONU'] ?>" type="text" class="form-control" disabled>
                    </div>

                    <div class="col-3">
                        <label class="form-label">OLT</label>
                        <input value="<?= $campos['nameOLT'] ?>" type="text" class="form-control" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <label class="form-label">SLOT</label>
                        <input value="<?= $campos['slotOLT'] ?>" type="text" class="form-control" disabled>
                    </div>
                    <div class="col-2">
                        <label class="form-label">PON</label>
                        <input value="<?= $campos['ponOLT'] ?>" type="text" class="form-control" disabled>
                    </div>
                    <div class="col-2">
                        <label class="form-label">ID ONU</label>
                        <input value="<?= $campos['idONU'] ?>" type="text" class="form-control" disabled>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <label class="form-label">Data Provisionamento</label>
                    <input value="<?= $campos['data_provisionamento'] ?>" type="text" class="form-control" disabled>
                </div>

                <div class="col-4">
                    <label class="form-label">Provisionada por</label>
                    <input value="<?= $campos['usuario_ativador'] ?>" type="text" class="form-control" disabled>
                </div>
            </div>
        </div>
    </div>
</div>