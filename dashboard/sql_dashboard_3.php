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
i.incident_type = 102";

$r_inc_backbone = mysqli_query($mysqli, $count_inc_backbone);
$c_inc_backbone = $r_inc_backbone->fetch_array();

$count_man_prog_af_gpon =
    "SELECT count(*) as qtde
FROM manutencao_programada as mp
LEFT JOIN manutencao_gpon as mg ON mg.manutencao_id = mp.id
LEFT JOIN gpon_pon as gp on gp.id = mg.pon_id
LEFT JOIN gpon_olts as go on go.id = gp.olt_id
LEFT JOIN gpon_olts_interessados as goi ON goi.gpon_olt_id = go.id
where mp.active = 1   and goi.interessado_empresa_id = $empresaID and goi.active = 1
GROUP BY mp.id
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
