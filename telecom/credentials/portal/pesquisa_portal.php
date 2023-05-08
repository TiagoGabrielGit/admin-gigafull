<?php

$sql_pesquisa_portal =
    ("SELECT
emp.fantasia as emp_fant,
portal.id as cred_id,
portal.privacidade as idPrivacidade, 
portal.usuario_id as usuarioCriador,
CASE
    WHEN portal.tipo = 'portal' THEN 'Portal'
END as cred_tipo,
portal.portaldescricao as cred_desc,
portal.portalusuario as cred_usuario,
CASE
    WHEN portal.privacidade = 1 THEN 'Público'
    WHEN portal.privacidade = 2 THEN 'Privado'
    WHEN portal.privacidade = 3 THEN 'Somente eu'
END as cred_priv
FROM
credenciais_portal as portal
LEFT JOIN
empresas as emp
ON
portal.empresa_id = emp.id
WHERE
portal.tipo LIKE '$varTipo'
and
portal.empresa_id LIKE '$varEmpresa'
and
portal.portaldescricao LIKE '%$varDescricao%'
");


$resultado_portal = mysqli_query($mysqli, $sql_pesquisa_portal) or die("Erro ao retornar dados");

while ($campos_portal = $resultado_portal->fetch_array()) {
    $id = $campos_portal['cred_id'];
    $id_credencial = $campos_portal['cred_id'];
    $idSessao = $_SESSION['id'];

    if ($campos_portal['idPrivacidade'] == '1') { ?>
        <!--Apresenta se a privacidade for publico-->
        <tr>
            <td style="text-align: center;">
                <a style="color: red;" href="portal/view.php?id=<?= $id ?>&tipo=Portal"><?= $campos_portal['cred_desc']; ?></a>
            </td>
            <td style="text-align: center;"><?= $campos_portal['emp_fant'] ?></td>
            <td style="text-align: center;"><?= $campos_portal['cred_usuario'] ?></td>
            <td style="text-align: center;"><?= $campos_portal['cred_priv'] ?></td>
        </tr>
    <?php } else if ($campos_portal['usuarioCriador'] == $idSessao) { ?>
        <!--Apresenta se o for do usuario criador-->
        <tr>
            <td style="text-align: center;">
                <a style="color: red;" href="portal/view.php?id=<?= $id ?>&tipo=Portal"><?= $campos_portal['cred_desc']; ?></a>
            </td>
            <td style="text-align: center;"><?= $campos_portal['emp_fant'] ?></td>
            <td style="text-align: center;"><?= $campos_portal['cred_usuario'] ?></td>
            <td style="text-align: center;"><?= $campos_portal['cred_priv'] ?></td>
        </tr>
    <?php } else if ($campos_portal['idPrivacidade'] == '3' && $campos_portal['usuarioCriador'] == $idSessao) {  ?>
        <!--Apresenta se a privacidade for somente eu e o usuario criador é o usuario logado-->
        <tr>
            <td style="text-align: center;">
                <a style="color: red;" href="portal/view.php?id=<?= $id ?>&tipo=Portal"><?= $campos_portal['cred_desc']; ?></a>
            </td>
            <td style="text-align: center;"><?= $campos_portal['emp_fant'] ?></td>
            <td style="text-align: center;"><?= $campos_portal['cred_usuario'] ?></td>
            <td style="text-align: center;"><?= $campos_portal['cred_priv'] ?></td>
        </tr>
        <?php } else if ($campos_portal['idPrivacidade'] == '2') {
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
                    <a style="color: red;" href="portal/view.php?id=<?= $id ?>&tipo=Portal"><?= $campos_portal['cred_desc']; ?></a>
                </td>
                <td style="text-align: center;"><?= $campos_portal['emp_fant'] ?></td>
                <td style="text-align: center;"><?= $campos_portal['cred_usuario'] ?></td>
                <td style="text-align: center;"><?= $campos_portal['cred_priv'] ?></td>
            </tr>
<?php }
    }
} ?>