
<script>
    function dadosCredencial(idCredencial, tipoCredencial) {
        document.querySelector("#idCredencial").value = idCredencial;
    }
</script>


<?php
$credencialTipo = $_GET['tipo'];

if ($credencialTipo == "E-mail") {
    $credencialTipo = '1';
} else if ($credencialTipo == "Equipamento") {
    $credencialTipo = '2';
} else if ($credencialTipo == "Portal") {
    $credencialTipo = '3';
} else if ($credencialTipo == "VM") {
    $credencialTipo = '4'; 
}
?>


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
                                                        "SELECT
                                                            e.id as idEquipe,
                                                            e.equipe as nomeEquipe
                                                        FROM
                                                            equipe as e
                                                        WHERE
                                                            e.active = 1
                                                        ORDER BY
                                                            e.equipe ASC    
                                                        ";

                                                    $r_lista_equipes = mysqli_query($mysqli, $lista_equipes) or die("Erro ao retornar dados");

                                                    while ($equipe = $r_lista_equipes->fetch_array()) {
                                                        $idEquipe = $equipe['idEquipe'];
                                                        $nomeEquipe = $equipe['nomeEquipe'];
                                                        $idCredencial = $row['cred_id'];

                                                        $valida_permissao_equipe =
                                                            "SELECT
                                                        id as idPermissao
                                                        FROM
                                                        credenciais_privacidade_equipe as cepe
                                                        WHERE
                                                        cepe.credencial_id = $idCredencial
                                                        AND
                                                        cepe.equipe_id = $idEquipe
                                                        ";

                                                        $r_valida_permissao_equipe = mysqli_query($mysqli, $valida_permissao_equipe);

                                                        $validacao_equipe = $r_valida_permissao_equipe->fetch_array();

                                                        if (empty($validacao_equipe['idPermissao'])) { ?>
                                                            <div class="form-check form-switch">
                                                                <input onclick="addPermissaoEquipe(<?= $idEquipe ?>, '<?= $idCredencial ?>', '<?=$credencialTipo?>')" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
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
                                                    u.deleted = 1
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
                                                        credenciais_privacidade_usuario as cepu
                                                        WHERE
                                                        cepu.credencial_id = $idCredencial
                                                        AND
                                                        cepu.usuario_id = $idUsuario
                                                        ";

                                                        $r_valida_permissao_usuario = mysqli_query($mysqli, $valida_permissao_usuario);

                                                        $validacao_usuario = $r_valida_permissao_usuario->fetch_array();

                                                        if (empty($validacao_usuario['idPermissao'])) { ?>
                                                            <div class="form-check form-switch">
                                                                <input onclick="addPermissaoUsuario(<?= $idUsuario ?>, '<?= $idCredencial ?>', '<?=$credencialTipo?>')" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                                                <label class="form-check-label" for="flexSwitchCheckDefault"><?=$nomeUsuario?></label>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="form-check form-switch">
                                                                <input onclick="deletaPermissaoUsuario(<?= $validacao_usuario['idPermissao'] ?>)" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                                                                <label class="form-check-label" for="flexSwitchCheckChecked"><?=$nomeUsuario?></label>
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
