<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
require($_SERVER['DOCUMENT_ROOT'] . '/includes/remove_setas_number.php');

$menu_id = "35";
$uid = $_SESSION['id'];

$permissions_menu =
    "SELECT  u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_menu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_menu = $menu_id";

$exec_permissions_menu = $pdo->prepare($permissions_menu);
$exec_permissions_menu->execute();

$rowCount_permissions_menu = $exec_permissions_menu->rowCount();

if ($rowCount_permissions_menu > 0) {

    require "sql.php";

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $sql_sql_equipamentopop =
        "SELECT
eqpop.id as id_equipamentoPop,
eqpop.hostname as hostname,
eqpop.pop_id as id_pop,
eqpop.ipaddress as ipaddress,
eqpop.serialEquipamento as serialEquipamento,
eqpop.anotacaoEquipamento as anotacaoEquipamento,
eqpop.statusEquipamento as eqpopstatus,
eqpop.portaWeb as portaWeb,
eqpop.portaTelnet as portaTelnet,
eqpop.portaSSH as portaSSH,
eqpop.portaWinbox as portaWinbox,
eqpop.privacidade as privacidade,
eqpop.usuario_criador as usuario_criador,
emp.fantasia as nome_empresa,
emp.id as id_empresa,
pop.pop as nome_pop,
eqp.id as id_equipamento,
eqp.equipamento as nome_equipamento,
fab.id as id_fabricante,
fab.fabricante as nome_fabricante,
tipo.id as id_tipoEquipamento,
tipo.tipo as nome_tipoEquipamento
FROM equipamentospop as eqpop
LEFT JOIN empresas as emp ON emp.id = eqpop.empresa_id
LEFT JOIN pop as pop ON pop.id = eqpop.pop_id
LEFT JOIN equipamentos as eqp ON eqp.id = eqpop.equipamento_id
LEFT JOIN fabricante as fab ON fab.id = eqp.fabricante
LEFT JOIN tipoequipamento as tipo ON tipo.id = eqpop.tipoEquipamento_id
WHERE eqpop.id = '$id'
";

    $resultado = mysqli_query($mysqli, $sql_sql_equipamentopop);
    $row = mysqli_fetch_assoc($resultado);

    $id_pop = $row['id_pop'];
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
        $sql_check_perm_user = "SELECT * FROM equipamentos_pop_privacidade_usuario WHERE equipamento_id = :id AND usuario_id = :userId";
        $stmt_check_perm_user = $pdo->prepare($sql_check_perm_user);
        $stmt_check_perm_user->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_check_perm_user->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt_check_perm_user->execute();

        // Verificar se o equipamento está liberado para alguma equipe do usuário
        $sql_check_perm_equipe = "SELECT * FROM equipamentos_pop_privacidade_equipe WHERE equipamento_id = :id AND equipe_id IN (SELECT equipe_id FROM equipes_integrantes WHERE integrante_id = :userId)";
        $stmt_check_perm_equipe = $pdo->prepare($sql_check_perm_equipe);
        $stmt_check_perm_equipe->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_check_perm_equipe->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt_check_perm_equipe->execute();

        if ($stmt_check_perm_user->rowCount() > 0 || $stmt_check_perm_equipe->rowCount() > 0) {
            require "view_liberado.php";
        } else {
            require "../../../acesso_negado.php";
        }
    } else {
        require "../../../acesso_negado.php";
    }
?>
    
<?php
    require "../../../scripts/equipamentosPop.php";
} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php";
?>