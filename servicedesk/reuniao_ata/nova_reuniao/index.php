<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');


$submenu_id = "56";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";
$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {
?>


    <main id="main" class="main">
        <section class="section">
            <form method="post" action="processa/nova_reuniao.php">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="text-left">
                                        <h5 class="card-title">NOVA REUNIÃO</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-10">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label" for="assunto">Assunto</label>
                                                <input id="assunto" name="assunto" class="form-control" type="text"></input>
                                            </div>
                                            <div class="col-3">
                                                <label class="form-label" for="inicio">Inicio</label>
                                                <input id="inicio" name="inicio" class="form-control" type="datetime-local"></input>
                                            </div>
                                            <div class="col-3">
                                                <label class="form-label" for="fim">Fim</label>
                                                <input id="fim" name="fim" class="form-control" type="datetime-local"></input>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="form-label" for="local">Local</label>
                                                <input id="local" name="local" class="form-control" type="text"></input>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="card-title mb-0">PAUTAS</h5>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-end">
                                            <button id="btnAdicionarPauta" style="margin-top: 20px;" class="btn btn-sm btn-danger rounded-pill">Adicionar Pauta</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="pautasContainer">
                                    <!-- Aqui serão adicionados os pares de label e input dinamicamente -->
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="card-title mb-0">PARTICIPANTES</h5>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-end">
                                            <butto id="btnAdicionarParticipantes" style="margin-top: 20px;" class="btn btn-sm btn-danger rounded-pill">Adicionar Participantes</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="participantesContainer">
                                    <!-- Aqui serão adicionados os pares de label e input dinamicamente -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-sm btn-danger" type="submit">Criar nova reunião</button>
                </div>
            </form>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function() {
            var pautaCount = 1;

            $('#btnAdicionarPauta').click(function() {
                // Cria um novo par de label e input
                var novoPauta =
                    '<div class="row mt-3">' +
                    '<div class="col-8">' +
                    '<label for="pauta[' + pautaCount + ']" class="form-label">Pauta ' + pautaCount + '</label>' +
                    '<input required id="pauta[' + pautaCount + ']" name="pauta[' + pautaCount + ']" type="text" class="form-control">' +
                    '</div>' +
                    '<div class="col-8">' +
                    '<label for="descricaoPauta[' + pautaCount + ']" class="form-label">Descrição Pauta ' + pautaCount + '</label>' +
                    '<textarea style="resize: none;" required id="descricaoPauta[' + pautaCount + ']" name="descricaoPauta[' + pautaCount + ']" class="form-control"></textarea>' +
                    '</div>' +
                    '</div>';

                // Adiciona o novo par ao container de pautas
                $('#pautasContainer').append(novoPauta);

                // Incrementa o contador de pautas
                pautaCount++;
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var participantesCount = 1;

            $('#btnAdicionarParticipantes').click(function() {
                // Cria um novo par de label e input
                var novoParticipante =
                    '<div class="row mt-3">' +
                    '<div class="col-5">' +
                    '<label for="nomeParticipante[' + participantesCount + ']" class="form-label">Nome Participante ' + participantesCount + '</label>' +
                    '<input required id="nomeParticipante[' + participantesCount + ']" name="nomeParticipante[' + participantesCount + ']" type="text" class="form-control">' +
                    '</div>' +
                    '<div class="col-6">' +
                    '<label for="emailParticipante[' + participantesCount + ']" class="form-label">E-mail Participante ' + participantesCount + '</label>' +
                    '<input required id="emailParticipante[' + participantesCount + ']" name="emailParticipante[' + participantesCount + ']" type="email" class="form-control">' +
                    '</div>' +
                    '</div>'

                ;

                $('#participantesContainer').append(novoParticipante);

                participantesCount++;
            });
        });
    </script>

<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>