<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
require($_SERVER['DOCUMENT_ROOT'] . '/includes/remove_setas_number.php');

$menu_id = "37";
$uid = $_SESSION['id'];

$permissions_menu =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_menu pp ON  u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_menu = $menu_id";

$exec_permissions_menu = $pdo->prepare($permissions_menu);
$exec_permissions_menu->execute();

$rowCount_permissions_menu = $exec_permissions_menu->rowCount();

if ($rowCount_permissions_menu > 0) {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $sql_sql_vm =
        "SELECT
vm.id as idvm,
vm.hostname as hostname,
vm.ipaddress as ipaddress,
vm.dominio as dominio,
vm.statusVM as statusVM,
vm.anotacaoVM as anotacaoVM,
vm.recursoMemoria as recursoMemoria,
vm.recursoCPU as recursoCPU,
vm.recursoDisco1 as recursoDisco1,
vm.recursoDisco2 as recursoDisco2,
vm.vlan as vlan,
vm.privacidade as privacidade,
vm.usuario_criador as usuario_criador,
pop.id as id_pop,
pop.pop as nome_pop,
emp.id as id_empresa,
emp.fantasia as nome_empresa,
eqpop.id as id_servidor,
eqpop.hostname as nome_servidor,
so.id as id_so,
so.sistemaoperacional as nome_so,
p.nome as pessoa
FROM vms as vm
LEFT JOIN pop as pop ON pop.id = vm.pop_id
LEFT JOIN empresas as emp ON emp.id = vm.empresa_id
LEFT JOIN equipamentospop as eqpop ON eqpop.id = vm.servidor_id
LEFT JOIN sistemaoperacional as so ON so.id = vm.sistemaOperacional
LEFT JOIN usuarios as u ON u.id = vm.usuario_criador
LEFT JOIN pessoas as p ON p.id = u.pessoa_id
WHERE vm.id = '$id'";

    $resultado = mysqli_query($mysqli, $sql_sql_vm);
    $row = mysqli_fetch_assoc($resultado);

    $hostnameEquipamento = $row['hostname'];
    $privacidade = $row['privacidade'];
    $usuario_criador = $row['usuario_criador'];

    if ($privacidade == 1) {
        require "view_liberado.php";
    } else if ($usuario_criador == $_SESSION['id']) {
        require "view_liberado.php";
    } else if ($privacidade == 2) {

        // Verificar se o equipamento está liberado para o usuário ou para a equipe do usuário
        $userId = $_SESSION['id'];

        // Verificar se o equipamento está liberado para o usuário
        $sql_check_perm_user = "SELECT * FROM vm_privacidade_usuario WHERE vm_id = :id AND usuario_id = :userId";
        $stmt_check_perm_user = $pdo->prepare($sql_check_perm_user);
        $stmt_check_perm_user->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_check_perm_user->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt_check_perm_user->execute();

        // Verificar se o equipamento está liberado para alguma equipe do usuário
        $sql_check_perm_equipe = "SELECT * FROM vm_privacidade_equipe WHERE vm_id = :id AND equipe_id IN (SELECT equipe_id FROM equipes_integrantes WHERE integrante_id = :userId)";
        $stmt_check_perm_equipe = $pdo->prepare($sql_check_perm_equipe);
        $stmt_check_perm_equipe->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_check_perm_equipe->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt_check_perm_equipe->execute();

        if ($stmt_check_perm_user->rowCount() > 0 || $stmt_check_perm_equipe->rowCount() > 0) {
            require "view_liberado.php";
        } else {
            require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
        }
    } else {
        require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
    }
?>
    <script>
        function AddSenhaVM(id, nomevm, idEmpresa) {
            document.querySelector("#idVMModalSenha1").value = id;
            document.querySelector("#idVMModalSenha2").value = id;
            document.querySelector("#nomeVM").value = nomevm;
            document.querySelector("#idEmpresa1").value = idEmpresa;
        }
    </script>

    <div class="modal fade" id="AddSenhaVM" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card">
                        <div class="col-lg-12">
                            <div class="card-body">
                                <div class="row">
                                    <form id="cadastraSenhaVM" method="POST" class="row g-3 needs-validation">

                                        <span id="msg"></span>

                                        <div class="col-3">
                                            <label for="idVMModalSenha1" class="form-label">VM ID</label>
                                            <input type="Text" name="idVMModalSenha1" class="form-control" id="idVMModalSenha1" disabled>
                                        </div>

                                        <div class="col-6">
                                            <label for="nomeVM" class="form-label">VM</label>
                                            <input type="Text" name="nomeVM" class="form-control" id="nomeVM" disabled>
                                        </div>

                                        <input type="Text" name="idVMModalSenha2" class="form-control" id="idVMModalSenha2" hidden>
                                        <input type="Text" name="idEmpresa1" class="form-control" id="idEmpresa1" hidden>


                                        <div class="col-3">
                                            <label for="cadastroPrivacidade" class="form-label">Privacidade*</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="cadastroPrivacidade" id="cadastroPrivacidade" value="1" checked="">
                                                <label class="form-check-label" for="cadastroPrivacidade" value="1">Público</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="cadastroPrivacidade" id="cadastroPrivacidade" value="2">
                                                <label class="form-check-label" for="cadastroPrivacidade" value="2">Privado</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="cadastroPrivacidade" id="cadastroPrivacidade" value="3">
                                                <label class="form-check-label" for="cadastroPrivacidade" value="3">Somente eu</label>
                                            </div>

                                        </div>

                                        <div class="col-6" style="display: inline-block;">
                                            <label for="vmDescricao" class="form-label">Descrição</label>
                                            <input name="vmDescricao" type="text" class="form-control" id="vmDescricao">
                                        </div>

                                        <div class="col-4" style="display: inline-block;"> </div>

                                        <div class="col-4" style="display: inline-block;">
                                            <label for="vmUsuario" class="form-label">Usuário</label>
                                            <input name="vmUsuario" type="text" class="form-control" id="vmUsuario">
                                        </div>

                                        <div class="col-4" style="display: inline-block;">
                                            <label for="vmSenha" class="form-label">Senha</label>
                                            <input name="vmSenha" type="text" class="form-control" id="vmSenha">
                                        </div>

                                        <hr class="sidebar-divider">

                                        <div class="text-center">
                                            <input id="btnSalvar" name="btnSalvar" type="button" value="Salvar" class="btn btn-danger"></input>
                                            <a href="/telecom/vms/index.php"> <input type="button" value="Voltar" class="btn btn-secondary"></input></a>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>