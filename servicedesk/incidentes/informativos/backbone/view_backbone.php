<?php
require "../../../../includes/menu.php";
require "../../../../conexoes/conexao.php";
require "../../../../conexoes/conexao_pdo.php";
require "../../../../includes/remove_setas_number.php";

$submenu_id = "22";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT 
	u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {

    $usuarioID = $_SESSION['id'];

    $dados_usuario =
        "SELECT
    u.empresa_id as empresaID
    FROM
    usuarios as u
    WHERE
    u.id =   $usuarioID
";

    $r_dados_usuario = mysqli_query($mysqli, $dados_usuario);
    $c_dados_usuario = $r_dados_usuario->fetch_array();
    $empresaID = $c_dados_usuario['empresaID'];

    $permite_incidentes_backbone = "SELECT COUNT(*) AS count FROM incidentes_types_empresa as ite WHERE ite.empresa_id = $empresaID AND ite.incidente_type_id = 3";
    $stmt = $pdo->query($permite_incidentes_backbone);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {

        $gerenciarIncidentes = $_SESSION['permite_gerenciar_incidente'];

        if ($gerenciarIncidentes == 1) {

            $id_incidente = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

            $sql_incidente =
                "SELECT
            count(i.id) as contagem,
            i.id as idIncidente,
            i.zabbix_event_id as zabbixID,
            i.active as statusID,
            i.autor_id as autor_id,
            i.envio_com_normalizacao as envio_com_normalizacao,
            i.incident_type as tipo,
            i.equipamento_id as host_id,
            i.protocolo_erp as protocoloERP,
            it.type as tipoIncidente,
            eqpop.hostname as equipamento,
            i.classificacao as idClassificacao,
            ic.classificacao as classificacao,
            i.descricaoIncidente as descricaoIncidente,
            i.previsaoNormalizacao as prevNOR,
            CASE
            WHEN i.active = 1 THEN 'Incidente aberto'
            WHEN i.active = 0 THEN 'Normalizado'
            END active,
            i.active as activeID,
            date_format(i.inicioIncidente,'%H:%i:%s %d/%m/%Y') as horainicial,
            date_format(i.previsaoNormalizacao,'%H:%i:%s %d/%m/%Y') as previsaoNormalizacao,
            date_format(i.fimIncidente,'%H:%i:%s %d/%m/%Y') as horafinal,
            IF (i.fimIncidente IS NULL, TIMEDIFF(NOW(), i.inicioIncidente), TIMEDIFF(i.fimIncidente, i.inicioIncidente)) as tempoIncidente
            FROM
            incidentes as i
            LEFT JOIN
            equipamentospop as eqpop
            ON
            eqpop.id = i.equipamento_id
            LEFT JOIN
            gpon_olts as o
            ON
            o.equipamento_id = i.equipamento_id
            LEFT JOIN
            redeneutra_parceiro_olt as rnpo
            ON
            rnpo.olt_id = o.id
            LEFT JOIN
            incidentes_classificacao as ic
            ON
            ic.id = i.classificacao
            LEFT JOIN
            incidentes_types as it
            ON
            it.codigo = i.incident_type
            WHERE
            i.id = $id_incidente
    ";

            $r_sql_incidente = mysqli_query($mysqli, $sql_incidente);
            $campos = mysqli_fetch_assoc($r_sql_incidente);
            $descIncidente = $campos['descricaoIncidente'];
            $host_id = $campos['host_id'];
            $protocoloERP = $campos['protocoloERP'];
            $tipo = $campos['tipo'];
            $zabbixID = $campos['zabbixID'];
            $idClassificacao = $campos['idClassificacao'];
            $tipoIncidente = $campos['tipo'];
            $statusID = $campos['statusID'];
            $prevNOR = $campos['prevNOR'];
?>

            <style>
                #tabelaLista:hover {
                    cursor: pointer;
                    background-color: #E0FFFF;
                }
            </style>
            <main id="main" class="main">
                <div class="pagetitle">
                    <h1>Incidente #<?= $campos['idIncidente'] ?></h1>
                </div>
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="col-12">
                                        <hr class="sidebar-divider">
                                        <b>
                                            <h5 style="text-align: center;"><?= $campos['descricaoIncidente'] ?></5>
                                        </b>
                                        <hr class="sidebar-divider">
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="col-12">
                                                <br>
                                                <?php if ($campos['tipo'] <> 102) { ?>
                                                    <b>Equipamento: </b><?= $campos['equipamento'] ?><br>
                                                <?php } ?>
                                                <b>Criador Incidente: </b> <?php if ($campos['autor_id'] == null) {
                                                                                echo "Integração Zabbix";
                                                                            } else {



                                                                                $autor_id = $campos['autor_id'];
                                                                                $sql_usuario = "SELECT
                                                                    p.nome as nome_usuario
                                                                    FROM
                                                                    usuarios as u
                                                                    LEFT JOIN
                                                                    pessoas as p
                                                                    ON
                                                                    u.pessoa_id = p.id
                                                                    WHERE 
                                                                    u.id = $autor_id
                                                                    ";

                                                                                $resultado_usuario = mysqli_query($mysqli, $sql_usuario);
                                                                                $row_usuario = mysqli_fetch_assoc($resultado_usuario);
                                                                                echo $row_usuario['nome_usuario'];
                                                                            } ?><br>

                                                <b>Tipo de Incidente: </b>
                                                <?php
                                                if ($campos['tipoIncidente'] == NULL) {
                                                    echo "Não Definido";
                                                } else {
                                                    echo $campos['tipoIncidente'];
                                                } ?> <br>

                                                <b>Classificação: </b>
                                                <?php
                                                if ($campos['classificacao'] == NULL) {
                                                    echo "Não Classificado";
                                                } else {
                                                    echo $campos['classificacao'];
                                                } ?> <br>



                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <div class="col-12" style="text-align: left;">
                                                    <br>
                                                    <b>Hora Inicial: </b><?= $campos['horainicial']; ?><br>
                                                    <b>Previsão Normalização: </b>
                                                    <?php
                                                    if ($campos['previsaoNormalizacao'] == NULL) {
                                                        echo "Sem Previsão";
                                                    } else {
                                                        echo $campos['previsaoNormalizacao'];
                                                    } ?> <br>
                                                    <b>Hora Normalização: </b><?= $campos['horafinal']; ?><br>
                                                    <b>Tempo total incidente: </b><?= $campos['tempoIncidente']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="row">
                                                <div class="col-12" style="text-align: center;">
                                                    <br>
                                                    <?php
                                                    if ($campos['statusID'] == "1") { ?>
                                                        <form method="POST" action="atualiza_incidente.php">
                                                            <input hidden readonly value="<?= $campos['idIncidente'] ?>" name="idIncidente" id="idIncidente">
                                                            <button style="margin-top: 15px" class="btn btn-sm btn-danger" type="submit">Atualizar</button>
                                                        </form>
                                                    <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    if ($campos['statusID'] == "1" && $campos['tipo'] == "100") { ?>
                                                        <button style="margin-top: 15px" data-bs-toggle="modal" data-bs-target="#modalAnalisarGPON" id="buttonAnalisarGPON" class="btn btn-sm btn-danger" type="button">Analisar GPON</button>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12" style="text-align: center;">
                                                    <br>
                                                    <?php
                                                    if ($campos['envio_com_normalizacao'] == "0") {
                                                    ?>
                                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalComunicados">
                                                            Comunicados
                                                        </button>
                                                    <?php
                                                    }

                                                    if ($campos['statusID'] == "1") {
                                                    ?>
                                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalInteressados">
                                                            Interessados
                                                        </button>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="sidebar-divider">

                                    <div class="accordion" id="accordionFlushExample">
                                        <?php
                                        $sql_relatos_incidentes =
                                            "SELECT
                                    rnir.id as id_relato,
                                    rnir.relato as relato,
                                    rnir.relato_autor as autor_id,
                                    date_format(rnir.previsaoNormalizacao,'%H:%i:%s %d/%m/%Y') as previsaoNormalizacao,

                                    ic.classificacao as classificacao,
                                    rni.zabbix_event_id as zabbixID,
                                    date_format(rnir.horarioRelato,'%H:%i:%s %d/%m/%Y') as horarioRelato
                                FROM incidentes_relatos as rnir
                                LEFT JOIN incidentes as rni ON rni.id = rnir.incidente_id
                                LEFT JOIN incidentes_classificacao as ic ON ic.id = rnir.classificacao
                                WHERE rnir.incidente_id = $id_incidente
                                ORDER BY rnir.horarioRelato DESC
                                ";

                                        $resultado_relatos = mysqli_query($mysqli, $sql_relatos_incidentes)  or die("Erro ao retornar dados");
                                        $cont = 1;
                                        while ($campos = $resultado_relatos->fetch_array()) {
                                            $id_relato = $campos['id_relato'];

                                        ?>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-heading<?= $cont ?>"> <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $cont ?>" aria-expanded="false" aria-controls="flush-collapse<?= $cont ?>">Relato #<?= $id_relato ?></button></h2>
                                                <div id="flush-collapse<?= $cont ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $cont ?>" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <b>Horário Relato: </b> <?= $campos['horarioRelato'] ?><br>
                                                                <b>Relator: </b> <?php if ($campos['autor_id'] == null) {
                                                                                        echo "Integração Zabbix";
                                                                                    } else {
                                                                                        $autor_id = $campos['autor_id'];
                                                                                        $sql_usuario = "SELECT
                                                                    p.nome as nome_usuario
                                                                    FROM
                                                                    usuarios as u
                                                                    LEFT JOIN
                                                                    pessoas as p
                                                                    ON
                                                                    u.pessoa_id = p.id
                                                                    WHERE 
                                                                    u.id = $autor_id
                                                                    ";

                                                                                        $resultado_usuario = mysqli_query($mysqli, $sql_usuario);
                                                                                        $row_usuario = mysqli_fetch_assoc($resultado_usuario);
                                                                                        echo $row_usuario['nome_usuario'];
                                                                                    } ?> <br>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <b>Classificação:</b> <?= $campos['classificacao']; ?><br>
                                                                <b>Previsão Normalização:</b> <?= $campos['previsaoNormalizacao']; ?><br>
                                                            </div>
                                                        </div>

                                                        <hr class="sidebar-divider">
                                                        <b>Descrição: </b> <br><?= nl2br($campos['relato']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php $cont++;
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <div class="modal fade" id="modalAnalisarGPON" tabindex="-1">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Analise GPON</h5>
                        </div>

                        <div class="modal-body">
                            <div class="card-body">
                                <div class="col-12">
                                    <h3 id="statusMessage" style="text-align: center;">Analisando</h3>
                                </div>
                                <div class="col-12 text-center">
                                    <div class="spinner-border text-success " role="status">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalInteressados" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Lista de Interessados no Incidente</h5>
                        </div>

                        <div class="modal-body">
                            <div class="card-body">
                                <div class="col-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Empresa</th>
                                                <th style="text-align: center;">Comunicação</th>
                                                <th style="text-align: center;">Midia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($tipo == 100) {
                                                $interessados =
                                                    "SELECT
                                    e.fantasia as fantasia,
                                    CASE
                                    WHEN en.metodo_id = 1 THEN 'E-mail'
                                    WHEN en.metodo_id = 2 THEN 'Telegram'
                                    WHEN en.metodo_id = 3 THEN 'Whatsapp'
                                    END as comunicacao,
                                    en.midia as midia
                                    FROM
                                    gpon_olts_interessados as goi
                                    LEFT JOIN
                                    gpon_olts as gpo
                                    ON
                                    gpo.id = goi.gpon_olt_id
                                    LEFT JOIN
                                    empresas_notificacao as en
                                    ON
                                    en.empresa_id = goi.interessado_empresa_id
                                    LEFT JOIN
                                    empresas as e
                                    ON
                                    e.id = goi.interessado_empresa_id
                                    WHERE
                                    en.active = 1
                                    and
                                    goi.active = 1
                                    and
                                    gpo.equipamento_id = $host_id";

                                                $r_interessados = mysqli_query($mysqli, $interessados);
                                                while ($c_interessados = $r_interessados->fetch_array()) { ?>
                                                    <tr>
                                                        <td style="text-align: center;"><?= $c_interessados['fantasia']; ?></td>
                                                        <td style="text-align: center;"><?= $c_interessados['comunicacao']; ?></td>
                                                        <td style="text-align: center;"><?= $c_interessados['midia']; ?></td>
                                                    </tr>
                                                <?php }
                                            } else if ($tipo == 102) {
                                                $interessados =
                                                    "SELECT
                                        e.fantasia as fantasia,
                                        CASE
                                        WHEN en.metodo_id = 1 THEN 'E-mail'
                                        WHEN en.metodo_id = 2 THEN 'Telegram'
                                        WHEN en.metodo_id = 3 THEN 'Whatsapp'
                                        END as comunicacao,
                                        en.midia as midia
                                        FROM
                                        rotas_fibras_interessados as rfi
                                        LEFT JOIN
                                        rotas_fibra as rf
                                        ON
                                        rf.id = rfi.rf_id
                                        LEFT JOIN
                                        empresas_notificacao as en
                                        ON
                                        en.empresa_id = rfi.interessado_empresa_id
                                        LEFT JOIN
                                        empresas as e
                                        ON
                                        e.id = rfi.interessado_empresa_id
                                        WHERE
                                        en.active = 1
                                        AND
                                        rfi.active = 1
                                        and
                                        rf.codigo = $host_id";
                                                $r_interessados = mysqli_query($mysqli, $interessados);
                                                while ($c_interessados = $r_interessados->fetch_array()) { ?>
                                                    <tr>
                                                        <td style="text-align: center;"><?= $c_interessados['fantasia']; ?></td>
                                                        <td style="text-align: center;"><?= $c_interessados['comunicacao']; ?></td>
                                                        <td style="text-align: center;"><?= $c_interessados['midia']; ?></td>
                                                    </tr>
                                            <?php }
                                            } ?>

                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalComunicados" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Comunicados Enviados</h5>
                            <form method="POST" action="/servicedesk/incidentes/processa/comunicaInteressados.php" class="d-inline-block">
                                <input value="<?= $id_incidente ?>" id="icdID" name="icdID" hidden readonly>
                                <button type="submit" class="btn btn-sm btn-success">Enviar Comunicado</button>
                            </form>
                        </div>

                        <div class="modal-body">
                            <div class="card-body">
                                <?php
                                $comunicados = "SELECT
                   CASE
                       WHEN ct.titulo IS NULL THEN 'Sem Template Vinculado'
                       ELSE ct.titulo
                   END as titulo,
                   p.nome as usuario,
                   c.id as idCom,
                   DATE_FORMAT(c.created, '%d/%m/%Y %H:%i:%s') as criado,
                   CASE
                       WHEN status = 0 THEN 'Cancelada'
                       WHEN status = 1 THEN 'Rascunho'
                       WHEN status = 2 THEN 'Enviada'
                   END as status
               FROM comunicacao as c
               LEFT JOIN usuarios as u ON u.id = c.usuario_criador
               LEFT JOIN pessoas as p ON p.id = u.pessoa_id
               LEFT JOIN comunicacao_templates as ct ON ct.id = c.template_email
               WHERE c.origem_id = $id_incidente
               ORDER BY c.id desc
               ";

                                try {
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    $stmt = $pdo->prepare($comunicados);
                                    $stmt->execute();
                                    $c_comunicados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                } catch (PDOException $e) {
                                    echo "Erro na consulta SQL: " . $e->getMessage();
                                }
                                // Verifique se há resultados antes de criar a tabela
                                if (!empty($c_comunicados)) {
                                    echo '<table class="table datatable">';
                                    echo '<thead>';
                                    echo '<tr>';
                                    echo '<th>Template</th>';
                                    echo '<th>Usuário</th>';
                                    echo '<th>Criado Em</th>';
                                    echo '<th>Status</th>';
                                    echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';

                                    foreach ($c_comunicados as $comunicado) { ?>
                                        <tr id="tabelaLista" onclick="location.href='/comunicacao/gerenciar_comunicados/view_comunicacao.php?id=<?= $comunicado['idCom'] ?>'">
                                            <td><?= $comunicado['titulo'] ?></td>
                                            <td><?= $comunicado['usuario'] ?></td>
                                            <td><?= $comunicado['criado'] ?></td>
                                            <td><?= $comunicado['status'] ?></td>
                                        </tr>
                                <?php }

                                    echo '</tbody>';
                                    echo '</table>';
                                } else {
                                    echo 'Nenhum resultado encontrado.';
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div><!-- End Basic Modal-->

<?php
        } else {
            require "../../../../acesso_negado.php";
        }
    } else {
        require "../../../../acesso_negado.php";
    }
} else {
    require "../../../../acesso_negado.php";
}
require "../../../../includes/securityfooter.php";
?>