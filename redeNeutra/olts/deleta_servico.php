<?php
session_start();

include_once("../../conexoes/conexao.php");

$delete_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$url_retorno = $_SERVER['HTTP_REFERER'];
$delete_data = "DELETE FROM redeneutra_profile_service WHERE id=$delete_id";

$res_delete = mysqli_query($mysqli, $delete_data);

if (mysqli_affected_rows($mysqli)) {
    header("Location: $url_retorno");
} else {
    header("Location: $url_retorno");
}
