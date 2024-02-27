<?php 

$usuarioID = $_SESSION['id'];
$permite_interagir_chamados = $_SESSION['permite_interagir_chamados'];
$empresa_usuario = $_SESSION['empresa_id'];
$empresaID = $_SESSION['empresa_id'];

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
