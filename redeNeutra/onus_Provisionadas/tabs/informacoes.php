<div class="row">
    <div class="col-lg-10">
        <h5 class="card-title">ONU: <?= $campos['descricaoONU'] ?></h5>
    </div>
    <div class="col-lg-2" style="margin-top: 10px;">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalExcluirONU">Excluir ONU</button>
    </div>
</div>
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

<div class="modal fade" id="modalExcluirONU" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b>Excluir ONU</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="text-align: center;">
                Tem certeza que deseja excluir a ONU?<br><br>
                <span style="color:red; font-size:80%;">Atenção: Este processo não realiza o desprovisionamento na OLT.
                    Apenas excluir a ONU do banco de dados do sistema Gigafull Admin.
                    Somente confirme se a ONU não estiver mais provisionada na OLT.
                </span>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                <a href="processa/delete.php?id=<?= $idProvisionamento ?>"><input type="button" class="btn btn-danger" value="Confirmar"></input></a>
            </div>
        </div>
    </div>
</div>