<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao.php";
require "../../../conexoes/conexao_pdo.php";
require "../../../includes/remove_setas_number.php";
require "sql.php";
?>

<?php
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
so.sistemaoperacional as nome_so
FROM
vms as vm
LEFT JOIN
pop as pop
ON
pop.id = vm.pop_id
LEFT JOIN
empresas as emp
ON
emp.id = vm.empresa_id
LEFT JOIN
equipamentospop as eqpop
ON
eqpop.id = vm.servidor_id
LEFT JOIN
sistemaoperacional as so
ON
so.id = vm.sistemaOperacional
WHERE
vm.id = '$id'
";

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
    $sql_check_perm_user = "SELECT * FROM vm_pop_privacidade_usuario WHERE equipamento_id = :id AND usuario_id = :userId";
    $stmt_check_perm_user = $pdo->prepare($sql_check_perm_user);
    $stmt_check_perm_user->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_check_perm_user->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt_check_perm_user->execute();

    // Verificar se o equipamento está liberado para alguma equipe do usuário
    $sql_check_perm_equipe = "SELECT * FROM vm_pop_privacidade_equipe WHERE equipamento_id = :id AND equipe_id IN (SELECT equipe_id FROM equipes_integrantes WHERE integrante_id = :userId)";
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
require "modalSenhaVM.php";
require "../../../scripts/vms.php";
require "../../../includes/footer.php";
?>