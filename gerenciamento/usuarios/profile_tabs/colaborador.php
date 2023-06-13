<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Horário de Trabalho</h2>
                    <table class="table">
                        <tr>
                            <th style="text-align: center;">Dia da Semana</th>
                            <th style="text-align: center;">Início P1</th>
                            <th style="text-align: center;">Fim P1</th>
                            <th style="text-align: center;">Início P2</th>
                            <th style="text-align: center;">Fim P2</th>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Segunda</td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['seg_ini_p1'] ?>" type="time" class="form-control"></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['seg_fim_p1'] ?>" type="time" class="form-control"></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['seg_ini_p2'] ?>" type="time" class="form-control"></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['seg_fim_p2'] ?>" type="time" class="form-control"></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Terça</td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['ter_ini_p1'] ?>" type="time" class="form-control"></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['ter_fim_p1'] ?>" type="time" class="form-control"></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['ter_ini_p2'] ?>" type="time" class="form-control"></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['ter_fim_p2'] ?>" type="time" class="form-control"></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Quarta</td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['qua_ini_p1'] ?>" class="form-control" type="time" name="quarta_inicio_p1" required></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['qua_fim_p1'] ?>" class="form-control" type="time" name="quarta_fim_p1" required></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['qua_ini_p2'] ?>" class="form-control" type="time" name="quarta_inicio_p2" required></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['qua_fim_p2'] ?>" class="form-control" type="time" name="quarta_fim_p2" required></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Quinta</td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['qui_ini_p1'] ?>" class="form-control" type="time" name="quinta_inicio_p1" required></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['qui_fim_p1'] ?>" class="form-control" type="time" name="quinta_fim_p1" required></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['qui_ini_p2'] ?>" class="form-control" type="time" name="quinta_inicio_p2" required></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['qui_fim_p2'] ?>" class="form-control" type="time" name="quinta_fim_p2" required></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Sexta</td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['sex_ini_p1'] ?>" class="form-control" type="time" name="sexta_inicio_p1" required></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['sex_fim_p1'] ?>" class="form-control" type="time" name="sexta_fim_p1" required></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['sex_ini_p2'] ?>" class="form-control" type="time" name="sexta_inicio_p2" required></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['sex_fim_p2'] ?>" class="form-control" type="time" name="sexta_fim_p2" required></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Sábado</td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['sab_ini_p1'] ?>" class="form-control" type="time" name="sabado_inicio_p1" required></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['sab_fim_p1'] ?>" class="form-control" type="time" name="sabado_fim_p1" required></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['sab_ini_p2'] ?>" class="form-control" type="time" name="sabado_inicio_p2" required></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['sab_fim_p2'] ?>" class="form-control" type="time" name="sabado_fim_p2" required></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">Domingo</td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['dom_ini_p1'] ?>" class="form-control" type="time" name="domingo_inicio_p1" required></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['dom_fim_p1'] ?>" class="form-control" type="time" name="domingo_fim_p1" required></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['dom_ini_p2'] ?>" class="form-control" type="time" name="domingo_inicio_p2" required></td>
                            <td style="text-align: center;"><input style="text-align: center;" readonly value="<?= $c_horarioTrabalho['dom_fim_p2'] ?>" class="form-control" type="time" name="domingo_fim_p2" required></td>
                        </tr>
                        <!-- Repita os blocos <tr> para cada dia da semana -->
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Gerencia</h2>
                    <div class="col-12">
                        <label for="gerente" class="form-label">Gerente</label>
                        <input value="<?= $gerente ?>" readonly class="form-control"></input>
                    </div>

                    <div class="col-12">
                        <label for="coordenador" class="form-label">Coordenador</label>
                        <input value="<?= $coordenador ?>" readonly class="form-control"></input>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr class="sidebar-divider">
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="card-title">Requisitar</h2>
                    <div class="row">
                        <div class="col-6">
                            <label for="inputRequisicao" class="form-label">Requisição</label>
                            <select names="inputRequisicao" id="inputRequisicao" class="form-select" onchange="mostrarFormulario()">
                                <option disabled selected="">Selecione...</option>
                                <option disabled value="atestado">Atestado</option>
                                <option value="plantao">Plantão</option>
                                <option disabled value="3">Solicitação Ausencia</option>
                                <option disabled value="4">Solicitação Férias</option>
                                <option disabled value="5">Solicitação Home Office</option>
                                <option disabled value="6">Solicitação Folga - Banco de Horas</option>
                                <option disabled value="7">Solicitação Folga - Remunerada</option>
                                <option disabled value="8">Solicitação Hora Extra</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-12" id="form-atestado" style="display: none;">
                        <div class="col-lg-12">
                            <div class="row">
                                <form action="">
                                    <div>
                                        <div class="col-lg-12">
                                            <label for="inputNumber" class="col-form-label">File Upload</label>
                                            <input class="form-control" type="file" id="formFile">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12" id="form-plantao" style="display: none;">
                        <div class="col-lg-12">
                            <div class="row">
                                <form method="POST" id="formPlantao">
                                    <input readonly type="number" hidden value="<?= $usuarioID ?>" name="idUser" id="idUser">

                                    <div class="row">
                                        <div class="col-6">
                                            <label for="inputDateInicio" class="col-form-label">Data Inicio</label>
                                            <input id="inputDateInicio" name="inputDateInicio" type="date" class="form-control">
                                        </div>
                                        <div class="col-6">
                                            <label for="inputDateFim" class=" col-form-label">Data Final</label>
                                            <input id="inputDateFim" name="inputDateFim" type="date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="contatoEmergencia" class="form-label">Contato Emergência</label>
                                            <input type="number" class="form-control" name="contatoEmergencia" id="contatoEmergencia">
                                        </div>

                                        <div class="col-6">
                                            <legend class="col-form-label">Formas Contato</legend>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ligacao" id="ligacao">
                                                <label class="form-check-label" for="ligacao">
                                                    Ligação
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ligacaoWhatsapp" id="ligacaoWhatsapp">
                                                <label class="form-check-label" for="ligacaoWhatsapp">
                                                    Ligação via Whatsapp
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="telegram" id="telegram">
                                                <label class="form-check-label" for="telegram">
                                                    Telegram
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="whatsapp" id="whatsapp">
                                                <label class="form-check-label" for="whatsapp">
                                                    Whatsapp
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <span id="msgSolicitarPlantao"></span>
                                    <div class="col-12" style="text-align: center;">
                                        <input id="btnSolicitarPlantao" name="btnSolicitarPlantao" type="button" value="Solicitar" class="btn btn-danger"></input>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <h2 class="card-title">Requisições Realizadas</h2>
                    <div class="col-12">
                        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
                            <div class="datatable-container">
                                <table class="table datatable datatable-table">
                                    <thead>
                                        <tr>
                                            <th data-sortable="true"><a href="#" class="datatable-sorter">Requisição</a></th>
                                            <th data-sortable="true"><a href="#" class="datatable-sorter">Status</a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cont = "0";
                                        while ($c_request_colaborador = $r_request_colaborador->fetch_array()) { ?>
                                            <tr data-index="<?= $cont ?>">
                                                <td style="text-align: center;"><?= $c_request_colaborador['requisicao'] ?></td>
                                                <td style="text-align: center;"><?= $c_request_colaborador['status'] ?></td>
                                            </tr>
                                    </tbody>
                                <?php $cont++;
                                        } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>