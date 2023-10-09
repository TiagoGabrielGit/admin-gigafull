<?php
require "../../includes/menu.php";

?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Documentação APIs</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Chamados</h5>

                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingChamados-1">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseChamados-1" aria-expanded="false" aria-controls="collapseChamados-1">
                                        Abertura de Chamado - GET
                                    </button>
                                </h2>
                                <div id="collapseChamados-1" class="accordion-collapse collapse" aria-labelledby="headingChamados-1" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <b>Caminho:</b> /api_externa/abertura_chamado.php<br>
                                                <b>Corpo:</b> 'assunto' ; 'tipo' ; 'solicitante' ; 'empresa' ; 'relato' ; 'service'<br>
                                            </div>
                                            <div class="col-lg-6">
                                                <b> Descrição do corpo</b><br>
                                                <b>assunto:</b> Assunto do chamado<br>
                                                <b>tipo:</b> ID do tipo de chamado<br>
                                                <b>solicitante:</b> ID do usuário solicitante<br>
                                                <b>empresa:</b> ID da empresa<br>
                                                <b>relato:</b> Relato do chamado<br>
                                                <b>service:</b>ID do serviço vinculado ao contrato da empresa<br>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <b>Exemplo de uso com zabbix:</b>
                                            wget --spider -r https://smartcontrol.dominio.com.br/api_externa/abertura_chamado.php?assunto='{EVENT.NAME}'\&tipo=26\&solicitante=9999\&empresa=2\&relato='{TRIGGER.DESCRIPTION}'\&service=10 -P /tmp/
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingChamados-2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseChamados-2" aria-expanded="false" aria-controls="collapseChamados-2">
                                        Atualização de Incidente - GET
                                    </button>
                                </h2>
                                <div id="collapseChamados-2" class="accordion-collapse collapse" aria-labelledby="headingChamados-2" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <b>Funcionalidade: Update Incidente</b><br>
                                                <b>Método:</b> GET <br>
                                                <b>Caminho:</b> /api_externa/update_incidente.php<br>
                                                <b>Corpo:</b> 'updateMessage' ; 'eventID' <br>
                                            </div>
                                            <div class="col-lg-6">
                                                <b> Descrição do corpo</b><br>
                                                <b>updateMessage:</b> Conteúdo da Mensagem<br>
                                                <b>eventID:</b> ID do evento no sistema integrador<br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingChamados-3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseChamados-3" aria-expanded="false" aria-controls="collapseChamados-3">
                                        Normalização de Incidente - GET
                                    </button>
                                </h2>
                                <div id="collapseChamados-3" class="accordion-collapse collapse" aria-labelledby="headingChamados-3" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <b>Funcionalidade: Normalizar Incidente</b><br>
                                                <b>Método:</b> GET <br>
                                                <b>Caminho:</b> /api_externa/resolve_incidente.php<br>
                                                <b>Corpo:</b> 'eventID' <br>
                                            </div>
                                            <div class="col-lg-6">
                                                <b> Descrição do corpo</b><br>
                                                <b>eventID:</b> ID do evento no sistema integrador<br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
