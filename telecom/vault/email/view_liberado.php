<?php

$sql_credenciais_email =
    "SELECT
        credemail.id as cred_id,
        credemail.privacidade as cred_priv,
        credemail.emaildescricao as cred_descricao,
        credemail.tipo as cred_tipo,
        credemail.emailusuario as cred_usuario,
        credemail.emailsenha as cred_senha,
        credemail.webmail as cred_webmail,
        credemail.anotacao as anotacaoEmail,
        emp.id as emp_id,
        emp.fantasia as emp_fantasia,
        p.nome as nomeCriador
        FROM credenciais_email as credemail
        LEFT JOIN empresas as emp ON emp.id = credemail.empresa_id
        LEFT JOIN usuarios as u ON u.id = credemail.usuario_id
        LEFT JOIN pessoas as p ON u.pessoa_id = p.id
        WHERE credemail.id = '$id'";

$resultado = mysqli_query($mysqli, $sql_credenciais_email);
$row = mysqli_fetch_assoc($resultado);

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
                        <h5 class="card-title"><?= $row['cred_descricao']; ?></h5>

                        <form action="processa/editar.php" method="POST" class="row g-3">

                            <input hidden name="id" type="text" class="form-control" id="id" value="<?= $row['cred_id']; ?>">

                            <span id="msg"></span>

                            <div class="col-4">
                                <label for="editEmpresa" class="form-label">Empresa</label>
                                <input disabled name="editEmpresa" type="text" class="form-control" id="editEmpresa" value="<?= $row['emp_fantasia'];  ?>">
                            </div>

                            <div class="col-3">
                                <label for="editTipo" class="form-label">Tipo</label>
                                <input disabled name="editTipo" type="text" class="form-control" id="editTipo" value="<?= $row['cred_tipo'];  ?>">
                            </div>

                            <div class="col-2"></div>

                            <div class="col-3">
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
                                    <div class='col-4' style='text-align: left;'>
                                        <a onclick='dadosCredencial("<?php echo $row['cred_id']; ?>")' data-bs-toggle='modal' data-bs-target='#modalConfigPermissoes'>
                                            <input type='button' class='btn btn-outline-dark btn-sm' value='Configurar permissões'>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="col-9"> </div>

                            <div class="col-3">
                                <label for="nomeUsuarioCriador" class="form-label">Usuário Criador</label>
                                <input name="nomeUsuarioCriador" type="text" class="form-control" id="nomeUsuarioCriador" value="<?= $row['nomeCriador']; ?>" disabled>
                            </div>


                            <hr class="sidebar-divider">

                            <div class="col-6" style="display: inline-block;">
                                <label for="editDescricao" class="form-label">Descrição</label>
                                <input name="editDescricao" type="text" class="form-control" id="editDescricao" value="<?= $row['cred_descricao']; ?>">
                            </div>

                            <div class="col-4" style="display: inline-block;">
                                <label for="editWebmail" class="form-label">Webmail</label>
                                <input name="editWebmail" type="text" class="form-control" id="editWebmail" value="<?= $row['cred_webmail']; ?>">
                            </div>
                            <div class="col-2" style="display: inline-block;"> </div>

                            <div class="col-4" style="display: inline-block;">
                                <label for="editUsuario" class="form-label">Usuário</label>
                                <input name="editUsuario" type="text" class="form-control" id="editUsuario" value="<?= $row['cred_usuario']; ?>">
                            </div>

                            <div class="col-4" style="display: inline-block;">
                                <label for="editSenha" class="form-label">Senha</label>
                                <input name="editSenha" type="text" class="form-control" id="editSenha" value="<?= $row['cred_senha']; ?>">
                            </div>

                            <hr class="sidebar-divider">

                            <div class="col-12">
                                <label for="anotacaoEmail" class="form-label">Anotações</label>
                                <textarea id="anotacaoEmail" name="anotacaoEmail" class="form-control" maxlength="10000" rows="4"><?= $row['anotacaoEmail'] ?></textarea>
                            </div>

                            <hr class="sidebar-divider">

                            <div class="col-4"></div>

                            <div class="col-4" style="text-align: center;">
                                <button class="btn btn-sm btn-danger" type="submit">Salvar Alterações</button>
                                <a href="/telecom/vault/email/index.php"><input type="button" class="btn btn-sm btn-secondary" value="Voltar"></input></a>
                            </div>

                            <div class="col-4" style="text-align: right;">
                                <a onclick="return confirm('Tem certeza que deseja deletar este registro?')" href="processa/delete.php?id=<?= $id ?>&tipo=<?= $row['cred_tipo']; ?>"><input type="button" class="btn btn-warning" value="Excluir permanente"></input></a>

                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->

