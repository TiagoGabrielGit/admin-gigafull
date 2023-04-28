<h5 class="card-title">ONU: <?= $campos['descricaoONU'] ?></h5>
<input id="idProvisionamento" value="<?= $idProvisionamento ?>" type="text" class="form-control" hidden>
<hr class="sidebar-divider">
<div class="row col-lg-12">
    <div class="row col-lg-6">
        <div class="col-lg-6">
            <div class="row col-12" style="margin-top: 3px;">
                <button style="height: 50px;" data-bs-toggle="modal" data-bs-target="#modalTAGVLAN" id="buttonTAGVLAN" class="btn btn-secondary" type="button">Adicionar TAG VLAN</button>
            </div>
            <div class="row col-12" style="margin-top: 3px;">
                <button id="btnConsultaConfiguracoes" style="height: 50px;" type="button" class="btn btn-secondary">Configurações ONU</button>
                <button id="btnConsultandoConfiguracoes" style="height: 50px;" class="btn btn-secondary" type="button" disabled="" hidden>Configurações ONU <span class="spinner-border spinner-border-sm" role="status" aria-hidden="false"></span> </button>
            </div>
            <div class="row col-12" style="margin-top: 3px;">
                <button style="height: 50px;" type="button" class="btn btn-secondary" disabled>Trocar ONU</button>
            </div>
            <div class="row col-12" style="margin-top: 3px;">
                <button id="btnConsultaPortasLAN" style="height: 50px;" type="button" class="btn btn-secondary">Status Portas LAN</button>
                <button id="btnConsultandoPortasLAN" style="height: 50px;" class="btn btn-secondary" type="button" disabled="" hidden>Status Portas LAN <span class="spinner-border spinner-border-sm" role="status" aria-hidden="false"></span> </button>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="row col-12" style="margin-top: 3px;">
                <button id="btnConsultaUltimosLogs" style="height: 50px;" type="button" class="btn btn-secondary">Últimos LOGs</button>
                <button id="btnConsultandoUltimosLogs" style="height: 50px;" class="btn btn-secondary" type="button" disabled="" hidden>Últimos LOGs <span class="spinner-border spinner-border-sm" role="status" aria-hidden="false"></span> </button>
            </div>
            <div class="row col-12" style="margin-top: 3px;">
                <button style="height: 50px;" type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalReiniciar">Reiniciar ONU</button>
            </div>
            <div class="row col-12" style="margin-top: 3px;">
                <button style="height: 50px;" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalResetar">Resetar ONU</button>
            </div>
            <div class="row col-12" style="margin-top: 3px;">
                <button style="height: 50px;" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDesprovisionar">Desprovisionar</button>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="col-lg-12">
            <form>
                <input id="idOLT" value="<?= $campos['idOLT'] ?>" type="text" class="form-control" hidden>
                <input id="slotOLT" value="<?= $campos['slotOLT'] ?>" type="text" class="form-control" hidden>
                <input id="ponOLT" value="<?= $campos['ponOLT'] ?>" type="text" class="form-control" hidden>
                <input id="idONU" value="<?= $campos['idONU'] ?>" type="text" class="form-control" hidden>
                <input id="provID" value="<?= $idProvisionamento ?>" type="text" class="form-control" hidden>

                <div class="col-12">
                    <label class="form-label">Resultados</label>

                    <textarea id="resultadoScripts" rows="15" type="text" class="form-control" disabled></textarea>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalReiniciar" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reiniciar ONU</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div hidden id="msgModalReiniciar" class="modal-body" style="text-align: center;">
                Tem certeza que deseja reiniciar a ONU?<br>
                <b style="color:red;"> Esta ação ira interromper temporariamente os serviços!</b>
            </div>
            <div hidden id="msgModalReiniciando" class="modal-body" style="text-align: center;">
                <div class="spinner-border" style="width: 50px; height: 50px;" role="status">
                </div><br>
                Reiniciando...
            </div>

            <div class="modal-body" style="text-align: center;">
                <span id="msgReiniciar"></span>
            </div>

            <div class="modal-footer">
                <button id="voltarModalReiniciar" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                <button id="confirmarModalReiniciar" onclick="resetar()" type="button" class="btn btn-danger">Confirmar</button>
                <input hidden id="okModalReiniciar" type="button" value="Ok" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"></input>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalResetar" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Resetar ONU</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div hidden id="msgModalResetar" class="modal-body" style="text-align: center;">
                Tem certeza que deseja resetar a ONU?<br>
                <b style="color:red;"> Esta ação ira remover todas as configuração do equipamento!</b>
            </div>
            <div hidden id="msgModalResetando" class="modal-body" style="text-align: center;">
                <div class="spinner-border" style="width: 50px; height: 50px;" role="status">
                </div><br>
                Resetando...
            </div>

            <div class="modal-body" style="text-align: center;">
                <span id="msgResetar"></span>
            </div>

            <div class="modal-footer">
                <button id="voltarModalResetar" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                <button id="confirmarModalResetar" onclick="resetar()" type="button" class="btn btn-danger">Confirmar</button>
                <input hidden id="okModalResetar" type="button" value="Ok" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close"></input>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDesprovisionar" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Desprovisionar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div hidden id="msgModalDesprovisionar" class="modal-body" style="text-align: center;">
                Tem certeza que deseja desprovisionar?
            </div>
            <div hidden id="msgModalDesprovisionando" class="modal-body" style="text-align: center;">
                <div class="spinner-border" style="width: 50px; height: 50px;" role="status">
                </div><br>
                Desprovisionando...
            </div>

            <div class="modal-body" style="text-align: center;">
                <span id="msgDesprovisionamento"></span>
            </div>

            <div class="modal-footer">
                <button id="voltarModalDesprovisionar" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                <button id="confirmarModalDesprovisionar" onclick="desprovisionar()" type="button" class="btn btn-danger">Confirmar</button>
                <a href="/redeNeutra/onus_Provisionadas/index.php"> <input hidden id="okModalDesprovisionar" type="button" value="Ok" class="btn btn-danger"></input></a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalTAGVLAN" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">TAG VLAN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTAGVLAN" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <label for="tipoVLAN" class="form-label"><b>Tipo</b></label>
                            <select class="form-select" id="tipoVLAN" name="tipoVLAN" required>
                                <option disabled selected value="">Selecione o tipo</option>
                                <option value="1">TAG</option>
                                <option value="2">UNTAGGED</option>
                            </select>
                        </div>

                        <div class="col-4">
                            <label for="VLAN" class="form-label">VLAN</label>
                            <input maxlength="4" name="VLAN" type="number" class="form-control" id="VLAN" required>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label"><b>Portas LAN</b></label>
                            <div class="row">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="LAN1" id="LAN1">
                                        <label class="form-check-label" for="LAN1">
                                            LAN 1
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="LAN2" id="LAN2">
                                        <label class="form-check-label" for="LAN2">
                                            LAN 2
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="LAN3" id="LAN3">
                                        <label class="form-check-label" for="LAN3">
                                            LAN 3
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="LAN4" id="LAN4">
                                        <label class="form-check-label" for="LAN4">
                                            LAN 4
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-2"></div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div style="text-align: center;" class="col-12">
                            <button id="buttonExecutaTAG" class="btn btn-danger" type="button">Executar</button>
                            <button hidden id="buttonExecutandoTAG" class="btn btn-danger" type="button" disabled=""><span class="spinner-border spinner-border-sm" role="status" aria-hidden="false"></span> Executando</button>
                            <button hidden id="buttonExecutadoTAG" class="btn btn-success" type="button">Executado</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>