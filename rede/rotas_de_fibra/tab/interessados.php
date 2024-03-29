<div class="card-body">
    <h5 class="card-title">Interessados</h5>

    <form method="POST" action="processa/adiciona_interessado.php" class="row g-3">
        <hr class="sidebar-divider">

        <div class="row">
            <div class="col-4">
                <label for="rotaInteressado" class="form-label">Rota</label>
                <select required id="rotaInteressado" name="rotaInteressado" class="form-select">
                    <option value="" disabled selected>Selecione...</option>
                    <?php
                    $lista_rotas = "SELECT
                        rf.id as idRota,
                        rf.ponta_a as ponta_a,
                        rf.ponta_b as ponta_b
                        FROM
                        rotas_fibra as rf
                        WHERE
                        rf.active = 1
                        ORDER BY
                        rf.ponta_a ASC";
                    $result = mysqli_query($mysqli, $lista_rotas) or die("Erro ao retornar dados");
                    while ($row = mysqli_fetch_assoc($result)) {
                        $idRota = $row['idRota'];
                        $pontaA = $row['ponta_a'];
                        $pontaB = $row['ponta_b'];
                    ?>
                        <option value="<?= $idRota; ?>"><?= $pontaA . ' - ' . $pontaB; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="col-4">
                <label for="notificacaoMetodo" class="form-label">Interessado</label>
                <select required id="notificacaoMetodo" name="notificacaoMetodo" class="form-select">
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
                <th scope="col">Rota</th>
                <th scope="col">Interessado</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $interessados_cadastrados =
                "SELECT
                rfi.id as interessadoID,
                e.fantasia as fantasia,
                rf.ponta_a as ponta_a,
                rf.ponta_b as ponta_b
                FROM
                rotas_fibras_interessados as rfi
                LEFT JOIN
                empresas as e
                ON
                e.id = rfi.interessado_empresa_id
                LEFT JOIN
                rotas_fibra as rf
                ON rf.id = rfi.rf_id
                WHERE
                rfi.active = 1
                ORDER BY
                rf.ponta_a ASC,
                rf.ponta_b ASC
                ";
            $r_cadastrados = mysqli_query($mysqli, $interessados_cadastrados) or die("Erro ao retornar dados");
            while ($c_cadastrados = $r_cadastrados->fetch_array()) {
                $interessadoID = $c_cadastrados['interessadoID'];
            ?>
                <tr id="tabelaLista">
                    <td><?= $c_cadastrados['ponta_a'] ?> - <?= $c_cadastrados['ponta_b'] ?></td>
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