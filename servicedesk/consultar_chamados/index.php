<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "../../conexoes/conexao_pdo.php";
require "sql1.php";

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $empresa_id = $_POST['empresaPesquisa'];
    $atendentePesquisa = $_POST['atendentePesquisa'];
    $statusChamado = $_POST['statusChamado'];
} else {
    $empresa_id = "%";
    $atendentePesquisa = "%";
    $statusChamado = "%";
}

$id_usuario = $_SESSION['id'];

$sql_captura_id_pessoa =
    "SELECT
u.pessoa_id as pessoaID
FROM
usuarios as u
WHERE
id = '$id_usuario'
";

$result_cap_pessoa = mysqli_query($mysqli, $sql_captura_id_pessoa);
$pessoaID = mysqli_fetch_assoc($result_cap_pessoa);
?>

<style>
    .accordion-button:not(.collapsed) {
        color: #012970;
        background-color: #e6e6e6;
    }

    #closed:hover {
        cursor: pointer;
        background-color: #a9a9a9;
    }

    #open:hover {
        cursor: pointer;
        background-color: #c1f8f8;
    }

    #inExecution:hover {
        background-color: #7efb7e;
    }

    .closed {
        background-color: #c8c8c8;
        border-color: black;
    }

    .open {
        background-color: #ecfefe;
        border-color: black;
    }

    .inExecution {
        background-color: #a5fba5;
        border-color: black;
    }

    .colorAccordion {
        background-color: #ffffff;
        border-color: black;
    }
