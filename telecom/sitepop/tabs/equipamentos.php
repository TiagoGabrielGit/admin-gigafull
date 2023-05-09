<div class="card">
    <div class="card-body">
        <h5 class="card-title">Equipamentos no POP</h5>
        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
            <div class="datatable-container">
                <table class="table datatable datatable-table">
                    <thead>
                        <tr>
                            <th data-sortable="true" style="width: 20%;">Rack</a></th>

                            <th data-sortable="true" style="width: 40%;">
                                <a href="#" class="datatable-sorter">Equipamento</a>
                            </th>
                            <th data-sortable="true" style="width: 30%;">
                                <a href="#" class="datatable-sorter">Modelo</a>
                            </th>
                            <th data-sortable="true" style="width: 10%;">
                                <a href="#" class="datatable-sorter">Status</a>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($c_lista_equipamentos = $r_lista_equipamentos->fetch_array()) { ?>
                            <tr data-index="<?= $c_lista_equipamentos['idEqp'] ?>">
                                <td><?= $c_lista_equipamentos['rack']; ?></td>
                                <td><a href="/telecom/credentials/equipamentos/view.php?id=<?= $c_lista_equipamentos['idEqp'] ?>"><span style="color: red;"><?= $c_lista_equipamentos['equipamento']; ?></span></a></td>
                                <td><?= $c_lista_equipamentos['modelo']; ?></td>
                                <td><?= $c_lista_equipamentos['status']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

