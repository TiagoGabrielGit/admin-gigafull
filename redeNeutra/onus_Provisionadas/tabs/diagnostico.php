<h5 class="card-title">ONU: <?= $campos['descricaoONU'] ?></h5>
<input id="idProvisionamento" value="<?= $idProvisionamento ?>" type="text" class="form-control" hidden>
<hr class="sidebar-divider">
<div class="row">
    <div class="col-lg-6">

        <div id="loadingDiagONU" class="col-lg-12">
            <div class="row">
                <div class="col-12" style="text-align: center;">
                    <div class="spinner-border" style="width: 50px; height: 50px;" role="status">
                    </div>
                </div>
            </div>
        </div>

        <div hidden id="diagONU" class="col-lg-12 border-infos-olt">
            <span><b>Informações Coletadas na OLT</b></span>
            <div class="row">
                <div class="col-6">
                    <label class="form-label">Descrição na OLT</label>
                    <input id="descONU" type="text" class="form-control" disabled>
                </div>
                <div class="col-4">
                    <label class="form-label">Status ONU</label>
                    <input style="background: #fa6c61;" id="statusONUOffline" type="text" class="form-control" disabled hidden>
                    <input style="background: #08bf1a;" id="statusONUOnline" type="text" class="form-control" disabled hidden>
                </div>
            </div>

            <div class="row">
                <div class="col-8">
                    <label class="form-label">Serial ONU</label>
                    <input id="serialONU" type="text" class="form-control" disabled>
                </div>
            </div>

            <div id="infosDesconexao" hidden class="row border-desconexao">
                <span><b>Informações da Desconexão</b></span>
                <div class="col-4">
                    <label class="form-label">Motivo Desconexão</label>
                    <input id="causeONU" type="text" class="form-control" disabled>
                </div>

                <div class="col-6">
                    <label class="form-label">Horário Desconexão</label>
                    <input id="causeTime" type="text" class="form-control" disabled>
                </div>
            </div>

            <div id="infosConexao" hidden class="row border-conexao">
                <span><b>Informações da ONU</b></span>
                <div class="col-4">
                    <label class="form-label">Sinal ONU RX(dBm)</label>
                    <input id="sinalONU" type="text" class="form-control" disabled>
                </div>
                <div class="col-4">
                    <label class="form-label">Sinal OLT RX(dBm)</label>
                    <input id="sinalOLT" type="text" class="form-control" disabled>
                </div>
                <div class="col-4">
                    <label class="form-label">Temperatura ONU(C)</label>
                    <input id="temperaturaONU" type="text" class="form-control" disabled>
                </div>
            </div>
        </div>
    </div>
</div>