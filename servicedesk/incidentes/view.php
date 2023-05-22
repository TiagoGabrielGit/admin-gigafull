<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";

$usuarioID = $_SESSION['id'];


$dados_usuario =
    "SELECT
    u.empresa_id as empresaID,
    u.tipo_usuario as tipoUsuario
    FROM
    usuarios as u
    WHERE
    u.id =   $usuarioID
";

$r_dados_usuario = mysqli_query($mysqli, $dados_usuario);
$c_dados_usuario = $r_dados_usuario->fetch_array();
$empresaID = $c_dados_usuario['empresaID'];
$tipoUsuario = $c_dados_usuario['tipoUsuario'];

if ($tipoUsuario == 1) { 


    $id_incidente = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $sql_incidente =
    "SELECT
    count(rni.id) as contagem,
    rni.id as idIncidente,
    rni.zabbix_event_id as zabbixID,
    rni.active as statusID,
    rni.autor_id as autor_id,
    eqpop.hostname as equipamento,
    rni.classificacao as idClassificacao,
    ic.classificacao as classificacao,
    rni.descricaoIncidente as descricaoIncidente,
    CASE
    WHEN rni.active = 1 THEN 'Incidente aberto'
    WHEN rni.active = 0 THEN 'Normalizado'
    END active,
    rni.active as activeID,
    date_format(rni.inicioIncidente,'%H:%i:%s %d/%m/%Y') as horainicial,
    date_format(rni.previsaoNormalizacao,'%H:%i:%s %d/%m/%Y') as previsaoNormalizacao,
    date_format(rni.fimIncidente,'%H:%i:%s %d/%m/%Y') as horafinal,
    IF (rni.fimIncidente IS NULL, TIMEDIFF(NOW(), rni.inicioIncidente), TIMEDIFF(rni.fimIncidente, rni.inicioIncidente)) as tempoIncidente
    FROM
    incidentes as rni
    LEFT JOIN
    equipamentospop as eqpop
    ON
    eqpop.id = rni.equipamento_id
    LEFT JOIN
    redeneutra_olts as rno
    ON
    rno.equipamento_id = rni.equipamento_id
    LEFT JOIN
    redeneutra_parceiro_olt as rnpo
    ON
    rnpo.olt_id = rno.id
    LEFT JOIN
    incidentes_classificacao as ic
    ON
    ic.id = rni.classificacao
    WHERE
    rni.id = $id_incidente
    ";

    $r_sql_incidente = mysqli_query($mysqli, $sql_incidente);
    $campos = mysqli_fetch_assoc($r_sql_incidente); ?>

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
                                    <h5 style="text-align: center;"> <?= $campos['descricaoIncidente'] ?></5>
                                </b>
                                <hr class="sidebar-divider">
                            </div>


                            <div class="row">


                                <div class="col-lg-6">
                                    <div class="col-12">
                                        <br>
                                        <b>Equipamento: </b><?= $campos['equipamento'] ?><br>
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
                                                                    } ?><br><br>



                                        <b>Classificação: </b>
                                        <?php
                                        if ($campos['classificacao'] == NULL) {
                                            echo "Não Classificado";
                                        } else {
                                            echo $campos['classificacao'];
                                        } ?> <br>


                                        <b>Previsão Normalização: </b>
                                        <?php
                                        if ($campos['previsaoNormalizacao'] == NULL) {
                                            echo "Sem Previsão";
                                        } else {
                                            echo $campos['previsaoNormalizacao'];
                                        } ?> <br>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-8" style="text-align: left;">
                                            <br>
                                            <b>Hora Inicial: </b><?= $campos['horainicial']; ?><br>
                                            <b>Hora Normalização: </b><?= $campos['horafinal']; ?><br><br>
                                            <b>Tempo total incidente: </b><?= $campos['tempoIncidente']; ?>
                                        </div>

                                        <div class="col-4" style="text-align: center;">
                                            <br>
                                            <?php
                                            if ($campos['statusID'] == "1") { ?>
                                                <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalUpdate">
                                                    Update
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
                                    rni.zabbix_event_id as zabbixID,
                                    date_format(rnir.horarioRelato,'%H:%i:%s %d/%m/%Y') as horarioRelato
                                FROM
                                    incidentes_relatos as rnir
                                LEFT JOIN
                                    incidentes as rni
                                ON
                                    rni.id = rnir.incidente_id
                                WHERE
                                    rnir.incidente_id = $id_incidente
                                ORDER BY
                                    rnir.horarioRelato DESC
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


    <div class="modal fade" id="modalUpdate" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Incidente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="card-body">
                        <form id="updateIncidente" method="POST" class="row g-3">

                            <span id="msg"></span>

                            <input hidden id="incidenteID" name="incidenteID" value="<?= $id_incidente ?>"></input>
                            <input hidden id="solicitante" name="solicitante" value="<?= $usuarioID ?>"></input>

                            <div class="row">
                                <div class="col-5">
                                    <div class="col-12">
                                        <label for="classIncidente" class="form-label">Classificação</label>
                                        <select id="classIncidente" name="classIncidente" class="form-select">
                                            <option selected value="">Selecione</option>

                                            <?php
                                            $sql_classificacao =
                                                "SELECT
                                                    ic.id as idClassificacao,
                                                    ic.classificacao as classificacao
                                                FROM
                                                    incidentes_classificacao as ic
                                                WHERE
                                                    ic.active = 1
                                                ORDER BY
                                                    ic.classificacao ASC";

                                            $r_classificacao = mysqli_query($mysqli, $sql_classificacao);
                                            while ($c_classificacao = mysqli_fetch_object($r_classificacao)) :
                                                echo "<option value='$c_classificacao->idClassificacao'> $c_classificacao->classificacao</option>";
                                            endwhile;
                                            ?>



                                        </select>
                                    </div>
                                </div>

                                <div class="col-3"></div>

                                <div class="col-4">
                                    <div class="col-12">
                                        <label for="statusIncidente" class="form-label">Status</label>
                                        <select id="statusIncidente" name="statusIncidente" class="form-select">
                                            <option selected value="">Selecione</option>
                                            <option value="1">Aberto</option>
                                            <option value="0">Fechado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-5">
                                    <label for="previsaoConclusao" class="form-label">Previsão de Conclusão</label>
                                    <input name="previsaoConclusao" type="datetime-local" class="form-control" id="previsaoConclusao">
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="relatoIncidente" class="form-label">Relato</label>
                                <textarea id="relatoIncidente" name="relatoIncidente" class="form-control" maxlength="500" rows="5" required></textarea>
                            </div>

                            <hr class="sidebar-divider">

                            <div class="col-4"></div>

                            <div class="col-4" style="text-align: center;">
                                <input id="btnUpdate" name="btnUpdate" type="button" value="Update" class="btn btn-danger"></input>
                                <a href="#"> <input type="button" value="Voltar" class="btn btn-secondary"></input></a>
                            </div>

                            <div class="col-4"></div>
                        </form><!-- End Horizontal Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } else { ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Operação não permitida!</h1>
        </div>
    </main>
<?php }

require "../../scripts/update_incidente.php";
require "../../includes/footer.php";
?>