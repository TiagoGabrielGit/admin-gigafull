<?php
require "../includes/menu.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Contratos</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-10">
                                <h5 class="card-title">Lista de Contratos</h5>
                            </div>
                            <div class="col-lg-2" style="margin-top: 10px;">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalCadastrarContrato">Criar Novo</button>
                            </div>
                        </div>
                        <table class="table table-striped" id="styleTable">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Empresa</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $sql_lista_contratos =
                                    "SELECT
                                c.id as idContrato,
                                c.empresa_id as idEmpresa,
                                c.active as idStatus,
                                e.fantasia as fantasia,
                                CASE
                                WHEN c.active = 1 THEN 'Ativo'
                                WHEN c.active = 0 THEN 'Inativo'
                                END as active
                                FROM
                                contract as c
                                LEFT JOIN
                                empresas as e
                                ON
                                e.id = c.empresa_id";

                                $r_lista_contratos = mysqli_query($mysqli, $sql_lista_contratos);
                                while ($c_lista_contratos = $r_lista_contratos->fetch_array()) { ?>

                                    <tr>
                                        <td><?= $c_lista_contratos['idContrato']; ?></td>


                                        <td style="text-align: center;">
                                            <a style="color: red;" href="view.php?id=<?= $c_lista_contratos['idContrato']; ?>"><?= $c_lista_contratos['fantasia']; ?></a>
                                        </td>
                                        <td><?= $c_lista_contratos['active']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<div class="modal fade" id="modalCadastrarContrato" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Criar Contrato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="card-body">
                    <form id="criarContrato" method="POST" class="row g-3">

                        <span id="msg"></span>

                        <div class="row">
                            <div class="col-5">
                                <div class="col-12">
                                    <label for="empresa" class="form-label">Empresa</label>
                                    <select id="empresa" name="empresa" class="form-select">
                                        <option selected value="">Selecione</option>

                                        <?php
                                        $sql_empresa =
                                            "SELECT
                                            e.id as idEmpresa,
                                            e.fantasia as fantasia
                                            FROM
                                            empresas as e
                                            ORDER BY
                                            e.fantasia ASC
                                            ";

                                        $r_empresa = mysqli_query($mysqli, $sql_empresa);
                                        while ($c_empresa = mysqli_fetch_object($r_empresa)) :
                                            echo "<option value='$c_empresa->idEmpresa'> $c_empresa->fantasia</option>";
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <hr class="sidebar-divider">

                            <div class="col-4"></div>

                            <div class="col-4" style="text-align: center;">
                                <input id="btnCriarContrato" name="btnCriarContrato" type="button" value="Criar" class="btn btn-danger"></input>
                            </div>

                            <div class="col-4"></div>
                    </form><!-- End Horizontal Form -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $("#btnCriarContrato").click(function() {
        var dados = $("#criarContrato").serialize();

        $.post("/contrato/processa/addContract.php", dados, function(retorna) {
            $("#msg").slideDown('slow').html(retorna);

            //Limpar os campos
            $('#criarContrato')[0].reset();

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