<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao.php";

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$tipo = filter_input(INPUT_GET, 'tipo');

require "sql_view.php";

if ($tipo == "E-mail") {
    $tabela = "sql_credenciais_email";
    $resultado = mysqli_query($mysqli, $$tabela);
    $row = mysqli_fetch_assoc($resultado);

    if ($row['cred_priv'] == 1) {
        $checkPublico = "checked";
    } else {
        $checkPublico = "";
    }

    if ($row['cred_priv'] == 2) {
        $checkEquipe = "checked";
        $aplicaButton = "<div class='col-4' style='text-align: left;'>
        <a onclick='dadosCredencial(" . $row['cred_id'] . ")' data-bs-toggle='modal' data-bs-target='#modalConfigPermissoes'><input type='button' class='btn btn-outline-dark btn-sm' value='Configurar permissões'></input></a>
    </div>";
    } else {
        $checkEquipe = "";
        $aplicaButton = "";
    }

    if ($row['cred_priv'] == 3) {
        $checkSomEu = "checked";
    } else {
        $checkSomEu = "";
    }
    require "includes/email.php";
}



require "../../../scripts/credenciais.php";
require "../../../includes/footer.php";
