<?php
require "../../includes/menu.php";
?>

<style>
    .border-desconexao {

        border: 1px solid #737272 !important;
        margin-top: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        padding: 5px;
    }

    .border-conexao {

        border: 1px solid #737272 !important;
        margin-top: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        padding: 5px;
    }

    .border-infos-olt {
        border: 2px solid black !important;
        margin-top: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        padding-top: 5px;
        padding-right: 20px;
        padding-bottom: 10px;
        padding-left: 20px;
    }

    .border-infos-sistema {
        border: 2px solid black !important;
        margin-top: 10px;
        margin-bottom: 10px;
        margin-right: 1px;
        margin-left: 1px;
        border-radius: 5px;
        padding-top: 5px;
        padding-right: 10px;
        padding-bottom: 10px;
        padding-left: 10px;
    }
</style>

<?php
$idProvisionamento = $_GET['idProvisionamento'];

$sql_provisionamento =
    "SELECT
rnop.id as idProvisionamento,
rnop.descricao as descricaoONU,
rnop.slot_olt as slotOLT,
rnop.pon_olt as ponOLT,
rnop.id_onu as idONU,
rnop.serial_onu as serialONU,
e.fantasia as fantasia,
rno.olt_name as nameOLT,
rnop.olt_id as idOLT
FROM
redeneutra_onu_provisionadas as rnop
LEFT JOIN
redeneutra_parceiro as rnp
ON
rnp.id = rnop.parceiro_id
LEFT JOIN
empresas as e
ON
e.id = rnp.empresa_id
LEFT JOIN
redeneutra_olts as rno
ON
rno.id = rnop.olt_id
WHERE
rnop.id = $idProvisionamento
";

$r_provisionamento = mysqli_query($mysqli, $sql_provisionamento);
$campos = $r_provisionamento->fetch_array();
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Diagnóstico</h1>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Dados da ONU - Provisionamento <?= $idProvisionamento ?></h5>
                                    <input id="idProvisionamento" value="<?= $idProvisionamento ?>" type="text" class="form-control" hidden>
                                    <hr class="sidebar-divider">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="row border-infos-sistema">
                                                <span><b>Informações Armazenadas no Sistema</b></span>
                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="form-label">Descrição Provisionamento</label>
                                                            <input value="<?= $campos['descricaoONU'] ?>" type="text" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label class="form-label">Serial ONU</label>
                                                            <input value="<?= $campos['serialONU'] ?>" type="text" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <label class="form-label">SLOT</label>
                                                            <input value="<?= $campos['slotOLT'] ?>" type="text" class="form-control" disabled>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label">PON</label>
                                                            <input value="<?= $campos['ponOLT'] ?>" type="text" class="form-control" disabled>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label">ID ONU</label>
                                                            <input value="<?= $campos['idONU'] ?>" type="text" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="row">
                                                        <div class="col-4">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">Parceiro</label>
                                                            <input value="<?= $campos['fantasia'] ?>" type="text" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-4">
                                                        </div>
                                                        <div class="col-8">
                                                            <label class="form-label">OLT</label>
                                                            <input value="<?= $campos['nameOLT'] ?>" type="text" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr style="margin-top: 10px;" class="sidebar-divider">

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

                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-6">

                                                    <div class="row col-12" style="margin-top: 3px;">
                                                        <button style="height: 50px;" data-bs-toggle="modal" data-bs-target="#modalTAGVLAN" id="buttonTAGVLAN" class="btn btn-secondary" type="button">Adicionar TAG VLAN</button>
                                                    </div>
                                                    <div class="row col-12" style="margin-top: 3px;">
                                                        <button style="height: 50px;" type="button" class="btn btn-secondary">Trocar ONU</button>
                                                    </div>
                                                    <div class="row col-12" style="margin-top: 3px;">
                                                        <button id="btnConsultaPortasLAN" style="height: 50px;" type="button" class="btn btn-secondary">Status Portas LAN</button>
                                                        <button id="btnConsultandoPortasLAN" style="height: 50px;" class="btn btn-secondary" type="button" disabled="" hidden>Status Portas LAN <span class="spinner-border spinner-border-sm" role="status" aria-hidden="false"></span> </button>
                                                    </div>
                                                    <div class="row col-12" style="margin-top: 3px;">
                                                        <button style="height: 50px;" type="button" class="btn btn-warning">Reiniciar ONU</button>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">

                                                    <div class="row col-12" style="margin-top: 3px;">
                                                        <button id="btnConsultaUltimosLogs" style="height: 50px;" type="button" class="btn btn-secondary">Últimos LOGs</button>
                                                        <button id="btnConsultandoUltimosLogs" style="height: 50px;" class="btn btn-secondary" type="button" disabled="" hidden>Últimos LOGs <span class="spinner-border spinner-border-sm" role="status" aria-hidden="false"></span> </button>
                                                    </div>

                                                    <div class="row col-12" style="margin-top: 3px;">
                                                        <button id="btnConsultaConfiguracoes" style="height: 50px;" type="button" class="btn btn-secondary">Configurações ONU</button>
                                                        <button id="btnConsultandoConfiguracoes" style="height: 50px;" class="btn btn-secondary" type="button" disabled="" hidden>Configurações ONU <span class="spinner-border spinner-border-sm" role="status" aria-hidden="false"></span> </button>
                                                    </div>

                                                    <div class="row col-12" style="margin-top: 3px;">
                                                        <button style="height: 50px;" type="button" class="btn btn-danger">Resetar ONU</button>
                                                    </div>
                                                    <div class="row col-12" style="margin-top: 3px;">
                                                        <button style="height: 50px;" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDesprovisionar">Desprovisionar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <br><br>
                                            <div class="row">
                                                <form>
                                                    <input id="idOLT" value="<?= $campos['idOLT'] ?>" type="text" class="form-control" hidden>
                                                    <input id="slotOLT" value="<?= $campos['slotOLT'] ?>" type="text" class="form-control" hidden>
                                                    <input id="ponOLT" value="<?= $campos['ponOLT'] ?>" type="text" class="form-control" hidden>
                                                    <input id="idONU" value="<?= $campos['idONU'] ?>" type="text" class="form-control" hidden>

                                                    <div class="col-12">
                                                        <label class="form-label">Resultados</label>

                                                        <textarea id="resultadoScripts" rows="15" type="text" class="form-control" disabled></textarea>
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
            </div>
        </div>
    </section>
</main>

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

            <!--<div hidden id="msgModalFalhaDesprovisionar" class="modal-body" style="text-align: center;">
                Falha ao desprovisionar
            </div>-->

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

<?php
require "jscript.php";
require "../../includes/footer.php";
?>