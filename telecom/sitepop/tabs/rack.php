<div class="card">
    <div class="card-body">
        <h5 class="card-title">Rack's no POP</h5>
        <div class="datatable-wrapper datatable-loading no-footer sortable searchable fixed-columns">
            <div class="datatable-container">
                <table class="table datatable datatable-table">
                    <thead>
                        <tr>
                            <th data-sortable="true" style="width: 20%;">POP</a></th>

                            <th data-sortable="true" style="width: 40%;">
                                <a href="#" class="datatable-sorter">RACK</a>
                            </th>
                            <th data-sortable="true" style="width: 30%;">
                                <a href="#" class="datatable-sorter">Quantidade "U"</a>
                            </th>

                            <th data-sortable="true" style="width: 10%;"><a href="#" class="datatable-sorter">Polegada</a></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($c_lista_rack = $r_lista_rack->fetch_array()) { ?>
                            <tr>
                                <td><?= $c_lista_rack['pop']; ?></td>
                                <td><a href="rack_view.php?id=<?= $c_lista_rack['rack_id'] ?>"><span style="color: red;"><?= $c_lista_rack['rack']; ?></span></a></td>
                                <td><?= $c_lista_rack['tamanho']; ?></td>
                                <td><?= $c_lista_rack['polegada']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>