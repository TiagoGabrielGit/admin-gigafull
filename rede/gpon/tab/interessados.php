<div class="card-body">
    <h5 class="card-title">Interessados</h5>

    <form method="POST" action="processa/adicionar_interessados.php" class="row g-3">
        <hr class="sidebar-divider">

        <div class="row">
            <div class="col-4">
                <label for="oltInteressado" class="form-label">OLT</label>
                <select required id="oltInteressado" name="oltInteressado" class="form-select">
                    <option value="" disabled selected>Selecione...</option>
                    <?php
                    $lista_olts = "SELECT
                    gop.id as idOlt,
                    gop.olt_name as olt_name
                    FROM
                    gpon_olts as gop
                    WHERE
                    gop.active = 1
                    ORDER BY
                    gop.olt_name ASC";
                    $r_olts = mysqli_query($mysqli, $lista_olts) or die("Erro ao retornar dados");
                    while ($c_olts = mysqli_fetch_assoc($r_olts)) {
                    ?>
                        <option value="<?= $c_olts['idOlt']; ?>"><?= $c_olts['olt_name'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="col-4">
                <label for="empresaInteressada" class="form-label">Interessado</label>
                <select required id="empresaInteressada" name="empresaInteressada" class="form-select">
                    <option value="" disabled selected>Selecione...</option>
                    <?php
                    $lista_interessados =
                        "SELECT
                        e.id as idEmpresa,
                        e.fantasia as fantasia
                        FROM
                        empresas as e
                        WHERE
                        e.atributoCliente = 1
                        OR
                        e.atributoEmpresaPropria = 1
                        ORDER BY
                        e.fantasia ASC";

                    $r_interessados = mysqli_query($mysqli, $lista_interessados) or die("Erro ao retornar dados");
                    while ($c_interessados = mysqli_fetch_assoc($r_interessados)) {
                        $idEmpresa = $c_interessados['idEmpresa'];
                        $fantasia = $c_interessados['fantasia'];
                    ?>
                        <option value="<?= $idEmpresa ?>"><?= $fantasia ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="col-4">
                <button style="margin-top: 35px;" type="submit" class="btn btn-sm btn-danger">Adicionar</button>
            </div>
        </div>
    </form>
    <hr class="sidebar-divider">

    <table class="table datatable">
        <thead>
            <tr>
                <th scope="col">OLT</th>
                <th scope="col">Interessado</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $interessados_cadastrados =
                "SELECT
                goi.id as interessadoID,
                gpo.olt_name as olt_name,
                e.fantasia as fantasia
                FROM
                gpon_olts_interessados as goi
                LEFT JOIN
                empresas as e
                ON
                e.id = goi.interessado_empresa_id
                LEFT JOIN
                gpon_olts as gpo
                ON
                gpo.id = goi.gpon_olt_id
                WHERE
                goi.active = 1
                ORDER BY
                gpo.olt_name ASC,
                e.fantasia ASC";
            $r_cadastrados = mysqli_query($mysqli, $interessados_cadastrados) or die("Erro ao retornar dados");
            while ($c_cadastrados = $r_cadastrados->fetch_array()) {
                $interessadoID = $c_cadastrados['interessadoID'];
            ?>
                <tr id="tabelaLista">
                    <td><?= $c_cadastrados['olt_name'] ?></td>
                    <td><?= $c_cadastrados['fantasia'] ?></td>
                    <td>
                        <form method="POST" action="processa/excluir_interessado.php">
                            <input hidden readonly id="intID" name="intID" value="<?= $interessadoID ?>"></input>
                            <button class="btn btn-sm btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>