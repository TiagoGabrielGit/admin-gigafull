<div class="modal fade" id="programarChamado" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-body">
                <div class="card-body">

                    <hr class="sidebar-divider">

                    <!-- Vertical Form -->
                    <form id="formAgendaChamado" method="POST" class="row g-3">

                        <span id="exibeMensagem"></span>

                        <span>Dados do Agendamento</span>

                        <div class="col-4">
                            <label for="nameEvent" class="form-label">Evento</label>
                            <input name="nameEvent" type="text" class="form-control" id="nameEvent" required>
                        </div>

                        <div class="col-8">
                            <label for="descEvent" class="form-label">Descrição</label>
                            <textarea style="resize: none" rows="2" name="descEvent" type="text" class="form-control" id="descEvent" required></textarea>
                            <!-- <input name="descEvent" type="text" class="form-control" id="descEvent" required> -->
                        </div>

                        <div class="col-4">
                            <label for="tipoAgendamento" class="form-label">Tipo de Agendamento</label>
                            <select id="tipoAgendamento" name="tipoAgendamento" class="form-select" required>
                                <option selected disabled>Selecione</option>
                                <option value="YEAR">Anual</option>
                                <option value="DAY">Dia</option>
                                <option value="HOUR">Hora</option>
                                <option value="MONTH">Mensal</option>
                                <option value="MINUTE">Minuto</option>
                            </select>
                        </div>

                        <div class="col-4">
                            <label for="intervaloAgendamento" class="form-label">Intervalo</label>
                            <select id="intervaloAgendamento" name="intervaloAgendamento" class="form-select" required>
                                <option selected disabled>Selecione</option>
                                <?php
                                $cnt = 1;
                                while ($cnt <= 12) { ?>
                                    <option value="<?= $cnt ?>"><?= $cnt ?></option>
                                <?php $cnt++;
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-4"></div>

                        <div class="col-4">
                            <label for="inicioAgendamento" class="form-label">Inicio</label>
                            <input name="inicioAgendamento" type="datetime-local" class="form-control" id="inicioAgendamento" required>
                        </div>

                        <div class="col-4">
                            <label for="fimAgendamento" class="form-label">Fim</label>
                            <input name="fimAgendamento" type="datetime-local" class="form-control" id="fimAgendamento" required>
                        </div>

                        <hr class="sidebar-divider">

                        <span>Dados do Chamado</span>

                        <input hidden id="solicitante" name="solicitante" value="<?= $id_usuario ?>"></input> 

                        <div class="col-6">
                            <label for="empresaChamado" class="form-label">Empresa</label>
                            <select class="form-select" id="empresaChamado" name="empresaChamado" required>
                                <option disabled selected value="">Selecione a empresa</option>
                                <?php
                                $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                while ($tipos = mysqli_fetch_object($resultado)) :
                                    echo "<option value='$tipos->id_empresa'> $tipos->fantasia_empresa</option>";
                                endwhile;
                                ?>
                            </select>
                        </div>

                        <div class="col-6">
                            <label for="tipoChamado" class="form-label">Tipo de chamado</label>
                            <select class="form-select" id="tipoChamado" name="tipoChamado" required>
                                <option disabled selected value="">Selecione o tipo de chamado</option>
                                <?php
                                $resultado = mysqli_query($mysqli, $sql_lista_tipos_chamados);
                                while ($tipos = mysqli_fetch_object($resultado)) :
                                    echo "<option value='$tipos->id'> $tipos->tipo</option>";
                                endwhile;
                                ?>
                            </select>
                        </div>

                        <div class="col-6">
                            <label for="assuntoChamado" class="form-label">Assunto</label>
                            <input type="text" class="form-control" id="assuntoChamado" name="assuntoChamado" required>
                        </div>

                        <div class="col-12">
                            <label for="relatoChamado" class="form-label">Descreva a situação</label>
                            <textarea id="relatoChamado" name="relatoChamado" class="form-control" maxlength="1000" required></textarea>
                        </div>

                        <hr class="sidebar-divider">

                        <div class="text-center">
                            <button id="buttonAgendarChamado" class="btn btn-danger" type="button">Agendar</button>
                            <a href="/servicedesk/chamados_programados/index.php"> <input type="button" value="Voltar" class="btn btn-secondary"></input></a>
                        </div>
                    </form><!-- Vertical Form -->
                </div>
            </div>
        </div>
    </div>
</div>