</style>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Listagem de chamados</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">

                    <div class="card-body">

                        <div class="container">
                            <div class="row">
                                <div class="col-9">
                                    <h5 class="card-title">Filtros</h5>
                                </div>
                                <div class="col-3">
                                    <div class="card">
                                        <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                            Abrir novo chamado
                                        </button>
                                    </div>
                                </div>

                                <div class="modal fade" id="basicModal" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Novo chamado</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <form id="abrirChamado" method="POST" class="row g-3">

                                                        <span id="msg"></span>

                                                        <input hidden id="solicitante" name="solicitante" value="<?= $id_usuario ?>"></input>

                                                        <div class="col-6">
                                                            <label for="empresaChamado" class="form-label">Empresa</label>
                                                            <select class="form-select" id="empresaChamado" name="empresaChamado" required>
                                                                <option disabled selected value="">Selecione a empresa</option>
                                                                <?php
                                                                $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                                                while ($tipos = mysqli_fetch_object($resultado)) :
                                                                    echo "<option value='$tipos->id_empresa'> $tipos->fantasia_empresa</option>";
                                                                endwhile;
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-6">
                                                            <label for="tipoChamado" class="form-label">Tipo de chamado</label>
                                                            <select class="form-select" id="tipoChamado" name="tipoChamado" required>
                                                                <option disabled selected value="">Selecione o tipo de chamado</option>
                                                                <?php
                                                                $resultado = mysqli_query($mysqli, $sql_lista_tipos_chamados);
                                                                while ($tipos = mysqli_fetch_object($resultado)) :
                                                                    echo "<option value='$tipos->id'> $tipos->tipo</option>";
                                                                endwhile;
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-6">
                                                            <label for="assuntoChamado" class="form-label">Assunto</label>
                                                            <input type="text" class="form-control" id="assuntoChamado" name="assuntoChamado" required>
                                                        </div>

                                                        <div class="col-12">
                                                            <label for="relatoChamado" class="form-label">Descreva a situa????o</label>
                                                            <textarea id="relatoChamado" name="relatoChamado" class="form-control" maxlength="1000" required></textarea>

                                                        </div>

                                                        <hr class="sidebar-divider">

                                                        <div class="col-4"></div>

                                                        <div class="col-4" style="text-align: center;">
                                                            <input id="btnSalvar" name="btnSalvar" type="button" value="Salvar" class="btn btn-danger"></input>
                                                            <a href="/servicedesk/consultar_chamados/index.php"> <input type="button" value="Voltar" class="btn btn-secondary"></input></a>
                                                        </div>

                                                        <div class="col-4"></div>
                                                    </form><!-- End Horizontal Form -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="#" class="row g-3">

                            <div class="col-4">
                                <label for="empresaPesquisa" class="form-label">Empresa</label>
                                <select id="empresaPesquisa" name="empresaPesquisa" class="form-select">
                                    <option selected value="%">Todas</option>
                                    <?php
                                    $resultado = mysqli_query($mysqli, $sql_lista_empresas);

                                    while ($empresa = mysqli_fetch_object($resultado)) :
                                        echo "<option value='$empresa->id_empresa'> $empresa->fantasia_empresa</option>";
                                    endwhile;

                                    if ($_SERVER["REQUEST_METHOD"] == 'POST') :

                                    ?>
                                        <script>
                                            let nomeEmpresa = '<?= $_POST['empresaPesquisa']; ?>'
                                            if (nomeEmpresa == '%') {} else {
                                                document.querySelector("#empresaPesquisa").value = nomeEmpresa
                                            }
                                        </script>
                                    <?php
                                    endif;
                                    ?>
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="atendentePesquisa" class="form-label">Atendente</label>
                                <select id="atendentePesquisa" name="atendentePesquisa" class="form-select">
                                    <option selected value="%">Todos</option>
                                    <option value="<?=$id_usuario?>">Minhas</option>
                                    <option value="0">Sem atendente</option>


                                    <?php if ($_SERVER["REQUEST_METHOD"] == 'POST') : ?>
                                        <script>
                                            let atendentePesquisa = '<?= $_POST['atendentePesquisa']; ?>'
                                            if (atendentePesquisa == '%') {} else {
                                                document.querySelector("#atendentePesquisa").value = atendentePesquisa
                                            }
                                        </script>
                                    <?php
                                    endif;
                                    ?>

                                </select>
                            </div>

                            <div class="col-4">
                                <label for="statusChamado" class="form-label">Status</label>
                                <select id="statusChamado" name="statusChamado" class="form-select">
                                    <option selected value="%">Todos</option>
                                    <option value="1">Aberto</option>
                                    <option value="2">Andamento</option>
                                    <option value="3">Fechado</option>

                                    <?php if ($_SERVER["REQUEST_METHOD"] == 'POST') : ?>
                                        <script>
                                            let statusChamado = '<?= $_POST['statusChamado']; ?>'
                                            if (statusChamado == '%') {} else {
                                                document.querySelector("#statusChamado").value = statusChamado
                                            }
                                        </script>
                                    <?php
                                    endif;
                                    ?>

                                </select>
                            </div>

                            <div class="col-6">
                                <button style="margin-top: 30px; " type="submit" class="btn btn-danger">Filtrar</button>
                            </div>

                        </form>

                        <hr class="sidebar-divider">

                        <div class="accordion" id="accordionFlushExample">

                            <?php
                            // Verifica se a vari??vel t?? declarada, sen??o deixa na primeira p??gina como padr??o
                            if (isset($_GET["pagina"])) {
                                $p = $_GET["pagina"];
                            } else {
                                $p = 1;
                            }
                            // Defina aqui a quantidade m??xima de registros por p??gina.
                            $qnt = 25;

                            // O sistema calcula o in??cio da sele????o calculando: 
                            // (p??gina atual * quantidade por p??gina) - quantidade por p??gina
                            $inicio = ($p * $qnt) - $qnt;

                            $sql_select =
                                "SELECT
                            ch.id as id_chamado,
                            ch.assuntoChamado as assunto,
                            ch.relato_inicial as relato_inicial,
                            ch.atendente_id as id_atendente,
                            date_format(ch.data_abertura,'%H:%i:%s %d/%m/%Y') as dataAbertura,
                            ch.in_execution as inExecution,
                            ch.status_id as id_status,
                            cs.status_chamado as statusChamado,
                            tc.tipo as tipoChamado,
                            emp.fantasia as fantasia,
                            p.nome as atendente
                            FROM
                            chamados as ch
                            LEFT JOIN
                            empresas as emp
                            ON
                            ch.empresa_id = emp.id
                            LEFT JOIN
                            tipos_chamados as tc
                            ON
                            ch.tipochamado_id  = tc.id
                            LEFT JOIN
                            chamados_status as cs
                            ON
                            cs.id = ch.status_id
                            LEFT JOIN
                            usuarios as u
                            ON
                            u.id = ch.atendente_id
                            LEFT JOIN
                            pessoas as p
                            ON
                            p.id = u.pessoa_id
                            WHERE
                            ch.empresa_id LIKE '$empresa_id'
                            and
                            ch.atendente_id LIKE '$atendentePesquisa'
                            and
                            ch.status_id LIKE '$statusChamado'
                            ORDER BY
                            ch.data_abertura DESC
                            LIMIT $inicio, $qnt
                            ";

                            // Executa o Query
                            $sql_query = mysqli_query($mysqli, $sql_select);
                            $cont = 1;
                            // Cria um while para pegar as informa????es do BD
                            while ($campos = $sql_query->fetch_array()) {
                                $id_chamado = $campos['id_chamado'];
                                if (empty($campos['atendente'])) {
                                    $atendente = "Sem atendente";
                                } else {
                                    $atendente = $campos['atendente'];
                                }
                                if ($campos['inExecution'] == 1) {
                                    $Color = "inExecution";
                                } else if ($campos['id_status'] == 3) {
                                    $Color = "closed";
                                } else {
                                    $Color = "open";
                                }


                                $calc_tempo_total =
                                    "SELECT SUM(seconds_worked) as secondsTotal
                                from chamados
                                where id = $id_chamado";

                                $seconds_total = mysqli_query($mysqli, $calc_tempo_total);
                                $res_second = $seconds_total->fetch_array();

                            ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-heading<?= $cont ?>">
                                        <button class="accordion-button collapsed <?= $Color ?>" id="<?= $Color ?>" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $cont ?>" aria-expanded="false" aria-controls="flush-collapse<?= $cont ?>">
                                            Chamado #<?= $id_chamado ?> - <?= $campos['tipoChamado']; ?> - <?= $campos['assunto']; ?> - <?= $atendente ?>
                                        </button>
                                    </h2>
                                    <div id="flush-collapse<?= $cont ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $cont ?>" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body colorAccordion">
                                            <div class="row justify-content-between">
                                                <div class="col-5">
                                                    <b>Chamado: </b><?= $id_chamado ?><br>
                                                    <b>Tipo de chamado: </b><?= $campos['tipoChamado']; ?><br>
                                                    <b>Cliente: </b><?= $campos['fantasia']; ?><br>
                                                    <b>Atendente: </b><?= $atendente ?><br><br>
                                                    <b>Descri????o: </b><br><?= nl2br($campos['relato_inicial']); ?>
                                                </div>
                                                <div class="col-5">
                                                    <b>Data abertura: </b><?= $campos['dataAbertura']; ?><br>
                                                    <b>Status: </b><?= $campos['statusChamado']; ?><br><br>
                                                    <b>Tempo total atendimento: </b> <?= gmdate("H:i:s", $res_second['secondsTotal']); ?>
                                                </div>
                                                <div class="col-2">
                                                    <a href="/servicedesk/consultar_chamados/view.php?id=<?= $id_chamado ?>" title="Visualizar">
                                                        <button type="button" class="btn btn-danger">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                                            </svg>
                                                            Ver chamado
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            <?php $cont++;
                            }

                            // Depois que selecionou todos os nome, pula uma linha para exibir os links(pr??xima, ??ltima...)
                            echo "<br />";

                            // Faz uma nova sele????o no banco de dados, desta vez sem LIMIT,
                            // para pegarmos o n??mero total de registros
                            $sql_select_all = "SELECT
                            ch.id as id_chamado,
                            ch.assuntoChamado as assunto,
                            ch.relato_inicial as relato_inicial,
                            ch.atendente_id as id_atendente,
                            date_format(ch.data_abertura,'%H:%i:%s %d/%m/%Y') as dataAbertura,
                            ch.in_execution as inExecution,
                            ch.status_id as id_status,
                            cs.status_chamado as statusChamado,
                            tc.tipo as tipoChamado,
                            emp.fantasia as fantasia,
                            p.nome as atendente
                            FROM
                            chamados as ch
                            LEFT JOIN
                            empresas as emp
                            ON
                            ch.empresa_id = emp.id
                            LEFT JOIN
                            tipos_chamados as tc
                            ON
                            ch.tipochamado_id = tc.id
                            LEFT JOIN
                            chamados_status as cs
                            ON
                            cs.id = ch.status_id
                            LEFT JOIN
                            pessoas as p
                            ON
                            p.id = ch.atendente_id
                            WHERE
                            ch.empresa_id LIKE '$empresa_id'
                            and
                            ch.atendente_id LIKE '$atendentePesquisa'
                            and
                            ch.status_id LIKE '$statusChamado'
                            ORDER BY
                            ch.data_abertura DESC";

                            // Executa o query da sele????o acimas
                            $sql_query_all = mysqli_query($mysqli, $sql_select_all);


                            // Gera uma vari??vel com o n??mero total de registros no banco de dados
                            $total_registros = mysqli_num_rows($sql_query_all);

                            // Gera outra vari??vel, desta vez com o n??mero de p??ginas que ser?? precisa.
                            // O comando ceil() arredonda "para cima" o valor
                            $pags = ceil($total_registros / $qnt);

                            // N??mero m??ximos de bot??es de pagina????o
                            $max_links = 5; ?>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php
                                    // Exibe o primeiro link "primeira p??gina", que n??o entra na contagem acima(3)
                                    ?>
                                    <li class="page-item"><a class="page-link" href="/servicedesk/consultar_chamados/index.php?pagina=1">Primeira P??gina</a></li>
                                    <?php
                                    // Cria um for() para exibir os 3 links antes da p??gina atual
                                    for ($i = $p - $max_links; $i <= $p - 1; $i++) {
                                        // Se o n??mero da p??gina for menor ou igual a zero, n??o faz nada
                                        // (afinal, n??o existe p??gina 0, -1, -2..)
                                        if ($i <= 0) {
                                            //faz nada
                                            // Se estiver tudo OK, cria o link para outra p??gina
                                        } else {
                                    ?>
                                            <li class="page-item"><a class="page-link" href="/servicedesk/consultar_chamados/index.php?pagina=<?= $i ?>"><?= $i ?></a></li>
                                    <?php

                                        }
                                    }
                                    // Exibe a p??gina atual, sem link, apenas o n??mero
                                    ?>
                                    <li class="page-item active"><a class="page-link"><?= $p ?></a></li>
                                    <?php
                                    // Cria outro for(), desta vez para exibir 3 links ap??s a p??gina atual
                                    for ($i = $p + 1; $i <= $p + $max_links; $i++) {
                                        // Verifica se a p??gina atual ?? maior do que a ??ltima p??gina. Se for, n??o faz nada.
                                        if ($i > $pags) {
                                            //faz nada
                                        }
                                        // Se tiver tudo Ok gera os links.
                                        else {
                                    ?>
                                            <li class="page-item"><a class="page-link" href="/servicedesk/consultar_chamados/index.php?pagina=<?= $i ?>"><?= $i ?></a></li>
                                    <?php
                                        }
                                    }
                                    // Exibe o link "??ltima p??gina"
                                    ?>
                                    <li class="page-item"><a class="page-link" href="/servicedesk/consultar_chamados/index.php?pagina=<?= $pags ?>">??ltima P??gina</a></li>
                                </ul>
                            </nav><!-- End Basic Pagination -->
                        </div>

                        <!-- End Table with stripped rows -->
                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
require "../../scripts/abrir_chamado.php";
require "../../includes/footer.php";
?>