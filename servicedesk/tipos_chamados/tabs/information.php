<div class="card-body">
    <h5 class="card-title">Tipo de Chamado</h5>

    <!-- Multi Columns Form -->

    <!-- Multi Columns Form -->
    <form method="POST" id="editarTipoChamado" class="row g-3">
        <span id="msgEditarTipoChamado1"></span>
        <input type="hidden" name="id" value="<?= $id ?>">

        <hr class="sidebar-divider">

        <div class="col-lg-8">
            <div class="row">
                <div class="col-3">
                    <label for="codigo" class="form-label">Código</label>
                    <input readonly name="codigo" type="text" class="form-control" id="codigo" value="<?= $id ?>">
                </div>

                <div class="col-8">
                    <label for="tipoChamadoEdit" class="form-label">Tipo de Chamado</label>
                    <input name="tipoChamadoEdit" type="text" class="form-control" id="tipoChamadoEdit" value="<?= $c_tipo_chamado['nome_tipo']; ?>">
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="col-12">
                <label for="situacao" class="form-label">Situação</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="situacao" id="situacaoAtivo" value="1" <?= $checkSituacao1 ?>>
                    <label class="form-check-label" for="situacaoAtivo">
                        Ativo
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="situacao" id="situacaoInativo" value="0" <?= $checkSituacao0 ?>>
                    <label class="form-check-label" for="situacaoInativo">
                        Inativo
                    </label>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="row mb-3">
                <label class="col-sm-5 col-form-label">Permite selecionar atendente na abertura</label>
                <div class="col-sm-2">

                    <select name="selectAtendenteAbertura" id="selectAtendenteAbertura" class="form-select" aria-label="Default select example">
                        <option value="1" <?= ($c_tipo_chamado['permite_atendente_abertura'] == "1") ? "selected" : "" ?>>Sim</option>
                        <option value="0" <?= ($c_tipo_chamado['permite_atendente_abertura'] == "0") ? "selected" : "" ?>>Não</option>
                    </select>


                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="row mb-3">
                <label class="col-sm-5 col-form-label">Permite selecionar data de entrega</label>
                <div class="col-sm-2">
                    <select name="selectEntrega" id="selectEntrega" class="form-select" aria-label="Default select example">
                        <option value="1" <?= ($c_tipo_chamado['permite_data_entrega'] == "1") ? "selected" : "" ?>>Sim</option>
                        <option value="0" <?= ($c_tipo_chamado['permite_data_entrega'] == "0") ? "selected" : "" ?>>Não</option>
                    </select>

                </div>

                <div id="campoEntrega" class="col-sm-5" style="display: none;">
                    <input value="<?= $c_tipo_chamado['tempo_entrega'] ?>" type="number" placeholder="Tempo mínimo para entrega (em horas)" class="form-control" name="tempoEntrega" id="tempoEntrega" min="0">
                </div>
            </div>
        </div>

        <hr class="sidebar-divider">
        <div class="text-center">
            <span id="msgEditarCompetencia2"></span>
        </div>

        <div class="text-center">
            <input id="btnEditar" name="btnEditar" type="button" value="Salvar Alterações" class="btn btn-danger"></input>
            <input type="button" value="Voltar" onClick="history.go(-1)" class="btn btn-secondary">
        </div>
    </form><!-- End Multi Columns Form -->
</div>