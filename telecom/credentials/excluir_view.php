<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "../../conexoes/conexao_pdo.php";

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
            if ($_SESSION['permissao_privacidade_credenciais'] == 1) {
                $aplicaButton = "<div class='col-4' style='text-align: left;'>
                <a onclick='dadosCredencial(" . $row['cred_id'] . ")' data-bs-toggle='modal' data-bs-target='#modalConfigPermissoes'>
                    <input type='button' class='btn btn-outline-dark btn-sm' value='Configurar permissões'>
                </a>
            </div>";
            } else {
                $aplicaButton = "";
            }
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

    if ($tipo == "Portal") {
        $tabela = "sql_credenciais_portal";
        $resultado = mysqli_query($mysqli, $$tabela);
        $row = mysqli_fetch_assoc($resultado);

        if ($row['cred_priv'] == 1) {
            $checkPublico = "checked";
        } else {
            $checkPublico = "";
        }

        if ($row['cred_priv'] == 2) {
            $checkEquipe = "checked";
            if ($_SESSION['permissao_privacidade_credenciais'] == 1) {
                $aplicaButton = "<div class='col-4' style='text-align: left;'>
                <a onclick='dadosCredencial(" . $row['cred_id'] . ")' data-bs-toggle='modal' data-bs-target='#modalConfigPermissoes'>
                    <input type='button' class='btn btn-outline-dark btn-sm' value='Configurar permissões'>
                </a>
            </div>";
            } else {
                $aplicaButton = "";
            }
        } else {
            $checkEquipe = "";
            $aplicaButton = "";
        }

        if ($row['cred_priv'] == 3) {
            $checkSomEu = "checked";
        } else {
            $checkSomEu = "";
        }

        require "includes/portal.php";
    }

    if ($tipo == "VM") {
        $tabela = "sql_credenciais_vm";
        $resultado = mysqli_query($mysqli, $$tabela);
        $row = mysqli_fetch_assoc($resultado);

        if ($row['cred_priv'] == 1) {
            $checkPublico = "checked";
        } else {
            $checkPublico = "";
        }

        if ($row['cred_priv'] == 2) {
            $checkEquipe = "checked";
            if ($_SESSION['permissao_privacidade_credenciais'] == 1) {
                $aplicaButton = "<div class='col-4' style='text-align: left;'>
            <a onclick='dadosCredencial(" . $row['cred_id'] . ")' data-bs-toggle='modal' data-bs-target='#modalConfigPermissoes'><input type='button' class='btn btn-outline-dark btn-sm' value='Configurar permissões'></input></a>
            </div>";
            } else {
                $aplicaButton = "";
            }
        } else {
            $checkEquipe = "";
            $aplicaButton = "";
        }




        if ($row['cred_priv'] == 3) {
            $checkSomEu = "checked";
        } else {
            $checkSomEu = "";
        }

        require "includes/vm.php";
    }


    require "js.php";
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
