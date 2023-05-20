<?php
require "../../includes/menu.php";

$id_usuario = $_SESSION['id'];
$sql_captura_id_pessoa =
    "SELECT
u.pessoa_id as pessoaID,
u.tipo_usuario as tipoUsuario
FROM
usuarios as u
WHERE
u.id = '$id_usuario'
";

$result_cap_pessoa = mysqli_query($mysqli, $sql_captura_id_pessoa);
$pessoaID = mysqli_fetch_assoc($result_cap_pessoa);

if ($pessoaID['tipoUsuario'] == 1) {
    require "user_type_smart.php";
} else if($pessoaID['tipoUsuario'] == 2) {
    require "user_type_cliente.php";
} else if($pessoaID['tipoUsuario'] == 3) {
    require "user_type_tenant.php";
}
?>