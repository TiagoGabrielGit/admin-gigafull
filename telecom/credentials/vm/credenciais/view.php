<?php
require "../../../../includes/menu.php";
require "../../../../conexoes/conexao.php";
require "../../../../conexoes/conexao_pdo.php";

$menu_id = "16";
$uid = $_SESSION['id'];

$permissions_menu =
    "SELECT 
	u.perfil_id
FROM 
	usuarios u
JOIN 
	perfil_permissoes_menu pp
ON 
	u.perfil_id = pp.perfil_id
WHERE
	u.id = $uid
AND 
	pp.url_menu = $menu_id";

$exec_permissions_menu = $pdo->prepare($permissions_menu);
$exec_permissions_menu->execute();

$rowCount_permissions_menu = $exec_permissions_menu->rowCount();

if ($rowCount_permissions_menu > 0) {

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $sql_credenciais_vm =
        "SELECT
    credvm.id as cred_id,
    credvm.privacidade as cred_priv,
    credvm.tipo as cred_tipo,
    credvm.usuario_id as user_criador,
    credvm.vmdescricao as cred_descricao,
    credvm.vmusuario as cred_usuario,
    credvm.vmsenha as cred_senha,
    vm.hostname as vm_hostname,
    vm.id as vm_id,
    vm.ipaddress as cred_ip,
    emp.id as emp_id,
    emp.fantasia as emp_fantasia,
    p.nome as nomeCriador
    FROM credenciais_vms as credvm
    LEFT JOIN vms as vm ON credvm.vm_id = vm.id
    LEFT JOIN empresas as emp ON emp.id = credvm.empresa_id
    LEFT JOIN usuarios as u ON u.id = credvm.usuario_id
    LEFT JOIN pessoas as p ON u.pessoa_id = p.id
    WHERE credvm.id = '$id'";

    $resultado = mysqli_query($mysqli, $sql_credenciais_vm);
    $row = mysqli_fetch_assoc($resultado);
    $credencialTipo = $row['cred_tipo'];

    if ($row['cred_priv'] == 1) {
        require "view_liberado.php";
    } else if ($row['user_criador'] == $_SESSION['id']) {
        require "view_liberado.php";
    } else if ($row['cred_priv'] == 2) {
        $userId = $_SESSION['id'];

        // Verificar se o equipamento está liberado para o usuário
        $sql_check_perm_user = "SELECT * FROM credenciais_privacidade_usuario WHERE credencial_id = :id AND usuario_id = :userId";
        $stmt_check_perm_user = $pdo->prepare($sql_check_perm_user);
        $stmt_check_perm_user->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_check_perm_user->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt_check_perm_user->execute();

        // Verificar se o equipamento está liberado para alguma equipe do usuário
        $sql_check_perm_equipe = "SELECT * FROM credenciais_privacidade_equipe WHERE credencial_id = :id AND equipe_id IN (SELECT equipe_id FROM equipes_integrantes WHERE integrante_id = :userId)";
        $stmt_check_perm_equipe = $pdo->prepare($sql_check_perm_equipe);
        $stmt_check_perm_equipe->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_check_perm_equipe->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt_check_perm_equipe->execute();

        if ($stmt_check_perm_user->rowCount() > 0 || $stmt_check_perm_equipe->rowCount() > 0) {
            require "view_liberado.php";
        } else {
            require "../../../../acesso_negado.php";
        }
    } else {
        require "../../../../acesso_negado.php";
    }
} else {
    require "../../../../acesso_negado.php";
}
require "../../../../includes/securityfooter.php";
