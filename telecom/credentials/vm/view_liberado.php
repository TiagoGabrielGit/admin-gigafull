<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Código <?php echo $row['idvm']; ?> - <?php echo $row['hostname']; ?></h5>

                        <form method="POST" action="processa/edit.php" class="row g-3">

                            <input name="id" type="text" class="form-control" id="id" value="<?php echo $row['idvm']; ?>" hidden>

                            <div class="col-4">
                                <label for="editEmpresa" class="form-label">Empresa</label>
                                <select id="editEmpresa" name="editEmpresa" class="form-select" required>
                                    <option value="<?= $row['id_empresa']; ?>"><?= $row['nome_empresa']; ?></option>
                                    <?php
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

                            <div class="col-4" style="text-align: left;">
                                <a onclick="visualizarCredenciais(<?= $id ?>, '<?= $row['hostname']; ?>')" data-bs-toggle="modal" data-bs-target="#visualizaCredenciais"><input type="button" class="btn btn-info btn-sm" value="Visualizar credenciais"></input></a>
                                <?php if ($row['privacidade'] == 2) : ?>
                                    <a onclick="configurarPrivacidade(<?= $id ?>)" data-bs-toggle="modal" data-bs-target="#modalConfigurarPrivacidade"><input type="button" class="btn btn-dark btn-sm" value="Configurar Privacidade"></input></a>
                                <?php endif; ?>
                            </div>

                            <div class="col-4" style="text-align: center;">
                                <button name="salvar" type="submit" class="btn btn-danger btn-sm">Salvar</button>
                                <a href="/telecom/credentials/index.php"><input type="button" value="Voltar" class="btn btn-sm btn-secondary"></a>
                            </div>
                        </form><!-- Vertical Form -->

                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->

<script>
    function visualizarCredenciais(id, VM) {
        document.querySelector("#idVMModal").value = id;
        document.querySelector("#VMModal").value = VM;
    }
</script>

<div class=" modal fade" id="visualizaCredenciais" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Senhas cadastradas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <label for="idVMModal" class="form-label">ID</label>
                                    <input type="Text" name="idVMModal" class="form-control" id="idVMModal" disabled>
                                </div>

                                <div class="col-6">
                                    <label for="VMModal" class="form-label">VM</label>
                                    <input type="Text" name="VMModal" class="form-control" id="VMModal" disabled>
                                </div>

                                <div class="col-3" style="margin-top: 30px; text-align: right;">
                                    <a onclick="AddSenhaVM(<?= $row['idvm'] ?>, '<?= $row['hostname'] ?>', '<?= $row['id_empresa'] ?>')" data-bs-toggle="modal" data-bs-target="#AddSenhaVM">
                                        <button title="Adicionar novo" type="button" class="btn btn-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                            </svg>
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <hr class="sidebar-divider">

                            <div class="col-12">
                                <div class="accordion" id="accordionExample">
                                    <?php
                                    $sql_credenciais =
                                        "SELECT
                                        cv.id as id_credencial,
                                        cv.vmdescricao as descricao,
                                        cv.privacidade as idPrivacidade,
                                        cv.usuario_id as usuarioCriador,
                                        CASE
                                            WHEN cv.privacidade = 1 THEN 'Público' 
                                            WHEN cv.privacidade = 2 THEN 'Privado'
                                            WHEN cv.privacidade = 3 THEN 'Somente eu'
                                        END as privacidade,
                                        cv.vmusuario as vmuser,
                                        cv.vmsenha as vmsenha,
                                        vm.ipaddress as ip
                                        FROM
                                        credenciais_vms as cv
                                        LEFT JOIN
                                        vms as vm
                                        ON
                                        vm.id = cv.vm_id
                                        WHERE
                                        cv.active = 1
                                        and
                                        cv.vm_id = $id";

                                    $resultado_credenciais = mysqli_query($mysqli, $sql_credenciais)  or die("Erro ao retornar dados");
                                    $cont = 1;

                                    while ($campos = $resultado_credenciais->fetch_array()) {
                                        $id_credencial = $campos['id_credencial'];
                                        $idSessao = $_SESSION['id'];

                                        if ($campos['idPrivacidade'] == '1') {
                                            require "modalListaCredenciais.php";    //Apresenta se a privacidade for publico
                                        } else if ($campos['usuarioCriador'] == $idSessao) {
                                            require "modalListaCredenciais.php";    //Apresenta se o for do usuario criador
                                        } else if ($campos['idPrivacidade'] == '3' && $campos['usuarioCriador'] == $idSessao) {
                                            require "modalListaCredenciais.php";    //Apresenta se a privacidade for somente eu e o usuario criador é o usuario logado
                                        } else if ($campos['idPrivacidade'] == '2') {
                                            $sql_check_permissao_equipe =
                                                "SELECT
                                                    *
                                                FROM
                                                    credenciais_privacidade_equipe as cpe
                                                WHERE
                                                    cpe.credencial_id = $id_credencial
                                                AND 
                                                    cpe.equipe_id IN ((SELECT
                                                    ei.equipe_id as idEquipe
                                                FROM
                                                    equipes_integrantes as ei
                                                WHERE
                                                    ei.integrante_id = $idSessao))";

                                            $resultado_check_permissao = mysqli_query($mysqli, $sql_check_permissao_equipe);
                                            $checkPermiEquipe = $resultado_check_permissao->fetch_array();

                                            $sql_check_perm_user =
                                                "SELECT
                                                    *
                                                FROM
                                                    credenciais_privacidade_usuario as cpu
                                                WHERE
                                                    cpu.credencial_id = $id_credencial
                                                AND 
                                                    cpu.usuario_id = $idSessao";

                                            $r_check_perm_User = mysqli_query($mysqli, $sql_check_perm_user);
                                            $checkPermiUsuario = $r_check_perm_User->fetch_array();

                                            if (empty($checkPermiUsuario) && empty($checkPermiEquipe)) {
                                            } else {
                                                require "modalListaCredenciais.php"; //Apresenta se a privacidade for privada e der match em alguma equipe do usuario
                                            }
                                        }


                                        $cont++;
                                    } ?>
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
    function configurarPrivacidade(idVM) {
        document.querySelector("#idVM").value = idVM;
    }
