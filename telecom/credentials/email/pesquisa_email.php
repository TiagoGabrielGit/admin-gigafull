<?php

$sql_pesquisa_email =
    ("SELECT
emp.fantasia as emp_fant,
email.id as cred_id,
CASE
    WHEN email.tipo = 'email' THEN 'E-mail'
END as cred_tipo,
email.emaildescricao as cred_desc,
email.emailusuario as cred_usuario,
email.privacidade as idPrivacidade,
email.usuario_id as usuarioCriador,
CASE
    WHEN email.privacidade = 1 THEN 'Público'
    WHEN email.privacidade = 2 THEN 'Privado'
    WHEN email.privacidade = 3 THEN 'Somente eu'
END as cred_priv
FROM
credenciais_email as email
LEFT JOIN
empresas as emp
ON
email.empresa_id = emp.id
WHERE
email.tipo LIKE '$varTipo'
and
email.empresa_id LIKE '$varEmpresa'
and
email.emaildescricao LIKE '%$varDescricao%'
");

$resultado_email = mysqli_query($mysqli, $sql_pesquisa_email) or die("Erro ao retornar dados");

while ($campos_email = $resultado_email->fetch_array()) {
    $id = $campos_email['cred_id'];
    $id_credencial = $campos_email['cred_id'];
    $idSessao = $_SESSION['id'];


    if ($campos_email['idPrivacidade'] == '1') { ?>
        <!--Apresenta se a privacidade for publico-->
        <tr>
            <td style="text-align: center;">
                <a style="color: red;" href="email/view.php?id=<?= $id ?>&tipo=E-mail"><?= $campos_email['cred_desc']; ?></a>
            </td>
            <td style="text-align: center;"><?= $campos_email['emp_fant'] ?></td>
            <td style="text-align: center;"><?= $campos_email['cred_usuario'] ?></td>
            <td style="text-align: center;"><?= $campos_email['cred_priv'] ?></td>
        </tr>
    <?php } else if ($campos_email['usuarioCriador'] == $idSessao) { ?>
        <!--Apresenta se o for do usuario criador-->
        <tr>
            <td style="text-align: center;">
                <a style="color: red;" href="email/view.php?id=<?= $id ?>&tipo=E-mail"><?= $campos_email['cred_desc']; ?></a>
            </td>
            <td style="text-align: center;"><?= $campos_email['emp_fant'] ?></td>
            <td style="text-align: center;"><?= $campos_email['cred_usuario'] ?></td>
            <td style="text-align: center;"><?= $campos_email['cred_priv'] ?></td>
        </tr>
    <?php } else if ($campos_email['idPrivacidade'] == '3' && $campos_email['usuarioCriador'] == $idSessao) {  ?>
        <!--Apresenta se a privacidade for somente eu e o usuario criador é o usuario logado-->
        <tr>
            </td>
            <td style="text-align: center;">
                <a style="color: red;" href="email/view.php?id=<?= $id ?>&tipo=E-mail"><?= $campos_email['cred_desc']; ?></a>
            </td>
            <td style="text-align: center;"><?= $campos_email['emp_fant'] ?></td>
            <td style="text-align: center;"><?= $campos_email['cred_usuario'] ?></td>
            <td style="text-align: center;"><?= $campos_email['cred_priv'] ?></td>
        </tr>
        <?php } else if ($campos_email['idPrivacidade'] == '2') {
        $sql_check_permissao_equipe =
            "SELECT
                *
            FROM
                credenciais_privacidade_equipe as cpe
            WHERE
                cpe.credencial_id = $id_credencial
            AND 
                cpe.equipe_id IN ((SELECT
                ei.equipe_id as idEquipe
            FROM
                equipes_integrantes as ei
            WHERE
                ei.integrante_id = $idSessao))";

        $resultado_check_permissao = mysqli_query($mysqli, $sql_check_permissao_equipe);
        $checkPermiEquipe = $resultado_check_permissao->fetch_array();

        $sql_check_perm_user =
            "SELECT
            *
        FROM
            credenciais_privacidade_usuario as cpu
        WHERE 
            cpu.credencial_id = $id_credencial
        AND 
            cpu.usuario_id = $idSessao";

        $r_check_perm_User = mysqli_query($mysqli, $sql_check_perm_user);
        $checkPermiUsuario = $r_check_perm_User->fetch_array();

        if (empty($checkPermiUsuario) && empty($checkPermiEquipe)) { //Apresenta se a privacidade for privada e der match em alguma equipe do usuario
        } else { ?>
            <tr>
                <td style="text-align: center;">
                    <a style="color: red;" href="email/view.php?id=<?= $id ?>&tipo=E-mail"><?= $campos_email['cred_desc']; ?></a>
                </td>
                <td style="text-align: center;"><?= $campos_email['emp_fant'] ?></td>
                <td style="text-align: center;"><?= $campos_email['cred_usuario'] ?></td>
                <td style="text-align: center;"><?= $campos_email['cred_priv'] ?></td>
            </tr>
<?php }
    }
}
?>