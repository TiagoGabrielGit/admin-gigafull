<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <hr class="sidebar-divider">
                <form id="formNotificacaoEmail">
                    <span id="msgConfigNotEmail"></span>
                    <div class="row mb-5">
                        <label class="col-sm-2 col-form-label">Notificações</label>
                        <div class="col-sm-10">
                            <div class="form-check form-switch">
                                <?php
                                $sql_consulta_1 = "SELECT
                                ne.notificacao_id as notificacao_id,
                                ne.active as active,
                                se.server as servidor,
                                se.id as servidorID
                                FROM
                                notificacao_email as ne
                                LEFT JOIN
                                servermail as se
                                ON
                                se.id = ne.server_id
                                WHERE
                                ne.notificacao_id = 1";
                                $stmt_consulta1 = $pdo->query($sql_consulta_1);
                                $resultado_c1 = $stmt_consulta1->fetch(PDO::FETCH_ASSOC);

                                // Verifica se está ativo e define o valor para a propriedade 'checked'
                                $checked1 = ($resultado_c1['active'] == "1") ? 'checked' : '';

                                if (empty($resultado_c1['servidor'])) {
                                    $server_not1 = "<option selected disabled>Selecione um servidor de e-mail</option>";
                                } else {
                                    $c1_serverID = $resultado_c1['servidorID'];
                                    $c1_servidor = $resultado_c1['servidor'];
                                    $server_not1 = "<option value='$c1_serverID' selected>$c1_servidor</option>";
                                }


                                ?>
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked1" <?= $checked1; ?>>
                                <label class="form-check-label" for="flexSwitchCheckChecked1">(1) Envio de e-mail para usuários com competência para executar chamado.</label>
                                <select id="notificacao1_servidor" name="notificacao1_servidor" class="form-select form-select-sm" aria-label="Selecionar opção">

                                    <?php
                                    echo $server_not1;
                                    foreach ($resultados as $row) : ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['server']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-check form-switch">

                                <?php
                                $sql_consulta_2 = "SELECT
                                ne.notificacao_id as notificacao_id,
                                ne.active as active,
                                se.server as servidor,
                                se.id as servidorID
                                FROM
                                notificacao_email as ne
                                LEFT JOIN
                                servermail as se
                                ON
                                se.id = ne.server_id
                                WHERE
                                ne.notificacao_id = 2";
                                $stmt_consulta2 = $pdo->query($sql_consulta_2);
                                $resultado_c2 = $stmt_consulta2->fetch(PDO::FETCH_ASSOC);

                                // Verifica se está ativo e define o valor para a propriedade 'checked'
                                $checked2 = ($resultado_c2['active'] == "1") ? 'checked' : '';
                                if (empty($resultado_c2['servidor'])) {
                                    $server_not2 = "<option selected disabled>Selecione um servidor de e-mail</option>";
                                } else {
                                    $c2_serverID = $resultado_c2['servidorID'];
                                    $c2_servidor = $resultado_c2['servidor'];
                                    $server_not2 = "<option value='$c2_serverID' selected>$c2_servidor</option>";
                                }
                                ?>
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked2" <?= $checked2; ?>>
                                <label class="form-check-label" for="flexSwitchCheckChecked2">(2) Envio de e-mail para usuário quando encaminhado chamado.</label>
                                <select id="notificacao2_servidor" name="notificacao2_servidor" class="form-select form-select-sm" aria-label="Selecionar opção">
                                    <?php
                                    echo $server_not2;
                                    foreach ($resultados as $row) : ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['server']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-check form-switch">

                                <?php
                                $sql_consulta_3 = "SELECT
                                ne.notificacao_id as notificacao_id,
                                ne.active as active,
                                se.server as servidor,
                                se.id as servidorID
                                FROM
                                notificacao_email as ne
                                LEFT JOIN
                                servermail as se
                                ON
                                se.id = ne.server_id
                                WHERE
                                ne.notificacao_id = 3";
                                $stmt_consulta3 = $pdo->query($sql_consulta_3);
                                $resultado_c3 = $stmt_consulta3->fetch(PDO::FETCH_ASSOC);

                                // Verifica se está ativo e define o valor para a propriedade 'checked'
                                $checked3 = ($resultado_c3['active'] == "1") ? 'checked' : '';
                                if (empty($resultado_c3['servidor'])) {
                                    $server_not3 = "<option selected disabled>Selecione um servidor de e-mail</option>";
                                } else {
                                    $c3_serverID = $resultado_c3['servidorID'];
                                    $c3_servidor = $resultado_c3['servidor'];
                                    $server_not3 = "<option value='$c3_serverID' selected>$c3_servidor</option>";
                                }
                                ?>
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked3" <?= $checked3; ?>>
                                <label class="form-check-label" for="flexSwitchCheckChecked3">(3) Envio de e-mail administradores, solicitante e atendente do chamado quando houver um novo relato.</label>
                                <select id="notificacao3_servidor" name="notificacao3_servidor" class="form-select form-select-sm" aria-label="Selecionar opção">
                                    <?php
                                    echo $server_not3;
                                    foreach ($resultados as $row) : ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['server']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-check form-switch">

                                <?php
                                $sql_consulta_4 = "SELECT
                                ne.notificacao_id as notificacao_id,
                                ne.active as active,
                                se.server as servidor,
                                se.id as servidorID
                                FROM
                                notificacao_email as ne
                                LEFT JOIN
                                servermail as se
                                ON
                                se.id = ne.server_id
                                WHERE
                                ne.notificacao_id = 4";
                                $stmt_consulta4 = $pdo->query($sql_consulta_4);
                                $resultado_c4 = $stmt_consulta4->fetch(PDO::FETCH_ASSOC);

                                // Verifica se está ativo e define o valor para a propriedade 'checked'
                                $checked4 = ($resultado_c4['active'] == "1") ? 'checked' : '';
                                if (empty($resultado_c4['servidor'])) {
                                    $server_not4 = "<option selected disabled>Selecione um servidor de e-mail</option>";
                                } else {
                                    $c4_serverID = $resultado_c4['servidorID'];
                                    $c4_servidor = $resultado_c4['servidor'];
                                    $server_not4 = "<option value='$c4_serverID' selected>$c4_servidor</option>";
                                }
                                ?>
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked4" <?= $checked4; ?>>
                                <label class="form-check-label" for="flexSwitchCheckChecked4">(4) Envio de e-mail quando um chamado é apropriado.</label>
                                <select id="notificacao4_servidor" name="notificacao4_servidor" class="form-select form-select-sm" aria-label="Selecionar opção">
                                    <?php
                                    echo $server_not4;
                                    foreach ($resultados as $row) : ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['server']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="text-center">
                        <input id="btnConfigSend" name="btnConfigSend" type="button" value="Salvar Configurações" class="btn btn-danger"></input>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>