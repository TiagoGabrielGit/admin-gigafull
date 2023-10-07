<?php
$token = $_GET['token'];
$ip = $_SERVER['REMOTE_ADDR'];
$permissaoGerenciar = "0";
require "../../../conexoes/conexao_pdo.php"; // Certifique-se de que esta linha está correta
require "../../../conexoes/conexao.php"; // Certifique-se de que esta linha está correta

try {
    $query_frame = "SELECT ii.id as id_iframe, ii.empresa_id as empresa_id
                    FROM incidentes_iframe as ii
                    WHERE ii.active = 1 and ii.token = :token";

    $stmt = $pdo->prepare($query_frame);
    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        $empresa_id = $result[0]['empresa_id'];
        $id_iframe = $result[0]['id_iframe'];
        $empresaID = $empresa_id;

        $all_open =
            "SELECT count(*) as qtde
        FROM incidentes_iframe_ip_address as iiip
        WHERE iiip.incidentes_iframe_id = :id_iframe and ip = '0.0.0.0'
        ";

        $stmt_all_open = $pdo->prepare($all_open);
        $stmt_all_open->bindParam(':id_iframe', $id_iframe, PDO::PARAM_INT);
        $stmt_all_open->execute();
        $result_all_open = $stmt_all_open->fetchAll(PDO::FETCH_ASSOC);

        $query_ip = "SELECT count(*) as qtde
                     FROM incidentes_iframe_ip_address AS iiip
                     WHERE iiip.incidentes_iframe_id = :id_iframe and iiip.ip = :ip";

        $stmt_ip = $pdo->prepare($query_ip);
        $stmt_ip->bindParam(':id_iframe', $id_iframe, PDO::PARAM_INT);
        $stmt_ip->bindParam(':ip', $ip, PDO::PARAM_STR);
        $stmt_ip->execute();
        $result_ip = $stmt_ip->fetchAll(PDO::FETCH_ASSOC);

        if ($result_ip[0]['qtde'] > 0 || $result_all_open[0]['qtde'] > 0) {


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

            $count_inc_backb =
                "SELECT
    count(i.id) as qtde
    FROM
    incidentes as i
    INNER JOIN rotas_fibra as rf ON i.equipamento_id = rf.codigo
    INNER JOIN rotas_fibras_interessados as rfi ON rf.id = rfi.rf_id
    WHERE rfi.interessado_empresa_id =  $empresaID AND i.active = 1 AND rfi.active = 1 and i.incident_type = 102";

            $r_inc_backb = mysqli_query($mysqli, $count_inc_backb);
            $c_inc_backb = $r_inc_backb->fetch_array();

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
                ) AS subquery;";

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


            $man_prog_menos_24h_gpon =
                "SELECT count(*) as qtde
FROM manutencao_programada as mp
LEFT JOIN manutencao_gpon as mg ON mg.manutencao_id = mp.id
LEFT JOIN gpon_pon as gp on gp.id = mg.pon_id
LEFT JOIN gpon_olts as go on go.id = gp.olt_id
LEFT JOIN gpon_olts_interessados as goi ON goi.gpon_olt_id = go.id
where mp.active = 1   and goi.interessado_empresa_id = $empresaID and goi.active = 1 and mp.dataAgendamento <= DATE_ADD(NOW(), INTERVAL 24 HOUR) AND mp.dataAgendamento > NOW()
GROUP BY mp.id";

            $r_man_prog_menos_24h_gpon = mysqli_query($mysqli, $man_prog_menos_24h_gpon);
            $c_man_prog_menos_24h_gpon = $r_man_prog_menos_24h_gpon->fetch_array();

            $man_prog_menos_24h_backbone =
                "SELECT count(*) as qtde
FROM
manutencao_programada as mp
LEFT JOIN manutencao_rotas_fibra as mrf ON mrf.manutencao_id = mp.id
LEFT JOIN rotas_fibras_interessados as rfi ON rfi.rf_id = mrf.rota_id
where
mp.active = 1  and rfi.interessado_empresa_id = $empresaID  and rfi.active = 1 and mp.dataAgendamento <= DATE_ADD(NOW(), INTERVAL 24 HOUR) AND mp.dataAgendamento > NOW()
GROUP BY mp.id";

            $r_man_prog_menos_24h_backbone = mysqli_query($mysqli, $man_prog_menos_24h_backbone);
            $c_man_prog_menos_24h_backbone = $r_man_prog_menos_24h_backbone->fetch_array();



            $man_prog_ocorrendo_gpon =
                "SELECT count(*) as qtde
            FROM manutencao_programada as mp
            LEFT JOIN manutencao_gpon as mg ON mg.manutencao_id = mp.id
            LEFT JOIN gpon_pon as gp on gp.id = mg.pon_id
            LEFT JOIN gpon_olts as go on go.id = gp.olt_id
            LEFT JOIN gpon_olts_interessados as goi ON goi.gpon_olt_id = go.id
            where mp.active = 1   and goi.interessado_empresa_id = $empresaID and goi.active = 1 AND mp.dataAgendamento < NOW()
            GROUP BY mp.id";

            $r_man_prog_ocorrendo_gpon = mysqli_query($mysqli, $man_prog_ocorrendo_gpon);
            $c_man_prog_ocorrendo_gpon = $r_man_prog_ocorrendo_gpon->fetch_array();

            $man_prog_ocorrendo_backbone =
                "SELECT count(*) as qtde
                FROM
                manutencao_programada as mp
                LEFT JOIN manutencao_rotas_fibra as mrf ON mrf.manutencao_id = mp.id
                LEFT JOIN rotas_fibras_interessados as rfi ON rfi.rf_id = mrf.rota_id
                where
                mp.active = 1  and rfi.interessado_empresa_id = $empresaID  and rfi.active = 1 AND mp.dataAgendamento < NOW()
                GROUP BY mp.id";

            $r_man_prog_ocorrendo_backbone = mysqli_query($mysqli, $man_prog_ocorrendo_backbone);
            $c_man_prog_ocorrendo_backbone = $r_man_prog_ocorrendo_backbone->fetch_array();



            require "incidentes.php";
        } else {
            echo "IP: $ip - Não autorizado.";
        }
    } else {
        echo "Token não encontrado!";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
