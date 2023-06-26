<form>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bateria</h5>
                    <div class="row mb-3">
                        <label for="quantidadeBaterias" class="col-sm-4 col-form-label">Quantidade Baterias</label>
                        <div class="col-sm-3">
                            <select id="quantidadeBaterias" class="form-select">
                                <?php
                                $cont = 1;
                                while ($cont <= 12) { ?>
                                    <option><?= $cont ?></option>
                                <?php $cont++;
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div id="camposInput"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Autonomia</h5>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Monitoramento AC</h5>

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Fonte e Conversores</h5>

                </div>
            </div>
        </div>
    </div>
</form>