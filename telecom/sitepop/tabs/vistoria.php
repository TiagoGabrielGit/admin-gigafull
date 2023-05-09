<div class="card-body">

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="novaVistoria-tab" data-bs-toggle="tab" data-bs-target="#novaVistoria" type="button" role="tab" aria-controls="novaVistoria" aria-selected="true">Nova Vistoria</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="realizadas-tab" data-bs-toggle="tab" data-bs-target="#realizadas" type="button" role="tab" aria-controls="realizadas" aria-selected="false" tabindex="-1">Vistorias Realizadas</button>
        </li>
    </ul>
    <div class="tab-content pt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="novaVistoria" role="tabpanel" aria-labelledby="novaVistoria-tab">
            <div class="card-body">
                <form>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="dataVistoria" class="form-label">Data Vistoria</label>
                            <input id="dataVistoria" name="dataVistoria" type="date" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label for="responsavelVistoria" class="form-label">Responsável</label>
                            <select id="responsavelVistoria" name="responsavelVistoria" class="form-select" required>
                                <option disabled selected="">Selecione</option>
                                <option>...</option>
                            </select>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="limpezaPOP" class="form-label">Limpeza</label>
                            <textarea class="form-control" style="height: 100px"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="organizacaoPOP" class="form-label">Organização</label>
                            <textarea class="form-control" style="height: 100px"></textarea>
                        </div>
                    </div>






                    <div class="row">
                        <div class="col-mb-3">
                            <label for="limpezaPOP" class="col-sm-3 col-form-label">Limpeza</label>
                            <div class="col-sm-5">
                                <textarea class="form-control" style="height: 100px"></textarea>
                            </div>
                        </div>

                        <div class="col-mb-3">
                            <label for="organizacaoPOP" class="col-sm-3 col-form-label">Organização</label>
                            <div class="col-sm-5">
                                <textarea class="form-control" style="height: 100px"></textarea>
                            </div>
                        </div>
                    </div><br>


                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form><!-- End Multi Columns Form -->
            </div>
        </div>
        <div class="tab-pane fade " id="realizadas" role="tabpanel" aria-labelledby="rack-tab">
            VISTORIAS REALIZADAS
        </div>
    </div><!-- End Default Tabs -->
</div>