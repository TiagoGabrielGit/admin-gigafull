<div class="modal fade" id="modalNovoServico" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Serviço</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body">
                <div class="card-body">
                    <!-- Vertical Form -->
                    <form id="formNewService" method="POST" class="row g-3">
                        <div class="col-6">
                            <label for="Servico" class="form-label">Serviço</label>
                            <input name="Servico" type="text" class="form-control" id="Servico" required>
                        </div>

                        <div class="col-3">
                            <label for="Unidade" class="form-label">Unidade</label>
                            <select id="Unidade" name="Unidade" class="form-select" required>
                                <option value="" disabled selected>Selecione</option>
                                <option value="1">Hora</option>
                            </select>
                        </div>

                        <div class="col-3">
                            <label for="StatusServico" class="form-label">Status</label>
                            <select id="StatusServico" name="StatusServico" class="form-select" required>
                                <option value="1" selected>Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>

                        <hr class="sidebar-divider">

                        <div class="row" id="unidadeHora">
                            <div class="col-4">
                                <label for="PacoteHoras" class="form-label">Pacote de Horas</label>
                                <input name="PacoteHoras" type="number" class="form-control" id="PacoteHoras" placeholder="Quantidade de horas" required>
                            </div>

                            <div class="col-4">
                                <label for="ValorHora" class="form-label">Valor da Hora</label>
                                <input name="ValorHora" type="number" class="form-control" id="ValorHora" placeholder="Valor da hora" required>
                            </div>

                            <div class="col-4">
                                <label for="ValorHoraExcedente" class="form-label">Valor da Hora Excedente</label>
                                <input name="ValorHoraExcedente" type="number" class="form-control" id="ValorHoraExcedente" placeholder="Valor da hora excedente" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <span id="msgCadastro"></span>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <input id="btnSalvar" name="btnSalvar" type="button" value="Salvar" class="btn btn-danger"></input>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div><!-- End Large Modal-->