<script>
    function dadosCredencial(idCredencial, tipoCredencial) {
        document.querySelector("#idCredencial").value = idCredencial;
    }
</script>

<div class="modal fade" id="modalConfigPermissoes" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Configurar permissões</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <label for="id" class="form-label">Credencial ID</label>
                                    <input type="Text" name="idCredencial" class="form-control" id="idCredencial" disabled>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card-body">
                                        <h5 class="card-title">Equipes</h5>
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
                                                            FROM credenciais_email_privacidade_equipe as cepe
                                                            WHERE cepe.credencial_id = $idCredencial AND cepe.equipe_id = $idEquipe";

                                                        $r_valida_permissao_equipe = mysqli_query($mysqli, $valida_permissao_equipe);

                                                        $validacao_equipe = $r_valida_permissao_equipe->fetch_array();

                                                        if (empty($validacao_equipe['idPermissao'])) { ?>
                                                            <div class="form-check form-switch">
                                                                <input onclick="addPermissaoEquipe(<?= $idEquipe ?>, '<?= $idCredencial ?>', '1')" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
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


                                <div class="col-lg-6">
                                    <div class="card-body">
                                        <h5 class="card-title">Usuários</h5>
                                        <div class="row mb-5">
                                            <div class="col-sm-10">
                                                <form>
                                                    <?php

                                                    $lista_usuarios =
                                                        "SELECT
                                                    u.id as idUsuario,
                                                    p.nome as nomeUsuario
                                                    FROM
                                                    usuarios as u
                                                    LEFT JOIN
                                                    pessoas as p
                                                    ON
                                                    p.id = u.pessoa_id
                                                    WHERE
                                                    u.active = 1
                                                    ORDER BY
                                                    p.nome ASC
                                                    ";

                                                    $r_lista_usuarios = mysqli_query($mysqli, $lista_usuarios) or die("Erro ao retornar dados");

                                                    while ($usuario = $r_lista_usuarios->fetch_array()) {
                                                        $idUsuario = $usuario['idUsuario'];
                                                        $nomeUsuario = $usuario['nomeUsuario'];
                                                        $idCredencial = $row['cred_id'];

                                                        $valida_permissao_usuario =
                                                            "SELECT
                                                        id as idPermissao
                                                        FROM
                                                        credenciais_email_privacidade_usuario as cepu
                                                        WHERE
                                                        cepu.credencial_id = $idCredencial
                                                        AND
                                                        cepu.usuario_id = $idUsuario
                                                        ";

                                                        $r_valida_permissao_usuario = mysqli_query($mysqli, $valida_permissao_usuario);

                                                        $validacao_usuario = $r_valida_permissao_usuario->fetch_array();

                                                        if (empty($validacao_usuario['idPermissao'])) { ?>
                                                            <div class="form-check form-switch">
                                                                <input onclick="addPermissaoUsuario(<?= $idUsuario ?>, '<?= $idCredencial ?>', '<?= $credencialTipo ?>')" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
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
</div>

<script>
    function addPermissaoEquipe(idEquipe, idCredencial, tipoCredencial) {
        $.ajax({
            url: "/api/insert_permissao_credencial_equipe.php",
            method: "GET",
            dataType: "HTML",
            data: {
                idEquipe: idEquipe,
                idCredencial: idCredencial,
                tipoCredencial: tipoCredencial
            }
        })
    }

    function deletaPermissaoEquipe(idCadastroCredencialEquipe) {
        $.ajax({
            url: "/api/deleta_permissao_credencial_equipe.php",
            method: "GET",
            dataType: "HTML",
            data: {
                idCadastroCredencialEquipe: idCadastroCredencialEquipe
            }
        })
    }

    function addPermissaoUsuario(idUsuario, idCredencial, tipoCredencial) {
        $.ajax({
            url: "/api/insert_permissao_credencial_usuario.php",
            method: "GET",
            dataType: "HTML",
            data: {
                idUsuario: idUsuario,
                idCredencial: idCredencial,
                tipoCredencial: tipoCredencial
            }
        })
    }

    function deletaPermissaoUsuario(idCadastroCredencialUsuario) {
        $.ajax({
            url: "/api/deleta_permissao_credencial_usuario.php",
            method: "GET",
            dataType: "HTML",
            data: {
                idCadastroCredencialUsuario: idCadastroCredencialUsuario
            }
        })
    }
</script>