</script>


<div class="modal fade" id="modalConfigurarPrivacidade" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Configurar Privacidade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <label for="id" class="form-label">VM ID</label>
                                    <input type="Text" name="idVM" class="form-control" id="idVM" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="card-title">Equipes Permitidas</h5>

                                <?php
                                try {
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    // Consulta para listar as equipes
                                    $sql_equipe = "
                                    SELECT 
                                        e.id as id,
                                        e.equipe as equipe
                                    FROM  
                                        equipe as e
                                    WHERE 
                                        e.active = 1
                                    ORDER BY
                                        e.equipe ASC";
                                    $stmt_equipe = $pdo->query($sql_equipe);

                                    if ($stmt_equipe->rowCount() > 0) {
                                        // Exibir os resultados
                                        while ($equipe = $stmt_equipe->fetch(PDO::FETCH_ASSOC)) {
                                            $idEquipe = $equipe['id'];


                                            $valida_permissao_equipe =
                                                "SELECT
                                                vpe.id as idPermissao
                                                FROM
                                                vm_privacidade_equipe as vpe
                                                WHERE
                                                vpe.vm_id = $id
                                                AND
                                                vpe.equipe_id = $idEquipe
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

                            <div class="col-lg-6">
                                <h5 class="card-title">Usuários Permitidos</h5>

                                <?php
                                try {
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    // Consulta para listar as equipes
                                    $sql_usuarios = "
                                    SELECT 
                                        u.id as id,
                                        p.nome as nome
                                    FROM 
                                        usuarios as u
                                        LEFT JOIN
                                        pessoas as p
                                    ON
                                        p.id = u.pessoa_id 
                                    WHERE 
                                        u.active = 1
                                        and
                                        u.tipo_usuario = 1     
                                    ORDER BY
                                        p.nome ASC";
                                    $stmt_usuarios = $pdo->query($sql_usuarios);

                                    if ($stmt_usuarios->rowCount() > 0) {
                                        // Exibir os resultados
                                        while ($usuario = $stmt_usuarios->fetch(PDO::FETCH_ASSOC)) {

                                            $idUsuario = $usuario['id'];

                                            $valida_permissao_usuario =
                                                "SELECT
                                                    vpu.id as idPermissao
                                                    FROM
                                                    vm_privacidade_usuario as vpu
                                                    WHERE
                                                    vpu.vm_id = $id
                                                    AND
                                                    vpu.usuario_id = $idUsuario
                                                    ";

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
                                            <?php } ?>




                                <?php
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
    function addPermissaoVMEquipe(idEquipe, idVM) {
        $.ajax({
            url: "processa/insert_permissao_vm_equipe.php",
            method: "GET",
            dataType: "HTML",
            data: {
                idEquipe: idEquipe,
                idVM: idVM
            }
        })
    }

    function deletaPermissaoVMEquipe(idPermissaoEquipe) {
        $.ajax({
            url: "processa/deleta_permissao_vm_equipe.php",
            method: "GET",
            dataType: "HTML",
            data: {
                idPermissaoEquipe: idPermissaoEquipe
            }
        })
    }

    function addPermissaoVMUsuario(idUsuario, idVM) {
        $.ajax({
            url: "processa/insert_permissao_vm_usuario.php",
            method: "GET",
            dataType: "HTML",
            data: {
                idUsuario: idUsuario,
                idVM: idVM
            }
        })
    }

    function deletaPermissaoVMUsuario(idPermissaoUsuario) {
        $.ajax({
            url: "processa/deleta_permissao_vm_usuario.php",
            method: "GET",
            dataType: "HTML",
            data: {
                idPermissaoUsuario: idPermissaoUsuario
            }
        })
    }
</script>