<div class="card-body">
    <h5 class="card-title">Informações de Notificação</h5>

    <form method="POST" action="processa/adiciona_notificacao.php" class="row g-3">
        <input type="hidden" name="notificacaoIdEmpresa" value="<?= $row['id_empresa']; ?>">

        <hr class="sidebar-divider">

        <div class="row">
            <div class="col-4">
                <label for="notificacaoMetodo" class="form-label">Método</label>
                <select required id="notificacaoMetodo" name="notificacaoMetodo" class="form-select">
                    <option value="" disabled>Selecione...</option>
                    <option value="1">E-mail</option>
                    <option value="2">Grupo Telegram</option>
                    <option value="3">Grupo Whatsapp</option>
                </select>
            </div>

            <div class="col-4">
                <label for="notificacaoMidia" class="form-label">Mídia</label>
                <input required name="notificacaoMidia" type="text" class="form-control" id="notificacaoMidia">
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
                <th scope="col">Método</th>
                <th scope="col">Mídia</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $midias =
                "SELECT
                en.id as idMidia,
                CASE
                WHEN en.metodo_id = 1 THEN 'E-mail'
                WHEN en.metodo_id = 2 THEN 'Grupo Telegram'
                WHEN en.metodo_id = 3 THEN 'Grupo Whatsapp'
                END as metodo,
                en.midia as midia
                FROM
                empresas_notificacao as en
                WHERE
                en.active = 1
                and
                en.empresa_id = $id
                ";

            $r_midias = mysqli_query($mysqli, $midias) or die("Erro ao retornar dados");

            // Obtendo os dados por meio de um loop while
            while ($c_midias = $r_midias->fetch_array()) {
                $idMidia = $c_midias['idMidia']; ?>
                <tr id="tabelaLista">
                    <td><?= $c_midias['metodo']; ?></td>
                    <td><?= $c_midias['midia']; ?></td>
                    <td>
                        <form method="POST" action="processa/excluir_notificacao.php">
                            <input type="hidden" name="excMidiaIdEmpresa" value="<?= $row['id_empresa']; ?>">

                            <input readonly hidden id="idMidia" name="idMidia" value="<?= $idMidia ?>"> </input>
                            <button class="btn btn-sm btn-danger">Excluir</button>

                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>