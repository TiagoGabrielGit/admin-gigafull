<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$usuarioID = $_SESSION['id'];
$idPOP = $_GET['id'];

$menu_id = "6";
$uid = $_SESSION['id'];

$permissions_menu =
    "SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_menu pp ON u.perfil_id = pp.perfil_id 
    WHERE u.id = $uid AND pp.url_menu = $menu_id";

$exec_permissions_menu = $pdo->prepare($permissions_menu);
$exec_permissions_menu->execute();

$rowCount_permissions_menu = $exec_permissions_menu->rowCount();

if ($rowCount_permissions_menu > 0) {
$sql_pop =
    "SELECT
    pop.id as id,
    pop.pop as pop,
    pop.apelidoPop as apelidoPop
    FROM pop as pop
    LEFT JOIN pop_address as endereco ON endereco.pop_id = pop.id
    LEFT JOIN empresas as emp ON emp.id = pop.empresa_id
    WHERE pop.active = 1 and pop.id = $idPOP    
    ORDER BY emp.fantasia asc, endereco.city asc, pop.pop asc
";

$resultado = mysqli_query($mysqli, $sql_pop);
$row = mysqli_fetch_assoc($resultado);

$sql_datas_vistorias =
    "SELECT
v.id as idVistoria,
date_format(v.date, '%d/%m/%Y') as date 
FROM
vistoria as v
WHERE
v.pop_id LIKE '$idPOP'
ORDER BY
v.date DESC";
$r_datas_vistorias = mysqli_query($mysqli, $sql_datas_vistorias);

$sql_usuarios =
    "SELECT
u.id as idUsuario,
p.nome as usuario
FROM usuarios as u
LEFT JOIN pessoas as p ON p.id = u.pessoa_id
WHERE u.active = 1
ORDER BY p.nome ASC";

$r_usuarios = mysqli_query($mysqli, $sql_usuarios);


$sql_lista_equipamentos =
    "SELECT
    eqp.id as idEqp,
    eqp.hostname as equipamento,
    eqto.equipamento as modelo,
    eqp.statusEquipamento as status
    FROM equipamentospop as eqp
    LEFT JOIN equipamentos as eqto ON eqto.id = eqp.equipamento_id
    WHERE eqp.deleted = 1 and eqp.pop_id LIKE '$idPOP'
    ORDER BY eqp.hostname ASC";

$r_lista_equipamentos = mysqli_query($mysqli, $sql_lista_equipamentos);
$r_lista_vistoria_equipamentos = mysqli_query($mysqli, $sql_lista_equipamentos);
$r2_lista_vistoria_equipamentos = mysqli_query($mysqli, $sql_lista_equipamentos);
?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">POP <?= $row['pop']; ?></h5>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="informacoes-tab" data-bs-toggle="tab" data-bs-target="#informacoes" type="button" role="tab" aria-controls="informacoes" aria-selected="true" onclick="window.location.href = 'view_informacoes.php?id=<?= $idPOP ?>';">Informacoes</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link " id="equipamentos-tab" data-bs-toggle="tab" data-bs-target="#equipamentos" type="button" role="tab" aria-controls="equipamentos" aria-selected="false" onclick="window.location.href = 'view_equipamentos.php?id=<?= $idPOP ?>';">Equipamentos</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="energia-tab" data-bs-toggle="tab" data-bs-target="#energia" type="button" role="tab" aria-controls="energia" aria-selected="false" onclick="window.location.href = 'view_energia.php?id=<?= $idPOP ?>';">Energia</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="anexo-tab" data-bs-toggle="tab" data-bs-target="#anexo" type="button" role="tab" aria-controls="anexo" aria-selected="false" onclick="window.location.href = 'view_anexo.php?id=<?= $idPOP ?>';">Anexos</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="atividades-tab" data-bs-toggle="tab" data-bs-target="#atividades" type="button" role="tab" aria-controls="atividades" aria-selected="false" onclick="window.location.href = 'view_atividades.php?id=<?= $idPOP ?>';">Atividades</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="vistoria-tab" data-bs-toggle="tab" data-bs-target="#vistoria" type="button" role="tab" aria-controls="vistoria" aria-selected="false" onclick="window.location.href = 'view_vistoria.php?id=<?= $idPOP ?>';">Vistoria</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="card-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-8">
                                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="novaVistoria-tab" data-bs-toggle="tab" data-bs-target="#novaVistoria" type="button" role="tab" aria-controls="novaVistoria" aria-selected="true">Nova Vistoria</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="realizadas-tab" data-bs-toggle="tab" data-bs-target="#realizadas" type="button" role="tab" aria-controls="realizadas" aria-selected="false" tabindex="-1">Vistorias Realizadas</button>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-primary text-right" onclick="window.open('/tcpdf/export/relatorio_vistorias.php?id=<?= $idPOP ?>', '_blank')">Gerar Formulário de Vistoria</button>
                                        </div>
                                    </div>
                                </div>


                                <div class="tab-content pt-2" id="myTabContent">
                                    <div class="tab-pane fade show active" id="novaVistoria" role="tabpanel" aria-labelledby="novaVistoria-tab">



                                        <form id="salvarVistoria" method="POST">
                                            <span id="msgSalvarVistoria"></span>
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Informações</h5>
                                                        <div class="row g-3">

                                                            <input name="idPOPVistoria" type="text" class="form-control" id="idPOPVistoria" value="<?= $idPOP  ?>" hidden>

                                                            <div class="col-md-4">
                                                                <label for="dataVistoria" class="form-label">Data Vistoria</label>
                                                                <input id="dataVistoria" name="dataVistoria" type="date" class="form-control" required>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="responsavelVistoria" class="form-label">Responsável</label>
                                                                <select id="responsavelVistoria" name="responsavelVistoria" class="form-select" required>
                                                                    <option value="" disabled selected="">Selecione</option>
                                                                    <?php
                                                                    while ($c_usuarios = $r_usuarios->fetch_assoc()) { ?>
                                                                        <option value="<?= $c_usuarios['idUsuario'] ?>"><?= $c_usuarios['usuario'] ?></option>
                                                                    <?php }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div><br>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="limpezaPOP" class="form-label">Limpeza</label>
                                                                <textarea id="limpezaPOP" name="limpezaPOP" class="form-control" maxlength="1000" class="form-control" style="height: 100px"></textarea>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="organizacaoPOP" class="form-label">Organização</label>
                                                                <textarea id="organizacaoPOP" name="organizacaoPOP" class="form-control" maxlength="1000" class="form-control" style="height: 100px"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Equipamentos</h5>

                                                            <div class="accordion" id="accordionExample">
                                                                <?php
                                                                $contador = "1";
                                                                while ($c_lista_vistoria_equipamentos = $r_lista_vistoria_equipamentos->fetch_array()) {
                                                                ?>
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="heading<?= $contador ?>">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $contador ?>" aria-expanded="false" aria-controls="collapse<?= $contador ?>">
                                                                                <?= $c_lista_vistoria_equipamentos['equipamento']; ?> - <?= $c_lista_vistoria_equipamentos['modelo']; ?>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="collapse<?= $contador ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $contador ?>" data-bs-parent="#accordionExample" style="">
                                                                            <div class="accordion-body">

                                                                                <input id="equipamento_id<?= $contador ?>" name="equipamento_id<?= $contador ?>" type="text" class="form-control" value="<?= $c_lista_vistoria_equipamentos['idEqp']; ?>" readonly hidden>

                                                                                <div class="row">
                                                                                    <div class="col-md-4">
                                                                                        <label for="energiaEquipamento<?= $contador ?>" class="form-label">Energia</label>
                                                                                        <select id="energiaEquipamento<?= $contador ?>" name="energiaEquipamento<?= $contador ?>" class="form-select" required>
                                                                                            <option disabled selected="">Selecione</option>
                                                                                            <option value="AC - 110vAC">AC - 110vAC</option>
                                                                                            <option value="AC - 220vAC">AC - 220vAC</option>
                                                                                            <option value="DC - 12vDC">DC - 12vDC</option>
                                                                                            <option value="DC - 24vDC">DC - 24vDC</option>
                                                                                            <option value="DC - 48vDC">DC - 48vDC</option>
                                                                                        </select>
                                                                                    </div>

                                                                                    <div class="col-md-6">
                                                                                        <label for="limpezaAdequada<?= $contador ?>" class="form-label">Limpeza Adequada</label>
                                                                                        <select id="limpezaAdequada<?= $contador ?>" name="limpezaAdequada<?= $contador ?>" class="form-select" required>
                                                                                            <option disabled selected="">Selecione</option>
                                                                                            <option value="Sim">Sim</option>
                                                                                            <option value="Não">Não</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <label for="detalhesFonte<?= $contador ?>" class="form-label">Detalhamento Fonte</label>
                                                                                    <textarea id="detalhesFonte<?= $contador ?>" name="detalhesFonte<?= $contador ?>" required class="form-control" style="height: 50px"></textarea>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <label for="observacaoEquipamento<?= $contador ?>" class="form-label">Observação</label>
                                                                                    <textarea id="observacaoEquipamento<?= $contador ?>" name="observacaoEquipamento<?= $contador ?>" required class="form-control" style="height: 100px"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                <?php
                                                                    $contador++;
                                                                } ?>
                                                                <input name="qtdeEquipamentos" id="qtdeEquipamentos" value="<?= $contador  ?>" hidden>
                                                            </div><!-- End Default Accordion Example -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Observações Gerais</h5>

                                                            <div class="col-md-12">
                                                                <label for="observacoesGerais" class="form-label">Observações Gerais do POP</label>
                                                                <textarea id="observacoesGerais" name="observacoesGerais" class="form-control" maxlength="3000" class="form-control" style="height: 150px"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <input id="btnSalvarVistoria" name="btnSalvarVistoria" type="button" value="Salvar" class="btn btn-danger"></input>
                                            </div>
                                        </form>
                                    </div><!-- tab-pane fade show active -->
                                    <div class="tab-pane fade " id="realizadas" role="tabpanel" aria-labelledby="rack-tab">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Informações Gerais</h5>
                                                        <div class="row g-3">

                                                            <div class="col-md-4">
                                                                <label for="data-select" class="form-label">Selecione uma data</label>
                                                                <select id="data-select" name="data-select" class="form-select" required onchange="buscarDados()">
                                                                    <option value="" disabled selected="">Selecione</option>
                                                                    <?php
                                                                    while ($c_datas = $r_datas_vistorias->fetch_assoc()) { ?>
                                                                        <option value="<?= $c_datas['idVistoria'] ?>"><?= $c_datas['date'] ?></option>
                                                                    <?php }
                                                                    ?>
                                                                </select>
                                                            </div>

                                                        </div><br>
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <label for="buscaResponsavelVistoria" class="form-label">Responsável</label>
                                                                <input id="buscaResponsavelVistoria" name="buscaResponsavelVistoria" type="text" class="form-control" disabled>
                                                            </div>
                                                        </div><br>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="buscaLimpezaVistoria" class="form-label">Limpeza</label>
                                                                <textarea rows="8" id="buscaLimpezaVistoria" name="buscaLimpezaVistoria" class="form-control" disabled class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="buscaOrganizacaoVistoria" class="form-label">Organização</label>
                                                                <textarea rows="8" id="buscaOrganizacaoVistoria" name="buscaOrganizacaoVistoria" class="form-control" disabled class="form-control"></textarea>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <label for="buscaObsGeralVistoria" class="form-label">Observações Gerais do POP</label>
                                                                <textarea rows="8" id="buscaObsGeralVistoria" name="buscaObsGeralVistoria" class="form-control" disabled class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Vistoria Equipamento</h5>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="equipamento-select" class="form-label">Selecione um Equipamento</label>
                                                                <select id="equipamento-select" name="equipamento-select" class="form-select" required onchange="buscarDadosEquipamento()">
                                                                    <option value="" disabled selected="">Selecione a data</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label class="form-label">Energia</label>
                                                                <textarea rows="5" id="resultEnergia" name="resultEnergia" readonly class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label class="form-label">Limpeza Adequada</label>
                                                                <textarea rows="5" id="resultLimpeza" name="resultLimpeza" readonly class="form-control"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <label class="form-label">Detalhamento Fonte</label>
                                                            <textarea rows="5" id="resultFonte" name="resultFonte" readonly class="form-control"></textarea>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label">Observação</label>
                                                            <textarea rows="5" id="resultObs" name="resultObs" readonly class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End DIV tab-content pt-2 -->
                        </div><!-- End DIV card-body -->
                    </div>
                </div><!-- End Default Tabs -->
            </div>
        </div>
    </section>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>


<script>
    $("#btnSalvarVistoria").click(function() {
        var dadosSalvarVistoria = $("#salvarVistoria").serialize();

        $.post("/telecom/sitepop/processa/criarVistoria.php", dadosSalvarVistoria, function(retornaSalvarVistoria) {
            $("#msgSalvarVistoria").slideDown('slow').html(retornaSalvarVistoria);


            //Limpar os campos
            $('#salvarVistoria')[0].reset();

            //Apresentar a mensagem leve
            retirarMsgSalvarVistoria();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgSalvarVistoria() {
        setTimeout(function() {
            $("#msgSalvarVistoria").slideUp('slow', function() {});
        }, 1700);
    }
</script>

<script>
    function buscarDados() {
        var dataSelecionada = $('#data-select').val(); // Obter o valor selecionado no <select>

        // Fazer a solicitação AJAX para buscar os dados no servidor
        $.ajax({
            url: 'processa/buscar_dados.php', // URL do script PHP que buscará os dados no banco de dados
            type: 'POST',
            data: {
                data: dataSelecionada
            }, // Enviar a data selecionada como parâmetro
            success: function(responseBuscaDados) {
                // Preencher os campos no código HTML com base nos dados retornados
                $('#buscaLimpezaVistoria').val(responseBuscaDados.buscaLimpezaVistoria);
                $('#buscaOrganizacaoVistoria').val(responseBuscaDados.buscaOrganizacaoVistoria);
                $('#buscaResponsavelVistoria').val(responseBuscaDados.buscaResponsavelVistoria);
                $('#buscaObsGeralVistoria').val(responseBuscaDados.buscaObsGeralVistoria);
            },
            error: function() {
                alert('Erro ao buscar os dados.'); // Exibir mensagem de erro, se ocorrer algum problema
            }
        });

        $.ajax({
            url: "processa/buscar_vistorias.php",
            method: "POST",
            dataType: "HTML",
            data: {
                data: dataSelecionada
            }
        }).done(function(responseBuscaVistorias) {
            $("#equipamento-select").html(responseBuscaVistorias);
        }).fail(function(responseBuscaVistorias) {
            alert(responseBuscaVistorias)
        });
    }
</script>

<script>
    function buscarDadosEquipamento() {
        var idVistoriaEquipamento = $('#equipamento-select').val();
        // Fazer a solicitação AJAX para buscar os dados no servidor
        $.ajax({
            url: 'processa/buscar_vistoria_equipamento.php', // URL do script PHP que buscará os dados no banco de dados
            type: 'POST',
            data: {
                id: idVistoriaEquipamento
            }, // Enviar a data selecionada como parâmetro
            success: function(responseVistoriaEquipamentos) {
                // Preencher os campos no código HTML com base nos dados retornados
                $('#resultEnergia').val(responseVistoriaEquipamentos.energia);
                $('#resultLimpeza').val(responseVistoriaEquipamentos.limpeza);
                $('#resultFonte').val(responseVistoriaEquipamentos.detalhes_fonte);
                $('#resultObs').val(responseVistoriaEquipamentos.observacao);
            },
            error: function() {
                alert('Erro ao buscar os dados.'); // Exibir mensagem de erro, se ocorrer algum problema
            }
        });
    }
</script>
<?php
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>