-->
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Incidentes</h5>

                        <div class="accordion" id="accordionExample">

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingIncidentes-4">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIncidentes-4" aria-expanded="false" aria-controls="collapseIncidentes-4">
                                        Abertura de Incidente (Tipo Backbone) - GET
                                    </button>
                                </h2>
                                <div id="collapseIncidentes-4" class="accordion-collapse collapse" aria-labelledby="headingIncidentes-4" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <b>API:</b><br> /api_externa/new_incidente_backbone.php?eventID={id_evento}&descricaoIncidente={descricao_aleatorio}&incidentType=102&hostID={id_host}<br><br>

                                                <b>id_host:</b>
                                                Código da rota de fibra em "Rotas de Fibra".<br>
                                                <b>descricao_aleatorio:</b>
                                                Descrição do evento.<br>
                                                <b>id_evento:</b>
                                                ID do evento no sistema integrador.<br><br>

                                                <b>Exemplo:</b><br>
                                                https://smartcontrol.dominio.com.br/api_externa/new_incidente_backbone.php?eventID='1000'&descricaoIncidente='Rompimento na rede'&incidentType='102'&hostID='25'
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingIncidentes-1">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIncidentes-1" aria-expanded="false" aria-controls="collapseIncidentes-1">
                                        Abertura de Incidente (Tipo GPON) - GET
                                    </button>
                                </h2>
                                <div id="collapseIncidentes-1" class="accordion-collapse collapse" aria-labelledby="headingIncidentes-1" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <b>API:</b><br> /api_externa/new_incidente_gpon.php?eventID={id_evento}&descricaoIncidente={descricao_aleatorio}&incidentType=100&hostID={id_host}&gponPON={slot_pon}<br><br>

                                                <b>id_host:</b>
                                                ID do cadastro da OLT em "Credenciais".<br>
                                                <b>descricao_aleatorio:</b>
                                                Descrição do evento.<br>
                                                <b>id_evento:</b>
                                                ID do evento no sistema integrador.<br><br>

                                                <b>Exemplo:</b><br>
                                                https://smartcontrol.dominio.com.br/api_externa/new_incidente_gpon.php?eventID='1000'&descricaoIncidente='Rompimento na rede'&incidentType='100'&hostID='25'&gponPON='GPON 0/4/12'

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingIncidentes-5">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIncidentes-5" aria-expanded="false" aria-controls="collapseIncidentes-5">
                                        Abertura de Incidente (Outros) - GET
                                    </button>
                                </h2>
                                <div id="collapseIncidentes-5" class="accordion-collapse collapse" aria-labelledby="headingIncidentes-5" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <b>API:</b><br> /api_externa/new_incidente_other.php?eventID={id_evento}&descricaoIncidente={descricao_aleatorio}&incidentType={id_tipo_incidente}&hostID={id_host}<br><br>

                                                <b>id_host:</b>
                                                ID do Equipamento no SmartControl, ou '0' casa não exista.<br>
                                                <b>descricao_aleatorio:</b>
                                                Descrição do evento.<br>
                                                <b>id_evento:</b>
                                                ID do evento no sistema integrador.<br><br>

                                                <b>Exemplo:</b><br>
                                                https://smartcontrol.dominio.com.br/api_externa/new_incidente_other.php?eventID='1000'&descricaoIncidente='Falta de Energia da concessionária'&incidentType='id_tipo_incidente'&hostID='25'
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingIncidentes-2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIncidentes-2" aria-expanded="false" aria-controls="collapseIncidentes-2">
                                        Atualização de Incidente - GET
                                    </button>
                                </h2>
                                <div id="collapseIncidentes-2" class="accordion-collapse collapse" aria-labelledby="headingIncidentes-2" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <b>Caminho:</b> /api_externa/update_incidente.php<br>
                                                <b>Corpo:</b> 'updateMessage' ; 'eventID' <br>
                                            </div>
                                            <div class="col-lg-6">
                                                <b> Descrição do corpo</b><br>
                                                <b>updateMessage:</b> Conteúdo da Mensagem<br>
                                                <b>eventID:</b> ID do evento no sistema integrador<br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingIncidentes-3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIncidentes-3" aria-expanded="false" aria-controls="collapseIncidentes-3">
                                        Normalização de Incidente - GET
                                    </button>
                                </h2>
                                <div id="collapseIncidentes-3" class="accordion-collapse collapse" aria-labelledby="headingIncidentes-3" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <b>Caminho:</b> /api_externa/resolve_incidente.php<br>
                                                <b>Corpo:</b> 'eventID' <br>
                                            </div>
                                            <div class="col-lg-6">
                                                <b> Descrição do corpo</b><br>
                                                <b>eventID:</b> ID do evento no sistema integrador<br>
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
</main><!-- End #main -->
<?php
require "../../includes/footer.php";
?>