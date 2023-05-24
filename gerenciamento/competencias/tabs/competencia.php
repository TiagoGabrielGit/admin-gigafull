<div class="card-body">
    <h5 class="card-title">Cadastro</h5>

    <!-- Multi Columns Form -->

    <!-- Multi Columns Form -->
    <form method="POST" id="editarCompetencia" class="row g-3">
        <span id="msgEditarCompetencia1"></span>
        <input type="hidden" name="id" value="<?= $campos['idCompetencia']; ?>">

        <hr class="sidebar-divider">

        <div class="col-lg-6">
            <div class="row">
                <div class="col-3">
                    <label for="codigo" class="form-label">Código</label>
                    <input readonly name="codigo" type="text" class="form-control" id="codigo" value="<?= $campos['idCompetencia']; ?>">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-8">
                    <label for="competencia" class="form-label">Competência*</label>
                    <input name="competencia" type="text" class="form-control" id="competencia" value="<?= $campos['competencia']; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label for="descricao" class="form-label">Descrição*</label>
                    <textarea rows="8" id="descricao" name="descricao" class="form-control" maxlength="500"><?= $campos['descricao']; ?></textarea>

                </div>
            </div>
        </div>
        <div class="col-lg-6">
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