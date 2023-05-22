<?php
require "../../includes/menu.php";

$usuarioID = $_SESSION['id'];
require "../../conexoes/conexao.php";
require "../../conexoes/conexao_pdo.php";

$dados_usuario =
    "SELECT
    u.empresa_id as empresaID,
    u.tipo_usuario as tipoUsuario,
    rnp.id as parceiroID
    FROM
    usuarios as u
    LEFT JOIN
    redeneutra_parceiro as rnp
    ON
    rnp.empresa_id = u.empresa_id
    WHERE
    u.id =   $usuarioID
";

$r_dados_usuario = mysqli_query($mysqli, $dados_usuario);
$c_dados_usuario = $r_dados_usuario->fetch_array();
$empresaID = $c_dados_usuario['empresaID'];
$parceiroID = $c_dados_usuario['parceiroID'];
$tipoUsuario = $c_dados_usuario['tipoUsuario'];

if ($tipoUsuario  == 1) {
    require "user_type_1.php";
} else if ($tipoUsuario  == 2) {
    require "user_type_2.php";
} else if ($tipoUsuario  == 3) {
    require "user_type_3.php";
}
