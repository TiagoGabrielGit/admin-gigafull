<?php
require "../../includes/menu.php";
?>
<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Documentação APIs</h5>

                        <!-- Default Accordion -->
                        <div class="accordion" id="accordionExample">

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Abertura Protocolo
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        Envio E-mail
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body">
                                        <b>Método:</b> POST <br>
                                        <b>Caminho:</b> /mail/sendmail_POST.php<br>
                                        <b>Corpo:</b> 'destinatario' ; 'assunto' ; 'mensagem' ; 'servidorID'<br><br>


                                        <b>Método:</b> GET <br>
                                        <b>Caminho:</b> /mail/sendmail.php<br>
                                        <b>Corpo:</b> 'destinatario' ; 'assunto' ; 'mensagem' ; 'servidorID'<br><br>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Incidente
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <b>Funcionalidade: Abertura Incidente</b><br>
                                                <b>Método:</b> GET <br>
                                                <b>Caminho:</b> /api_externa/new_incidente.php<br>
                                                <b>Corpo:</b> 'ipHost' ; 'descricaoIncidente' ; 'eventID'<br>
                                            </div>
                                            <div class="col-lg-6">
                                                <b> Descrição do corpo</b><br>
                                                <b>ipHost:</b> IP do equipamento. O equipamento deve estar cadastrado no SmartControl com o endereço IP<br>
                                                <b>descricaoIncidente:</b> Descrição do evento<br>
                                                <b>eventID:</b> ID do evento no sistema integrador<br>
                                            </div>
                                        </div>

                                        <hr class="sidebar-divider">

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

                                        <hr class="sidebar-divider">

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

                                        <hr class="sidebar-divider">

                                    </div>
                                </div>
                            </div>
                        </div><!-- End Default Accordion Example -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<?php
require "../../includes/footer.php";
?>