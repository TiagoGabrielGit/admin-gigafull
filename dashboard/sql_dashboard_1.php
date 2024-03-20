<?php

$usuarioID = $_SESSION['id'];
$permite_interagir_chamados = $_SESSION['permite_interagir_chamados'];
$empresa_usuario = $_SESSION['empresa_id'];
$empresaID = $_SESSION['empresa_id'];

if ($permite_interagir_chamados == 1) {
    //Conta os chamados da empresa do usuario
    $sql_count_chamados_abertos =
        "SELECT count(*) as quantidade
        FROM chamados as c
        WHERE c.empresa_id = $empresa_usuario
        and c.status_id <> 3";
} else if ($permite_interagir_chamados == 2) {
    //Conta os chamados da equipe do usuario
    $sql_count_chamados_abertos =
        "SELECT count(*) as quantidade
        FROM chamados as ch
        LEFT JOIN empresas as emp ON ch.empresa_id = emp.id
        LEFT JOIN tipos_chamados as tc ON ch.tipochamado_id = tc.id
        LEFT JOIN chamados_status as cs ON cs.id = ch.status_id
        LEFT JOIN pessoas as p ON p.id = ch.atendente_id
        WHERE tc.id IN (SELECT DISTINCT caa.tipo_id
                        FROM equipes_integrantes ei
                        JOIN chamados_autorizados_abertura caa ON ei.equipe_id = caa.equipe_id
                        WHERE ei.integrante_id = $usuarioID)
                        and ch.status_id <> 3";
} else if ($permite_interagir_chamados == 3) {
    //Conta todos os chamados
    $sql_count_chamados_abertos =
        "SELECT count(*) as quantidade
        FROM chamados as c
        WHERE c.status_id <> 3";
}

if ($permite_interagir_chamados == 1) {
    $sql_count_chamados_sematendente =
        "SELECT count(*) as quantidade
        FROM chamados as c
        WHERE c.empresa_id = $empresa_usuario and c.atendente_id = 0 and c.status_id <> 3";
} else if ($permite_interagir_chamados == 2) {
    $sql_count_chamados_sematendente =
        "SELECT count(*) as quantidade
    FROM chamados as ch
    LEFT JOIN empresas as emp ON ch.empresa_id = emp.id
    LEFT JOIN tipos_chamados as tc ON ch.tipochamado_id = tc.id
    LEFT JOIN chamados_status as cs ON cs.id = ch.status_id
    LEFT JOIN pessoas as p ON p.id = ch.atendente_id
    WHERE tc.id IN (SELECT DISTINCT cae.tipo_id
                    FROM equipes_integrantes ei
                    JOIN chamados_autorizados_abertura cae ON ei.equipe_id = cae.equipe_id
                    WHERE ei.integrante_id = $usuarioID) and ch.atendente_id = 0 and ch.status_id <> 3
                    ORDER BY ch.data_abertura DESC";
} else if ($permite_interagir_chamados == 3) {
    $sql_count_chamados_sematendente =
        "SELECT count(*) as quantidade
    FROM chamados as c
    WHERE c.atendente_id = 0 and c.status_id <> 3";
}

//CHAMADOS MEUS CHAMADOS
$sql_count_chamados_meus =
    "SELECT count(*) as quantidade
    FROM chamados as c
    WHERE c.atendente_id = $usuarioID and c.status_id <> 3";

