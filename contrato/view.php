<?php
require "../includes/menu.php";

$idContrato = $_GET['id'];

$sql_contrato =
    "SELECT
c.id as idContrato,
c.empresa_id as idEmpresa,
CASE
WHEN active = 1 THEN 'Ativo'
WHEN active = 0 THEN 'Inativo'
END as active,
c.active as idActive,
e.fantasia as fantasia
FROM
contract as c
LEFT JOIN
empresas as e
ON
e.id = c.empresa_id
WHERE
c.id = $idContrato
";

$r_contrato = mysqli_query($mysqli, $sql_contrato);
$c_contrato = $r_contrato->fetch_array();

?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Contrato</h1>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="information-tab" data-bs-toggle="tab" data-bs-target="#information" type="button" role="tab" aria-controls="information" aria-selected="true">Informações do Contrato</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="service-tab" data-bs-toggle="tab" data-bs-target="#service" type="button" role="tab" aria-controls="service" aria-selected="false">Serviços</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content pt-2" id="myTabContent">
                                        <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="information-tab">
                                            <?php
                                            require "tab/information.php";
                                            ?>
                                        </div>
                                        <div class="tab-pane fade" id="service" role="tabpanel" aria-labelledby="service-tab">
                                            <?php
                                            require "tab/service.php";
                                            ?>
                                        </div>
                                    </div><!-- End Default Tabs -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>



<script>
    $("#adicionarService").click(function() {
        var dados1 = $("#adicionaServico").serialize();
        $.post("/contrato/processa/addService.php", dados1, function(retorna1) {
            $("#serviceMsgAdiciona").slideDown('slow').html(retorna1);

            //Limpar os campos
            $('#adicionaServico')[0].reset();

            //Apresentar a mensagem leve
            retirarMsgService();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgService() {
        setTimeout(function() {
            $("#serviceMsgAdiciona").slideUp('slow', function() {});
        }, 1700);
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $("#btnEditContractInformation").click(function() {
        var dados = $("#editContractInformation").serialize();

        $.post("/contrato/processa/editInformation.php", dados, function(retorna) {
            $("#msg").slideDown('slow').html(retorna);

            //Limpar os campos
            $('#editContractInformation')[0].reset();

            //Apresentar a mensagem leve
            retirarMsg();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsg() {
        setTimeout(function() {
            $("#msg").slideUp('slow', function() {});
        }, 1700);
    }
</script>

<?php
require "../includes/footer.php";
?>