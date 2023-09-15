<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "34";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT 
	u.perfil_id
FROM 
	usuarios u
JOIN 
	perfil_permissoes_submenu pp
ON 
	u.perfil_id = pp.perfil_id
WHERE
	u.id = $uid
AND 
	pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {
?>

<?php
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?> 