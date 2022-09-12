<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao.php";
require "../../../conexoes/conexao_pdo.php";
?>

<?php
$idServico = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql_servico_view =
    "SELECT
s.id as idServico,
s.descricao as descricaoServico,
s.unidade as unidadeServico,
CASE
    WHEN s.servico = 1 THEN 'Prestação de Serviço'
END as servico,
CASE
    WHEN s.unidade = 1 THEN 'Horas'
END as unidade,
s.servico as unidadeHidden,
s.descricao as descricao,
s.active as statusServico,
s.pacoteHoras as pacoteHoras,
s.valorHora as valorHora,
s.valorHoraExcedente as valorHoraExcedente
FROM
servicos as s
WHERE
s.id = $idServico";

$resposta_sql_servico_view = mysqli_query($mysqli, $sql_servico_view);
$campos_servico = mysqli_fetch_assoc($resposta_sql_servico_view);

if ($campos_servico['statusServico'] == '1') {
    $statusServicoAtivo = "selected";
    $statusServicoInativo = "";
} else if ($campos_servico['statusServico'] == '0') {
    $statusServicoAtivo = "";
    $statusServicoInativo = "selected";
}
?>


<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Código <?= $idServico ?> -
                            <?= $campos_servico['descricaoServico']; ?></h5>

                        <?php
                        if ($campos_servico['unidadeServico'] == '1') {
                            $valorHora = $campos_servico['valorHora'];
                            $valorHora = str_replace('.', ',', $valorHora);
                            $valorHoraExcedente = $campos_servico['valorHoraExcedente'];
                            $valorHoraExcedente = str_replace('.', ',', $valorHoraExcedente);
                            require "includes/formUnidadeHora.php";
                        }
                        ?>


                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->

<?php
require "script.php";
require "../../../includes/footer.php";
?>