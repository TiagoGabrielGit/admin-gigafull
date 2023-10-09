<?php

$uid = $_SESSION['id'];

$dados_usuario =
    "SELECT
    u.empresa_id as empresaID,
    u.permissao_gerenciar_incidentes as permissaoGerenciar
    FROM
    usuarios as u
    LEFT JOIN
    redeneutra_parceiro as rnp
    ON
    rnp.empresa_id = u.empresa_id
    WHERE
    u.id =   $uid
";

$r_dados_usuario = mysqli_query($mysqli, $dados_usuario);
$c_dados_usuario = $r_dados_usuario->fetch_array();
$empresaID = $c_dados_usuario['empresaID'];

$count_inc_gpon =
    "SELECT
count(i.id) as qtde
FROM
incidentes as i
INNER JOIN gpon_olts o ON i.equipamento_id = o.equipamento_id
INNER JOIN gpon_olts_interessados oi ON o.id = oi.gpon_olt_id
WHERE
i.active = 1
and
oi.active = 1
and
oi.interessado_empresa_id = $empresaID
and
i.incident_type = 100";

$r_inc_gpon = mysqli_query($mysqli, $count_inc_gpon);
$c_inc_gpon = $r_inc_gpon->fetch_array();

$count_inc_backbone =
    "SELECT count(i.id) as qtde
FROM incidentes as i
LEFT JOIN rotas_fibra as rf ON i.equipamento_id = rf.codigo
LEFT JOIN rotas_fibras_interessados as rfi ON rf.id = rfi.rf_id
WHERE i.active = 1 and rfi.active = 1 and rfi.interessado_empresa_id = $empresaID and i.incident_type = 102";

$r_inc_backbone = mysqli_query($mysqli, $count_inc_backbone);
$c_inc_backbone = $r_inc_backbone->fetch_array();

$count_man_prog_af_gpon = 
    "SELECT COUNT(*) as qtde
    FROM (
        SELECT mp.id
        FROM manutencao_programada as mp
        LEFT JOIN manutencao_gpon as mg ON mg.manutencao_id = mp.id
        LEFT JOIN gpon_pon as gp on gp.id = mg.pon_id
        LEFT JOIN gpon_olts as go on go.id = gp.olt_id
        LEFT JOIN gpon_olts_interessados as goi ON goi.gpon_olt_id = go.id
        WHERE mp.active = 1 AND goi.interessado_empresa_id = $empresaID AND goi.active = 1
        GROUP BY mp.id
    ) AS subquery;
";
 
$r_man_prog_af_gpon = mysqli_query($mysqli, $count_man_prog_af_gpon);
$c_man_prog_af_gpon = $r_man_prog_af_gpon->fetch_array();

$count_man_prog_af_backbone =
"SELECT count(*) as qtde
FROM
manutencao_programada as mp
LEFT JOIN manutencao_rotas_fibra as mrf ON mrf.manutencao_id = mp.id
LEFT JOIN rotas_fibras_interessados as rfi ON rfi.rf_id = mrf.rota_id
where
mp.active = 1  and rfi.interessado_empresa_id = $empresaID  and rfi.active = 1 
GROUP BY mp.id";

$r_man_prog_af_backbone = mysqli_query($mysqli, $count_man_prog_af_backbone);
$c_man_prog_af_backbone = $r_man_prog_af_backbone->fetch_array();

$total_mp = (isset($c_man_prog_af_backbone['qtde']) && $c_man_prog_af_backbone['qtde'] > 0 ? $c_man_prog_af_backbone['qtde'] : 0) +
(isset($c_man_prog_af_gpon['qtde']) && $c_man_prog_af_gpon['qtde'] > 0 ? $c_man_prog_af_gpon['qtde'] : 0);


$incidentes_gpon_reincidentes =
"SELECT gpo.olt_name, gpl.cidade, gpl.bairro, gop.slot, gop.pon, ic.classificacao, COUNT(*) AS quantidade_incidentes
FROM incidentes AS i
LEFT JOIN gpon_pon AS gop ON gop.id = i.pon_id
LEFT JOIN gpon_olts AS gpo ON gpo.id = gop.olt_id
LEFT JOIN gpon_localidades AS gpl ON gpl.pon_id = i.pon_id
LEFT JOIN incidentes_classificacao AS ic ON ic.id = i.classificacao
LEFT JOIN gpon_olts_interessados as goi ON goi.gpon_olt_id = gpo.id
WHERE i.inicioIncidente >= DATE_SUB(NOW(), INTERVAL 60 DAY) 
AND i.pon_id IS NOT NULL 
AND gpl.active = 1
AND goi.interessado_empresa_id = $empresaID
GROUP BY gpo.olt_name, gpl.cidade, gpl.bairro, i.pon_id, i.classificacao
HAVING quantidade_incidentes > 1
ORDER BY quantidade_incidentes DESC";

$r_incidentes_gpon_reincidentes = mysqli_query($mysqli, $incidentes_gpon_reincidentes);

$count_inc_outros =
    "SELECT count(i.id) as qtde
FROM incidentes as i
WHERE i.active = 1 and i.incident_type NOT IN ('102', '100')";

$r_inc_outros = mysqli_query($mysqli, $count_inc_outros);
$c_inc_outros = $r_inc_outros->fetch_array();