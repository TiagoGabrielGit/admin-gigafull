<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');


$submenu_id = "68";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT u.perfil_id 
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $sql_credenciais_vm =
        "SELECT
        cv.id as cred_id,
        cv.privacidade as cred_priv,
        cv.empresa_id as emp_id,
        cv.tipo as cred_tipo,
        cv.usuario_id as user_criador,
        cv.vmdescricao as vmdescricao,
        cv.vmusuario as vmusuario,
        cv.vmsenha as vmsenha,
        cv.vm_id as vm_id,
        vm.hostname as cred_hostname,
        vm.ipaddress as cred_ip,
        e.fantasia as emp_fantasia,
        p.nome as nomeCriador
        FROM credenciais_vms as cv
        LEFT JOIN vms as vm ON vm.id = cv.vm_id
        LEFT JOIN empresas as e ON e.id = cv.empresa_id
        LEFT JOIN usuarios as u ON u.id = cv.usuario_id
        LEFT JOIN pessoas as p ON u.pessoa_id = p.id
        WHERE cv.id = '$id'";

    $resultado = mysqli_query($mysqli, $sql_credenciais_vm);
    $row = mysqli_fetch_assoc($resultado);
    $credencialTipo = $row['cred_tipo'];

    if ($row['cred_priv'] == 1) {
        require "editar_liberado.php";
    } else if ($row['user_criador'] == $_SESSION['id']) {
        require "editar_liberado.php";
    } else if ($row['cred_priv'] == 2) {
        $userId = $_SESSION['id'];

        // Verificar se o equipamento está liberado para o usuário
        $sql_check_perm_user = "SELECT * FROM credenciais_vms_privacidade_usuario WHERE credencial_id = :id AND usuario_id = :userId";
        $stmt_check_perm_user = $pdo->prepare($sql_check_perm_user);
        $stmt_check_perm_user->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_check_perm_user->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt_check_perm_user->execute();

        // Verificar se o equipamento está liberado para alguma equipe do usuário
        $sql_check_perm_equipe = "SELECT * FROM credenciais_vms_privacidade_equipe WHERE credencial_id = :id AND equipe_id IN (SELECT equipe_id FROM equipes_integrantes WHERE integrante_id = :userId)";
        $stmt_check_perm_equipe = $pdo->prepare($sql_check_perm_equipe);
        $stmt_check_perm_equipe->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_check_perm_equipe->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt_check_perm_equipe->execute();

        if ($stmt_check_perm_user->rowCount() > 0 || $stmt_check_perm_equipe->rowCount() > 0) {
            require "editar_liberado.php";
        } else {
            require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
        }
    } else {
        require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
    }
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
