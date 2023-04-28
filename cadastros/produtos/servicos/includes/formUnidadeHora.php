<form id="formEditService" method="POST" class="row g-3">

    <span id="msgEditar"></span>
    <input name="id" type="text" class="form-control" id="id" value="<?= $idServico ?>" hidden>
    <input name="unidadeHidden" type="text" class="form-control" id="unidadeHidden" value="<?= $campos_servico['unidadeHidden']; ?>" hidden>

    <div class="col-5">
        <label for="descricao" class="form-label">Descrição</label>
        <input name="descricao" type="text" class="form-control" id="descricao" value="<?= $campos_servico['descricao']; ?>" required>
    </div>

    <div class="col-5"></div>

    <div class="col-2">
        <label for="StatusServico" class="form-label">Status</label>
        <select id="StatusServico" name="StatusServico" class="form-select" required>
            <option value="1" <?= $statusServicoAtivo ?>>Ativo</option>
            <option value="0" <?= $statusServicoInativo ?>>Inativo</option>
        </select>
    </div>

    <div class="col-3">
        <label for="servico" class="form-label">Serviço</label>
        <input name="servico" type="text" class="form-control" id="servico" value="<?= $campos_servico['servico']; ?>" disabled>
    </div>

    <div class="col-3">
        <label for="unidade" class="form-label">Unidade</label>
        <input name="unidade" type="text" class="form-control" id="unidade" value="<?= $campos_servico['unidade']; ?>" disabled>
    </div>
    <div class="col-6"></div>
    <div class="col-3">
        <label for="pacoteHoras" class="form-label">Pacote de Horas</label>
        <input name="pacoteHoras" type="number" class="form-control" id="pacoteHoras" value="<?= $campos_servico['pacoteHoras']; ?>" required>
    </div>

    <div class="col-3">
        <label for="valorHora" class="form-label">Valor da Hora (R$)</label>
        <input name="valorHora" type="text" onkeypress="$(this).mask('R$ #.##0,00', {reverse: true});" class="form-control" id="valorHora" value="<?= $valorHora?>" required>
    </div>

    <div class="col-3">
        <label for="valorHoraExcedente" class="form-label">Valor da Hora Excedente (R$)</label>
        <input name="valorHoraExcedente" type="text" onkeypress="$(this).mask('R$ #.##0,00', {reverse: true});" class="form-control" id="valorHoraExcedente" value="<?= $valorHoraExcedente ?>" required>
    </div>

    <hr class="sidebar-divider">

    <div class="col-12" style="text-align: center;">
        <input id="btnEditar" name="btnEditar" type="button" value="Salvar" class="btn btn-danger"></input>
        <a href="/cadastros/produtos/servicos/index.php"><input type="button" value="Voltar" class="btn btn-secondary"></a>
    </div>

</form><!-- Vertical Form -->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>