if ($permite_interagir_chamados == 1) {
    $sql_ultimos_30_chamados =
        "SELECT
        c.id as idChamado,
        e.fantasia as fantasia,
        tc.tipo as tipoChamado,
        c.assuntoChamado as assuntoChamado,
        c.status_id as statusChamado,
        cs.status_chamado as status_chamado,
        cs.color as statusColor
        FROM chamados as c
        LEFT JOIN empresas as e ON e.id = c.empresa_id
        LEFT JOIN tipos_chamados as tc ON c.tipochamado_id = tc.id
        LEFT JOIN chamados_status as cs ON cs.id = c.status_id
        WHERE e.id = 1
        ORDER BY c.id DESC
        LIMIT 15";
} else if ($permite_interagir_chamados == 2) {
    $sql_ultimos_30_chamados =    "SELECT
        ch.id as idChamado,
        emp.fantasia as fantasia,
        tc.tipo as tipoChamado,
        ch.assuntoChamado as assuntoChamado,
        ch.status_id as statusChamado,
        cs.status_chamado as status_chamado,
        cs.color as statusColor
                                FROM chamados as ch
                                LEFT JOIN empresas as emp ON ch.empresa_id = emp.id
                                LEFT JOIN tipos_chamados as tc ON ch.tipochamado_id = tc.id
                                LEFT JOIN chamados_status as cs ON cs.id = ch.status_id
                                LEFT JOIN pessoas as p ON p.id = ch.atendente_id

                                WHERE tc.id IN (
                                    SELECT DISTINCT cae.tipo_id
                                    FROM equipes_integrantes ei
                                    JOIN chamados_autorizados_abertura cae ON ei.equipe_id = cae.equipe_id
                                    WHERE ei.integrante_id = $usuarioID)
                                ORDER BY ch.data_abertura DESC
                                LIMIT 15";
} else if ($permite_interagir_chamados == 3) {
    //ÚLTIMOD 30 CHAMADOS
    $sql_ultimos_30_chamados =
        "SELECT
        c.id as idChamado,
        e.fantasia as fantasia,
        tc.tipo as tipoChamado,
        c.assuntoChamado as assuntoChamado,
        c.status_id as statusChamado,
        cs.status_chamado as status_chamado,
        cs.color as statusColor
        FROM chamados as c
        LEFT JOIN empresas as e ON e.id = c.empresa_id
        LEFT JOIN tipos_chamados as tc ON c.tipochamado_id = tc.id
        LEFT JOIN chamados_status as cs ON cs.id = c.status_id

        ORDER BY c.id DESC
        LIMIT 15";
}

$count_inc_gpon =
    "SELECT count(i.id) as qtde
FROM incidentes as i
INNER JOIN gpon_olts o ON i.equipamento_id = o.equipamento_id
INNER JOIN gpon_olts_interessados oi ON o.id = oi.gpon_olt_id
WHERE i.active = 1 and oi.active = 1 and oi.interessado_empresa_id = $empresaID and i.incident_type = 100";

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


$count_man_prog_af_backbone =
    "SELECT count(*) as qtde
FROM
manutencao_programada as mp
LEFT JOIN manutencao_rotas_fibra as mrf ON mrf.manutencao_id = mp.id
LEFT JOIN rotas_fibras_interessados as rfi ON rfi.rf_id = mrf.rota_id
where
mp.active = 1  and rfi.interessado_empresa_id = $empresaID  and rfi.active = 1 
GROUP BY mp.id";

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
HAVING quantidade_incidentes > 2
ORDER BY quantidade_incidentes DESC
LIMIT 35";


$count_inc_outros =
    "SELECT count(i.id) as qtde
FROM incidentes as i
WHERE i.active = 1 and i.incident_type NOT IN ('102', '100')";

if ($permite_interagir_chamados == 0) {
    $quantidade_chamados_abertos = "0";
    $quantidade_chamados_sem_atendente = "0";
    $quantidade_meus_chamados = "0";
} else {
    $chamados_abertos = mysqli_query($mysqli, $sql_count_chamados_abertos);
    $campos_chamados_abertos = $chamados_abertos->fetch_array();
    $quantidade_chamados_abertos = $campos_chamados_abertos['quantidade'];

    $chamados_sematendente = mysqli_query($mysqli, $sql_count_chamados_sematendente);
    $campos_chamados_sematendentes = $chamados_sematendente->fetch_array();
    $quantidade_chamados_sem_atendente = $campos_chamados_sematendentes['quantidade'];

    $r_ultimos_30_chamados = mysqli_query($mysqli, $sql_ultimos_30_chamados);

    $chamados_meus = mysqli_query($mysqli, $sql_count_chamados_meus);
    $campos_chamados_meus = $chamados_meus->fetch_array();
    $quantidade_meus_chamados = $campos_chamados_meus['quantidade'];
}



$r_man_prog_af_gpon = mysqli_query($mysqli, $count_man_prog_af_gpon);
$c_man_prog_af_gpon = $r_man_prog_af_gpon->fetch_array();


$r_man_prog_af_backbone = mysqli_query($mysqli, $count_man_prog_af_backbone);
$c_man_prog_af_backbone = $r_man_prog_af_backbone->fetch_array();

$total_mp = (isset($c_man_prog_af_backbone['qtde']) && $c_man_prog_af_backbone['qtde'] > 0 ? $c_man_prog_af_backbone['qtde'] : 0) +
    (isset($c_man_prog_af_gpon['qtde']) && $c_man_prog_af_gpon['qtde'] > 0 ? $c_man_prog_af_gpon['qtde'] : 0);

$r_incidentes_gpon_reincidentes = mysqli_query($mysqli, $incidentes_gpon_reincidentes);

$r_inc_outros = mysqli_query($mysqli, $count_inc_outros);
$c_inc_outros = $r_inc_outros->fetch_array();
