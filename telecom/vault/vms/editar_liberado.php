<?php

if ($row['cred_priv'] == 1) {
    $checkPublico = "checked";
} else {
    $checkPublico = "";
}

if ($row['cred_priv'] == 2) {
    $checkEquipe = "checked";
} else {
    $checkEquipe = "";
}

if ($row['cred_priv'] == 3) {
    $checkSomEu = "checked";
} else { 
    $checkSomEu = "";
} ?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['cred_hostname']; ?></h5>

                        <form action="processa/editar_credencial.php" method="POST" class="row g-3">

                            <input hidden name="id" type="text" class="form-control" id="id" value="<?= $row['cred_id']; ?>">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="editEmpresa" class="form-label">Empresa</label>
                                            <input disabled name="editEmpresa" type="text" class="form-control" id="editEmpresa" value="<?= $row['emp_fantasia'];  ?>">
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class=" col-6">
                                            <label for="editEquipamento" class="form-label">Equipamento</label>
                                            <input disabled name="editEquipamento" type="text" class="form-control" id="editEquipamento" value="<?= $row['cred_hostname']; ?>">
                                        </div>

                                        <div class="col-6" style="display: inline-block;">
                                            <label class="form-label">Endereço IP</label>
                                            <input disabled type="text" class="form-control" value="<?= $row['cred_ip']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">

                                    <div class="col-12">
                                        <label for="editPrivacidade" class="form-label">Privacidade</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="editPrivacidade" id="editPrivacidade" value="1" <?= $checkPublico ?>>
                                            <label class="form-check-label" for="editPrivacidade" value="1">Público</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="editPrivacidade" id="editPrivacidade" value="2" <?= $checkEquipe ?>>
                                            <label class="form-check-label" for="editPrivacidade" value="2">Privado</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="editPrivacidade" id="editPrivacidade" value="3" <?= $checkSomEu ?>>
                                            <label class="form-check-label" for="editPrivacidade" value="3">Somente criador</label>
                                        </div>


                                        <?php if ($_SESSION['permite_configurar_privacidade_credenciais'] == 1) { ?>
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <a data-bs-toggle="modal" data-bs-target="#modalPrivacidadeEquipe"><input type="button" class="btn btn-dark btn-sm" value="Privacidade Equipe"></input></a>
                                                    </div>
                                                    <div class="col-6">
                                                        <a data-bs-toggle="modal" data-bs-target="#modalPrivacidadeUsuario"><input type="button" class="btn btn-dark btn-sm" value="Privacidade Usuário"></input></a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <br>
                                    <div class="col-12">
                                        <label for="nomeUsuarioCriador" class="form-label">Usuário Criador</label>
                                        <input name="nomeUsuarioCriador" type="text" class="form-control" id="nomeUsuarioCriador" value="<?= $row['nomeCriador']; ?>" disabled>
                                    </div>
                                </div>


                            </div>

                            <hr class="sidebar-divider">

                            <div class="col-6" style="display: inline-block;">
                                <label for="editDescricao" class="form-label">Descrição</label>
                                <input name="editDescricao" type="text" class="form-control" id="editDescricao" value="<?= $row['vmdescricao']; ?>">
                            </div>

                            <div class="col-4" style="display: inline-block;"></div>

                            <div class="col-4" style="display: inline-block;">
                                <label for="editUsuario" class="form-label">Usuário</label>
                                <input name="editUsuario" type="text" class="form-control" id="editUsuario" value="<?= $row['vmusuario']; ?>">
                            </div>

                            <div class="col-4" style="display: inline-block;">
                                <label for="editSenha" class="form-label">Senha</label>
                                <input name="editSenha" type="text" class="form-control" id="editSenha" value="<?= $row['vmsenha']; ?>">
                            </div>

                            <hr class="sidebar-divider">

                            <div class="col-4"></div>

                            <div class="col-4" style="text-align: center;">
                                <button type="submit" class="btn btn-sm btn-danger">Salvar Alterações</button>
                                <a href="/telecom/vault/vms/view.php?id=<?= $row['vm_id']; ?>"><input type="button" class="btn btn-sm btn-secondary" value="Voltar"></input></a>
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
                                    <label for="id" class="form-label">Equipamento ID</label>
                                    <input type="Text" name="idEquipamento" class="form-control" id="idEquipamento" readonly value="<?= $id ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-body">
                                    <h5 class="card-title">Equipes Permitidas</h5>
                                    <div class="row mb-5">
                                        <div class="col-sm-10">
                                            <form>
                                                <?php
                                                $lista_equipes =
                                                    "SELECT e.id as idEquipe, e.equipe as nomeEquipe
                                                    FROM equipe as e
                                                    WHERE e.active = 1
                                                    ORDER BY e.equipe ASC";

                                                $r_lista_equipes = mysqli_query($mysqli, $lista_equipes) or die("Erro ao retornar dados");

                                                while ($equipe = $r_lista_equipes->fetch_array()) {
                                                    $idEquipe = $equipe['idEquipe'];
                                                    $nomeEquipe = $equipe['nomeEquipe'];
                                                    $idCredencial = $row['cred_id'];

                                                    $valida_permissao_equipe =
                                                        "SELECT id as idPermissao
                                                        FROM credenciais_vms_privacidade_equipe as cepe
                                                        WHERE cepe.credencial_id = $idCredencial AND cepe.equipe_id = $idEquipe";

                                                    $r_valida_permissao_equipe = mysqli_query($mysqli, $valida_permissao_equipe);

                                                    $validacao_equipe = $r_valida_permissao_equipe->fetch_array();

                                                    if (empty($validacao_equipe['idPermissao'])) { ?>
                                                        <div class="form-check form-switch">
                                                            <input onclick="addPermissaoEquipe(<?= $idEquipe ?>, '<?= $idCredencial ?>', '2')" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                                            <label class="form-check-label" for="flexSwitchCheckDefault"><?= $nomeEquipe ?></label>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="form-check form-switch">
                                                            <input onclick="deletaPermissaoEquipe(<?= $validacao_equipe['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                                            <label class="form-check-label" for="flexSwitchCheckChecked"><?= $nomeEquipe ?></label>
                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
                                    <label for="id" class="form-label">Equipamento ID</label>
                                    <input type="Text" name="idEquipamento" class="form-control" id="idEquipamento" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="card-body">
                                    <h5 class="card-title">Usuários Permitidos</h5>
                                    <div class="row mb-5">
                                        <div class="col-sm-10">
                                            <form>
                                                <?php

                                                $lista_usuarios =
                                                    "SELECT u.id as idUsuario, p.nome as nomeUsuario
                                                    FROM usuarios as u
                                                    LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                                                    WHERE u.active = 1
                                                    ORDER BY p.nome ASC";

                                                $r_lista_usuarios = mysqli_query($mysqli, $lista_usuarios) or die("Erro ao retornar dados");

                                                while ($usuario = $r_lista_usuarios->fetch_array()) {
                                                    $idUsuario = $usuario['idUsuario'];
                                                    $nomeUsuario = $usuario['nomeUsuario'];
                                                    $idCredencial = $row['cred_id'];

                                                    $valida_permissao_usuario =
                                                        "SELECT id as idPermissao
                                                        FROM credenciais_vms_privacidade_usuario as cepu
                                                        WHERE cepu.credencial_id = $idCredencial AND cepu.usuario_id = $idUsuario";

                                                    $r_valida_permissao_usuario = mysqli_query($mysqli, $valida_permissao_usuario);

                                                    $validacao_usuario = $r_valida_permissao_usuario->fetch_array();

                                                    if (empty($validacao_usuario['idPermissao'])) { ?>
                                                        <div class="form-check form-switch">
                                                            <input onclick="addPermissaoUsuario(<?= $idUsuario ?>, '<?= $idCredencial ?>', '2')" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                                            <label class="form-check-label" for="flexSwitchCheckDefault"><?= $nomeUsuario ?></label>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="form-check form-switch">
                                                            <input onclick="deletaPermissaoUsuario(<?= $validacao_usuario['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                                            <label class="form-check-label" for="flexSwitchCheckChecked"><?= $nomeUsuario ?></label>
                                                        </div>
                                                    <?php } ?>
                                                <?php
                                                } ?>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function addPermissaoEquipe(equipeId, credencialId) {
        $.ajax({
            url: 'processa/insert_permissao_equipe.php',
            type: 'POST',
            data: {
                credencialId: credencialId,
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

    function deletaPermissaoEquipe(idPermissaoEquipe) {
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

    function addPermissaoUsuario(usuarioId, credencialId) {
        $.ajax({
            url: 'processa/insert_permissao_usuario.php',
            type: 'POST',
            data: {
                credencialId: credencialId,
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

    function deletaPermissaoUsuario(idPermissaoUsuario) {
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