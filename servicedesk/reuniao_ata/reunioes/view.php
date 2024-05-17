<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$submenu_id = "57";
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
    $id = $_GET['id'];

    $busca_reuniao =
        "SELECT
        ar.assunto AS assunto, 
        ar.inicio AS inicio1,
        ar.fim AS fim1,
        DATE_FORMAT(ar.inicio, '%d/%m/%Y %H:%i') AS inicio, 
        DATE_FORMAT(ar.fim, '%d/%m/%Y %H:%i') AS fim, 
        ar.id AS id,
        ar.local as local,
        p.nome as criador,
        CASE
        WHEN ar.status = 1 THEN 'Agendado'
        WHEN ar.status = 2 THEN 'Realizada'
        WHEN ar.status = 3 THEN 'Cancelada'
        END as status
        FROM ata_reuniao as ar 
        LEFT JOIN usuarios as u ON u.id = ar.criador
        LEFT JOIN pessoas as p ON p.id  = u.pessoa_id
        LEFT JOIN ata_reuniao_acesso as ara ON ara.id_reuniao = ar.id AND ara.id_usuario = :uid AND ara.active = 1
        WHERE ar.id = :id AND (ar.criador = :uid OR ara.id_usuario IS NOT NULL)";

    $stmt = $pdo->prepare($busca_reuniao);
    $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    $stmt->execute();
    $reuniao = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reuniao) {
?>
        <main id="main" class="main">
            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="text-left">
                                        <br>
                                        <span style="font-size: 20px;"><b>REUNIÃO - <?= $reuniao['assunto'] ?></b></span>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-6">
                                                <span><b>Inicio:</b> <?= $reuniao['inicio'] ?></span>
                                            </div>
                                            <div class="col-6">
                                                <span><b>Fim:</b> <?= $reuniao['fim'] ?></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <span><b>Local:</b> <?= $reuniao['local'] ?></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <span><b>Criador:</b> <?= $reuniao['criador'] ?></span>
                                            </div>
                                            <div class="col-6">
                                                <span><b>Status:</b> <?= $reuniao['status'] ?></span>
                                            </div>

                                        </div>
                                    </div>

                                    <?php if ($reuniao['status'] == "Agendado") { ?>
                                        <div class="col-lg-4">
                                            <div class="col-12">
                                                <button data-bs-toggle="modal" data-bs-target="#modalParticipante" type="button" class="btn btn-sm btn-danger">Adicionar Participante</button>
                                                <button data-bs-toggle="modal" data-bs-target="#modalPauta" type="button" class="btn btn-sm btn-danger">Adicionar Pauta</button>
                                            </div>
                                            <div style="margin-top: 5px;" class="col-12">
                                                <button data-bs-toggle="modal" data-bs-target="#modalAcesso" type="button" class="btn btn-sm btn-danger">Adicionar Acesso Permitido</button>
                                                <button data-bs-toggle="modal" data-bs-target="#modalAlterarReuniao" type="button" class="btn btn-sm btn-danger">Alterar Reunião</button>
                                            </div>
                                        </div>

                                    <?php }  ?>
                                </div>

                                <br>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span style="font-size: 16px;"><b>Participantes</b></span>
                                        <?php
                                        $query_participantes =
                                            "SELECT * 
                                        FROM ata_reuniao_participantes AS arp
                                        WHERE arp.id_ata_reuniao = :id
                                        ORDER BY arp.nome ASC";

                                        $stmt = $pdo->prepare($query_participantes);
                                        $stmt->execute(['id' => $id]);
                                        while ($participante = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <div class="row">
                                                <div class="col-6">
                                                    <a href="#" class="remove-participant" data-id="<?= $participante['id'] ?>" style="color: red; margin-left: 10px;"><i class="bi bi-trash"></i></a>
                                                    <span><b>Nome:</b> <?= $participante['nome'] ?></span>
                                                </div>
                                                <div class="col-6">
                                                    <span><b>E-mail:</b> <?= $participante['email'] ?></span>
                                                </div>
                                            </div>
                                        <?php }
                                        ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <span style="font-size: 16px;"><b>Acessos Permitidos</b></span>
                                        <?php
                                        $query_acessos =
                                            "SELECT ara.id as id, p.nome as nome 
                                        FROM ata_reuniao_acesso AS ara
                                        LEFT JOIN usuarios as u ON u.id = ara.id_usuario
                                        LEFT JOIN pessoas as p ON p.id = u.pessoa_id
                                        WHERE ara.id_reuniao = :id AND ara.active = 1
                                        ORDER BY p.nome ASC";

                                        $stmt = $pdo->prepare($query_acessos);
                                        $stmt->execute(['id' => $id]);
                                        while ($acessos = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>

                                            <div class="row">
                                                <div class="col-12">
                                                    <a href="#" class="remove-acesso" data-id="<?= $acessos['id'] ?>" style="color: red; margin-left: 10px;"><i class="bi bi-trash"></i></a>

                                                    <span><b>Usuário:</b> <?= $acessos['nome'] ?></span>
                                                </div>
                                            </div>
                                        <?php }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        $query_pautas = "SELECT * FROM ata_reuniao_pautas AS arp WHERE arp.id_ata_reuniao = :id";
                        $stmt = $pdo->prepare($query_pautas);
                        $stmt->execute(['id' => $id]);

                        while ($pautas = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-left">
                                        <h5 class="card-title">PAUTA: <?= $pautas['pauta'] ?></h5>
                                    </div>
                                    <div class="col-lg-12">
                                        <form method="POST" action="processa/insere_debate.php">
                                            <input id="pautaID" name="pautaID" hidden readonly value="<?= $pautas['id'] ?>">
                                            <div class="row">
                                                <div class="col-lg-5">
                                                    <span><b>Descrição</b></span><br>
                                                    <span><?= $pautas['descricao'] ?></span>
                                                </div>
                                                <div class="col-lg-7">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label for="debate" class="form-label"><b>Debate</b></label>
                                                            <textarea id="descricao<?= $pautas['id'] ?>" name="debate" style="resize: none;" rows="10" class="form-control" disabled><?= $pautas['debate'] ?></textarea>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <?php if ($reuniao['status'] == "Agendado") { ?>

                                                        <div class="row">
                                                            <div class="col-10"></div>
                                                            <div class="col-2">
                                                                <button class="btn btn-sm btn-primary editar" type="button" onclick="habilitarEdicao(<?= $pautas['id'] ?>)" data-id="<?= $pautas['id'] ?>">Editar</button>
                                                                <button hidden class="btn btn-sm btn-danger salvar" type="submit" data-id="<?= $pautas['id'] ?>">Salvar</button>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
        </main>

        <div class="modal fade" id="modalParticipante" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" action="processa/adicionar_participantes.php">

                        <input hidden readonly id="id_reuniao" name="id_reuniao" value="<?= $id ?>">
                        <div class="modal-header">
                            <h5 class="modal-title">Participantes</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-10"></div>
                                <div class="col-2">
                                    <button id="btnAdicionarParticipante" class="btn btn-sm btn-info">Adicionar</button>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6">
                                    <label for="nomeParticipante[1]" class="form-label">Participante 1</label>
                                    <input required id="nomeParticipante[1]" name="nomeParticipante[1]" type="text" class="form-control">
                                </div>
                                <div class="col-6">
                                    <label for="emailParticipante[1]" class="form-label">E-mail Participante 1</label>
                                    <input required id="emailParticipante[1]" name="emailParticipante[1]" type="email" class="form-control">
                                </div>
                            </div>

                            <div id="participantesContainer">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-sm btn-danger">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalPauta" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="post" action="processa/adicionar_pauta.php">

                        <input hidden readonly id="id_reuniao" name="id_reuniao" value="<?= $id ?>">
                        <div class="modal-header">
                            <h5 class="modal-title">Pautas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-10"></div>
                                <div class="col-2">
                                    <button id="btnAdicionarPauta" class="btn btn-sm btn-info">Adicionar</button>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-8">
                                    <label for="pauta[1]" class="form-label">Pauta 1</label>
                                    <input required id="pauta[1]" name="pauta[1]" type="text" class="form-control">
                                </div>
                                <div class="col-8">
                                    <label for="descricaoPauta[1]" class="form-label">Descrição Pauta 1</label>
                                    <textarea class="form-control" id="descricaoPauta[1]" name="descricaoPauta[1]" style="resize: nome;" rows="4"></textarea>

                                </div>
                            </div>

                            <div id="pautasContainer">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-sm btn-danger">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalAcesso" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Acessos Permitidos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="processa/adicionar_acesso_permitido.php">

                        <div class="modal-body">

                            <input hidden readonly id="id_reuniao" name="id_reuniao" value="<?= $id ?>">
                            <div class="col-12">
                                <label class="form-label" for="usuarioID">Usuário</label>
                                <select class="form-select" id="usuarioID" name="usuarioID" required>
                                    <option selected disabled value="">Selecione</option>
                                    <?php
                                    $usuarios =
                                        "SELECT u.id AS id, p.nome AS usuario
                          FROM usuarios AS u
                          LEFT JOIN pessoas AS p ON p.id = u.pessoa_id
                          WHERE u.active = 1 
                          AND u.id NOT IN (
                              SELECT id_usuario 
                              FROM ata_reuniao_acesso
                              WHERE id_reuniao = $id
                          )
                          ORDER BY p.nome ASC";

                                    $stmt = $pdo->prepare($usuarios);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['usuario'] ?></option>
                                    <?php } ?>

                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-sm btn-danger">Salvar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="modal fade" id="modalAlterarReuniao" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Alterar Reunião</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>


                    <form method="POST" action="processa/alterar_reuniao.php">
                        <div class="modal-body">
                            <input hidden readonly id="id_reuniao" name="id_reuniao" value="<?= $id ?>">
                            <div class="row">
                                <div class="col-6">
                                    <label for="novoStatus" class="form-label">Novo Status</label>
                                    <select id="novoStatus" name="novoStatus" required class="form-select">
                                        <option value="1" selected>Agendado</option>
                                        <option value="2">Realizada</option>
                                        <option value="3">Cancelada</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label for="novoLocal" class="form-label">Novo Local</label>
                                    <input id="novoLocal" name="novoLocal" class="form-control" value="<?= $reuniao['local'] ?>"></input>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="novoInicio" class="form-label">Novo Inicio</label>
                                    <input class="form-control" id="novoInicio" name="novoInicio" type="datetime-local" value="<?= $reuniao['inicio1'] ?>">
                                </div>
                                <div class="col-6">
                                    <label for="novoFim" class="form-label">Novo Fim</label>
                                    <input class="form-control" id="novoFim" name="novoFim" type="datetime-local" value="<?= $reuniao['fim1'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-sm btn-danger">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- End Basic Modal-->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

        <script>
            var pautaEmEdicaoId = null;

            function habilitarEdicao(id) {
                // Verifica se já existe uma pauta em edição
                if (pautaEmEdicaoId !== null && pautaEmEdicaoId !== id) {
                    var confirmacao = confirm("Já existe uma pauta em edição. Deseja cancelar a edição atual e editar esta pauta?");
                    if (!confirmacao) {
                        return; // Cancela a edição se o usuário não confirmar
                    } else {
                        // Se o usuário confirmar, desabilita a pauta em edição atual e oculta os botões correspondentes
                        var pautaEmEdicaoTextarea = document.getElementById('descricao' + pautaEmEdicaoId);
                        var btnEditarAnterior = document.querySelector('.editar[data-id="' + pautaEmEdicaoId + '"]');
                        var btnSalvarAnterior = document.querySelector('.salvar[data-id="' + pautaEmEdicaoId + '"]');
                        pautaEmEdicaoTextarea.setAttribute('disabled', 'disabled');
                        btnEditarAnterior.removeAttribute('hidden');
                        btnSalvarAnterior.setAttribute('hidden', 'hidden');
                        btnSalvarAnterior.setAttribute('disabled', 'disabled');
                    }
                }

                // Atualiza o ID da pauta em edição
                pautaEmEdicaoId = id;

                // Habilita o textarea e define o foco
                var textarea = document.getElementById('descricao' + id);
                textarea.removeAttribute('disabled');
                textarea.focus();

                // Altera a visibilidade dos botões
                var btnEditar = document.querySelector('.editar[data-id="' + id + '"]');
                var btnSalvar = document.querySelector('.salvar[data-id="' + id + '"]');
                btnEditar.setAttribute('hidden', 'hidden');
                btnSalvar.removeAttribute('hidden');
                btnSalvar.removeAttribute('disabled');
            }

            $(document).ready(function() {
                var participanteCount = 2;

                $('#btnAdicionarParticipante').click(function() {
                    // Cria um novo par de label e input
                    var novoParticipante =
                        '<div class="row mt-3">' +
                        '<div class="col-6">' +
                        '<label for="nomeParticipante[' + participanteCount + ']" class="form-label">Participante ' + participanteCount + '</label>' +
                        '<input required id="nomeParticipante[' + participanteCount + ']" name="nomeParticipante[' + participanteCount + ']" type="text" class="form-control">' +
                        '</div>' +
                        '<div class="col-6">' +
                        '<label for="emailParticipante[' + participanteCount + ']" class="form-label">E-mail Participante ' + participanteCount + '</label>' +
                        '<input required id="emailParticipante[' + participanteCount + ']" name="emailParticipante[' + participanteCount + ']" type="email" class="form-control">' +
                        '</div>' +
                        '</div>';

                    // Adiciona o novo par ao container de participantes
                    $('#participantesContainer').append(novoParticipante);

                    // Incrementa o contador de participantes
                    participanteCount++;
                });
            });

            $(document).ready(function() {
                var pautaCount = 2;

                $('#btnAdicionarPauta').click(function() {
                    var novoPauta =
                        '<div class="row mt-3">' +
                        '<div class="col-8">' +
                        '<label for="pauta[' + pautaCount + ']" class="form-label">Pauta ' + pautaCount + '</label>' +
                        '<input required id="pauta[' + pautaCount + ']" name="pauta[' + pautaCount + ']" type="text" class="form-control">' +
                        '</div>' +
                        '<div class="col-8">' +
                        '<label for="descricaoPauta[' + pautaCount + ']" class="form-label">Descrição Pauta ' + pautaCount + '</label>' +
                        '<textarea class="form-control" id="descricaoPauta[' + pautaCount + ']" name="descricaoPauta[' + pautaCount + ']" style="resize: nome;" rows="4"></textarea>' +
                        '</div>' +
                        '</div>';

                    $('#pautasContainer').append(novoPauta);

                    pautaCount++;
                });
            });

            $(document).ready(function() {
                $('.remove-participant').on('click', function(e) {
                    e.preventDefault();
                    var participantId = $(this).data('id');
                    var result = confirm('Você realmente deseja remover este participante?');
                    if (result) {
                        $.ajax({
                            url: 'processa/remove_participant.php',
                            type: 'POST',
                            data: {
                                id: participantId
                            },
                            success: function(response) {
                                if (response === 'success') {
                                    alert('Participante removido com sucesso.');
                                    location.reload();
                                } else {
                                    alert('Erro ao remover o participante.');
                                }
                            }
                        });
                    }
                });
            });

            $(document).ready(function() {
                $('.remove-acesso').on('click', function(e) {
                    e.preventDefault();
                    var acessoId = $(this).data('id');
                    var result = confirm('Você realmente deseja remover este usuário?');
                    if (result) {
                        $.ajax({
                            url: 'processa/remove_acesso_usuario.php',
                            type: 'POST',
                            data: {
                                id: acessoId
                            },
                            success: function(response) {
                                if (response === 'success') {
                                    alert('Usuário removido com sucesso.');
                                    location.reload();
                                } else {
                                    alert('Erro ao remover o usuário.');
                                }
                            }
                        });
                    }
                });
            });
        </script>

<?php
    } else {
        require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
    }
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}

require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>