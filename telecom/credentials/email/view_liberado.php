<?php

$sql_credenciais_email =
    "SELECT
        credemail.id as cred_id,
        credemail.privacidade as cred_priv,
        credemail.emaildescricao as cred_descricao,
        credemail.tipo as cred_tipo,
        credemail.emailusuario as cred_usuario,
        credemail.emailsenha as cred_senha,
        credemail.webmail as cred_webmail,
        credemail.anotacao as anotacaoEmail,
        emp.id as emp_id,
        emp.fantasia as emp_fantasia,
        p.nome as nomeCriador
        FROM
        credenciais_email as credemail
        LEFT JOIN
        empresas as emp
        ON
        emp.id = credemail.empresa_id
        LEFT JOIN
        usuarios as u
        ON
        u.id = credemail.usuario_id
        LEFT JOIN
        pessoas as p
        ON
        u.pessoa_id = p.id
        WHERE
        credemail.id = '$id'";

$resultado = mysqli_query($mysqli, $sql_credenciais_email);
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
