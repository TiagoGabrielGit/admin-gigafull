<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Código <?php echo $row['idvm']; ?> - <?php echo $row['hostname']; ?></h5>

                        <form method="POST" action="processa/editar.php" class="row g-3">

                            <input name="id" type="text" class="form-control" id="id" value="<?php echo $row['idvm']; ?>" hidden>

                            <div class="col-4">
                                <label for="editEmpresa" class="form-label">Empresa</label>
                                <select id="editEmpresa" name="editEmpresa" class="form-select" required>
                                    <option value="<?= $row['id_empresa']; ?>"><?= $row['nome_empresa']; ?></option>
                                    <?php
                                    $sql_lista_empresas =
                                        "SELECT emp.id as id, emp.fantasia as empresa
                                        FROM empresas as emp
                                        WHERE emp.deleted = 1
                                        ORDER BY emp.fantasia ASC";

                                    $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                    while ($emp = $resultado->fetch_assoc()) : ?>
                                        <option value="<?= $emp['id']; ?>"><?= $emp['empresa']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="col-2">
                                <label for="editPOP" class="form-label">POP</label>
                                <select id="editPOP" name="editPOP" class="form-select" required>
                                    <option value="<?= $row['id_pop']; ?>"><?= $row['nome_pop']; ?></option>
                                </select>
                            </div>

                            <div class="col-3">
                                <label for="editServidor" class="form-label">Servidor virtualizador</label>
                                <select value id="editServidor" name="editServidor" class="form-select" required>
                                    <option value="<?= $row['id_servidor']; ?>"><?= $row['nome_servidor']; ?></option>
                                </select>
                            </div>

                            <div class="col-3">
                                <label for="privacidadeVM" class="form-label">Privacidade</label>
                                <select name="privacidadeVM" id="privacidadeVM" class="form-select" required>
                                    <option <?php if ($row['privacidade'] == null) echo "selected"; ?> disabled value="">Selecione</option>
                                    <option value="1" <?php if ($row['privacidade'] == 1) echo "selected"; ?>>Público</option>
                                    <option value="2" <?php if ($row['privacidade'] == 2) echo "selected"; ?>>Privado</option>
                                </select>
                            </div>

                            <hr class="sidebar-divider">

                            <div class="col-4">
                                <label for="editHostname" class="form-label">Hostname</label>
                                <input name="editHostname" type="text" class="form-control" id="editHostname" value="<?php echo $row['hostname'] ?>" required>
                            </div>


                            <div class="col-4">
                                <label for="editSO" class="form-label">Sistema operacional</label>
                                <select id="editSO" name="editSO" class="form-select" required>
                                    <option value="<?= $row['id_so']; ?>"><?= $row['nome_so']; ?></option>
                                    <?php
                                    $sql_lista_so =
                                        "SELECT so.id as id, so.sistemaOperacional as so
                                        From sistemaoperacional as so
                                        Where so.deleted = 1
                                        ORDER BY so.sistemaOperacional ASC";

                                    $resultado = mysqli_query($mysqli, $sql_lista_so);
                                    while ($so = mysqli_fetch_object($resultado)) :
                                        echo "<option value='$so->id'> $so->so</option>";
                                    endwhile;
                                    ?>
                                </select>
                            </div>

                            <div class="col-4"></div>

                            <div class="col-3">
                                <label for="editIPAddress" class="form-label">Endereço IP</label>
                                <input id="editIPAddress" name="editIPAddress" type="text" class="form-control" value="<?= $row['ipaddress']; ?>" maxlength="15" required>
                            </div>

                            <div class="col-3">
                                <label for="editDominio" class="form-label">Dominio</label>
                                <input id="editDominio" name="editDominio" type="text" class="form-control" value="<?= $row['dominio']; ?>">
                            </div>

                            <div class="col-2">
                                <label for="editVLAN" class="form-label">VLAN</label>
                                <input id="editVLAN" name="editVLAN" type="number" maxlength="4" class="form-control" value="<?= $row['vlan']; ?>">
                            </div>

                            <div class="col-3">
                                <label for="editStatusVM" class="form-label">Status</label>
                                <select id="editStatusVM" name="editStatusVM" class="form-select" required>
                                    <option value="<?= $row['statusVM']; ?>"><?= $row['statusVM']; ?></option>
                                    <option value="Ativado">Ativado</option>
                                    <option value="Em Implementação">Em Implementação</option>
                                    <option value="Inativado">Inativado</option>
                                </select>
                            </div>

                            <div class="col-3">
                                <label for="editMemoria" class="form-label">Memória (Mb)*</label>
                                <input name="editMemoria" type="number" class="form-control" id="editMemoria" value="<?php echo $row['recursoMemoria']; ?>" required>
                            </div>

                            <div class="col-2">
                                <label for="editVCPU" class="form-label">vCPU*</label>
                                <input name="editVCPU" type="number" class="form-control" id="editVCPU" value="<?php echo $row['recursoCPU']; ?>" required>
                            </div>

                            <div class="col-3">
                                <label for="editDisco1" class="form-label">Disco partição 1 (Gb)*</label>
                                <input name="editDisco1" type="number" class="form-control" id="editDisco1" value="<?php echo $row['recursoDisco1']; ?>" required>
                            </div>

                            <div class="col-3">
                                <label for="editDisco2" class="form-label">Disco partição 2 (Gb)</label>
                                <input name="editDisco2" type="number" class="form-control" id="editDisco2" value="<?php echo $row['recursoDisco2']; ?>">
                            </div>

                            <div class="col-12">
                                <label for="anotacaoVM" class="form-label">Anotações</label>
                                <textarea id="anotacaoVM" name="anotacaoVM" maxlength="10000" class="form-control" rows="4"><?php echo $row['anotacaoVM'] ?></textarea>
                            </div>

                            <div class="col-lg-12">

                                <div class="row">
                                    <div class="col-lg-4">
                                        <a href="/telecom/vault/vms/view.php?id=<?= $row['idvm']  ?>">
                                            <button type="button" class="btn btn-info btn-sm">Visualizar credenciais</button>
                                        </a>
                                    </div>

                                    <div class="col-lg-4">
                                        <button name="salvar" type="submit" class="btn btn-danger btn-sm">Salvar</button>
                                        <a href="/telecom/vmslocal/index.php"><input type="button" value="Voltar" class="btn btn-sm btn-secondary"></a>
                                    </div>

                                    <div class="col-lg-4">
                                        <?php
                                        if ($_SESSION['permite_configurar_privacidade_equipamentos'] == 1) { ?>
                                            <a data-bs-toggle="modal" data-bs-target="#modalPrivacidadeEquipe"><input type="button" class="btn btn-dark btn-sm" value="Privacidade Equipe"></input></a>
                                            <a data-bs-toggle="modal" data-bs-target="#modalPrivacidadeUsuario"><input type="button" class="btn btn-dark btn-sm" value="Privacidade Usuário"></input></a>
                                        <?php }
                                        ?>
                                        <br>
                                        <label class="form-label"> Usuário Criador</label>
                                        <input readonly disabled class="form-control" value="<?= $row['pessoa']  ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<div class="modal fade" id="modalPrivacidadeEquipe" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Configurar Privacidade Equipe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <label for="id" class="form-label">VM ID</label>
                                    <input type="Text" name="idEquipamento" class="form-control" id="idEquipamento" readonly value="<?= $id ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="card-title">Equipes Permitidas</h5>

                                <?php
                                try {
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    $sql_equipe =
                                        "SELECT e.id as id, e.equipe as equipe
                                    FROM equipe as e
                                    WHERE e.active = 1
                                    ORDER BY e.equipe ASC";
                                    $stmt_equipe = $pdo->query($sql_equipe);

                                    if ($stmt_equipe->rowCount() > 0) {
                                        // Exibir os resultados
                                        while ($equipe = $stmt_equipe->fetch(PDO::FETCH_ASSOC)) {
                                            $idEquipe = $equipe['id'];

                                            $valida_permissao_equipe =
                                                "SELECT eppe.id as idPermissao
                                                FROM vm_privacidade_equipe as eppe
                                                WHERE eppe.vm_id = $id AND eppe.equipe_id = $idEquipe
                                                ";

                                            $r_valida_permissao_equipe = mysqli_query($mysqli, $valida_permissao_equipe);
                                            $validacao_equipe = $r_valida_permissao_equipe->fetch_array();

                                            if (empty($validacao_equipe['idPermissao'])) { ?>
                                                <div class="form-check form-switch">
                                                    <input onclick="addPermissaoVMEquipe(<?= $equipe['id'] ?>, '<?= $id ?>')" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                                    <label class="form-check-label" for="flexSwitchCheckDefault"><?= $equipe['equipe'] ?></label>
                                                </div>
                                            <?php } else { ?>
                                                <div class="form-check form-switch">
                                                    <input onclick="deletaPermissaoVMEquipe(<?= $validacao_equipe['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked"><?= $equipe['equipe'] ?></label>
                                                </div>
                                <?php }
                                        }
                                    } else {
                                        echo "Nenhuma equipe encontrada.";
                                    }
                                } catch (PDOException $e) {
                                    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPrivacidadeUsuario" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Configurar Privacidade Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <label for="id" class="form-label">VM ID</label>
                                    <input type="Text" name="idEquipamento" class="form-control" id="idEquipamento" readonly value="<?= $id ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-12">
                                <h5 class="card-title">Usuários Permitidos</h5>

                                <?php
                                try {
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    $sql_usuarios =
                                        "SELECT u.id as id, p.nome as nome
                                    FROM usuarios as u
                                    LEFT JOIN pessoas as p ON p.id = u.pessoa_id 
                                    WHERE u.active = 1 and u.tipo_usuario = 1     
                                    ORDER BY p.nome ASC";
                                    $stmt_usuarios = $pdo->query($sql_usuarios);

                                    if ($stmt_usuarios->rowCount() > 0) {
                                        while ($usuario = $stmt_usuarios->fetch(PDO::FETCH_ASSOC)) {
                                            $idUsuario = $usuario['id'];
                                            $valida_permissao_usuario =
                                                "SELECT eppu.id as idPermissao
                                                FROM vm_privacidade_usuario as eppu
                                                WHERE eppu.vm_id = $id AND eppu.usuario_id = $idUsuario";

                                            $r_valida_permissao_usuario = mysqli_query($mysqli, $valida_permissao_usuario);

                                            $validacao_usuario = $r_valida_permissao_usuario->fetch_array();

                                            if (empty($validacao_usuario['idPermissao'])) { ?>
                                                <div class="form-check form-switch">
                                                    <input onclick="addPermissaoVMUsuario(<?= $usuario['id'] ?>, '<?= $id ?>')" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                                    <label class="form-check-label" for="flexSwitchCheckDefault"><?= $usuario['nome'] ?></label>
                                                </div>
                                            <?php } else { ?>
                                                <div class="form-check form-switch">
                                                    <input onclick="deletaPermissaoVMUsuario(<?= $validacao_usuario['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked"><?= $usuario['nome'] ?></label>
                                                </div>
                                <?php }
                                        }
                                    } else {
                                        echo "Nenhuma usuario encontrada.";
                                    }
                                } catch (PDOException $e) {
                                    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function addPermissaoVMEquipe(equipeId, vmId) {
        $.ajax({
            url: 'processa/insert_permissao_equipe.php',
            type: 'POST',
            data: {
                vmId: vmId,
                idEquipe: equipeId
            },
            success: function(response) {
                console.log("Permissão adicionada com sucesso.");
            },
            error: function(xhr, status, error) {
                console.error("Erro ao adicionar permissão: ", error);
            }
        });
    }

    function deletaPermissaoVMEquipe(idPermissaoEquipe) {
        $.ajax({
            url: 'processa/remove_permissao_equipe.php',
            type: 'POST',
            data: {
                idPermissaoEquipe: idPermissaoEquipe,
            },
            success: function(response) {
                console.log("Permissão removida com sucesso.");
            },
            error: function(xhr, status, error) {
                console.error("Erro ao remover permissão: ", error);
            }
        });
    }

    function addPermissaoVMUsuario(usuarioId, vmId) {
        $.ajax({
            url: 'processa/insert_permissao_usuario.php',
            type: 'POST',
            data: {
                vmId: vmId,
                idUsuario: usuarioId
            },
            success: function(response) {
                console.log("Permissão adicionada com sucesso.");
            },
            error: function(xhr, status, error) {
                console.error("Erro ao adicionar permissão: ", error);
            }
        });
    }

    function deletaPermissaoVMUsuario(idPermissaoUsuario) {
        $.ajax({
            url: 'processa/remove_permissao_usuario.php',
            type: 'POST',
            data: {
                idPermissaoUsuario: idPermissaoUsuario,
            },
            success: function(response) {
                console.log("Permissão removida com sucesso.");
            },
            error: function(xhr, status, error) {
                console.error("Erro ao remover permissão: ", error);
            }
        });
    }
</script>