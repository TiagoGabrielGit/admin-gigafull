<div class="card-body">
    <h5 class="card-title">Mascara padrão do chamado</h5>


    <!-- Multi Columns Form -->
    <form method="POST" action="processa/mascara.php" class="row g-3">
        <input type="hidden" name="id_mascara" value="<?= $id ?>">

        <hr class="sidebar-divider">

        <div class="col-lg-12">
            <div class="row">
                <div class="col-6">
                    <label for="mascara" class="form-label">Mascara</label>
                    <textarea required style="resize: none;" rows="12" class="form-control" id="mascara" name="mascara"><?= $c_tipo_chamado['mascara'] ?></textarea>
                </div>
            </div>
        </div>

        <hr class="sidebar-divider">

        <div class="text-center">
            <button type="submit" class="btn btn-sm btn-danger">Salvar Alterações</button>
            <input type="button" value="Voltar" onClick="history.go(-1)" class="btn btn-sm btn-secondary">
        </div>
    </form><!-- End Multi Columns Form -->
</div>