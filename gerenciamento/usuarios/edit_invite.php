<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$id = $_GET['id'];

$sql =
    "SELECT
    ui.id as 'id',
    ui.token as 'token',
    e.fantasia as 'empresa',
    CASE
    WHEN ui.tipo_acesso = 1 THEN 'Smart'
    WHEN ui.tipo_acesso = 2 THEN 'Client'
    WHEN ui.tipo_acesso = 3 THEN 'Tenant'
    END as tipo_usuario,
    CASE
    WHEN ui.permissao_chamado = 1 THEN 'Permite abrir apenas chamados liberados para a empresa'
    WHEN ui.permissao_chamado = 2 THEN 'Permite abrir apenas chamados liberados para a equipe'
    WHEN ui.permissao_chamado = 3 THEN 'Permite abrir chamados liberados para empresa e para a equipe'
    END as 'permissao_chamado',
    p.perfil as 'perfil',
    ui.active as 'active',
    ui.validade_invite as 'validade_invite'
    FROM
    usuario_invite as ui
    LEFT JOIN
    empresas as e
    ON
    e.id = ui.empresa_id
    LEFT JOIN
    perfil as p
    ON
    p.id = ui.perfil_id
    WHERE
    ui.id = :id";

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $token = $result['token'];
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}

$sql_invites =
    "SELECT
    uia.nomePessoa as 'nomePessoa',
    uia.cpf as 'cpf',
    uia.email as 'email',
    uia.id as 'id',
    CASE
    WHEN uia.status = 1 THEN 'Pendente'
    WHEN uia.status = 2 THEN 'Aprovado'
    WHEN uia.status = 3 THEN 'Recusado'
    END as 'status',
    uia.telefone as 'telefone',
    uia.celular as 'celular',
    uia.cep as 'cep',
    uia.ibgecode as 'ibgecode',
    uia.logradouro as 'logradouro',
    uia.bairro as 'bairro',
    uia.cidade as 'cidade',
    uia.estado as 'estado',
    uia.numero as 'numero',
    uia.complemento as 'complemento'
    FROM
    usuario_invite_accept as uia
    WHERE
    uia.token = :token";

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare($sql_invites);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    $invites = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $pdo = null;
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>

<main id="main" class="main">

    <div class="pagetitle">

        <h1>Invites</h1>

    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <h5 class="card-title">Invite <?= $id ?> </h5>
                            </div>
                            <div class="col-lg-4">
                                <a href="invite_gerencia.php">
                                    <button style="margin-top: 15px" type="button" class="btn btn-danger">
                                        Ver Invites
                                    </button>
                                </a>

                                <?php
                                if (strtotime($result['validade_invite']) > time() && $result['active'] == 1) { ?>
                                    <a href="#" id="copiarURL">
                                        <button style="margin-top: 15px" type="button" class="btn btn-success">
                                            Copiar URL
                                        </button>
                                    </a>
                                <?php  }
                                ?>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="InviteEmpresa" class="form-label">Empresa</label>
                                        <input readonly type="text" class="form-control" value="<?= $result['empresa'] ?>" name="InviteEmpresa" id="InviteEmpresa">
                                    </div>
                                    <div class="col-4">
                                        <label for="inviteToken" class="form-label">Token</label>
                                        <input readonly value="<?= $result['token'] ?>" type="text" class="form-control" name="inviteToken" id="inviteToken">
                                    </div>
                                </div>

                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="inviteTipoAcesso" class="form-label">Tipo de Acesso</label>
                                        <input readonly value="<?= $result['tipo_usuario'] ?>" type="text" class="form-control" id="inviteTipoAcesso" name="inviteTipoAcesso">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="invitePerfil" class="form-label">Perfil</label>
                                        <input readonly value="<?= $result['perfil'] ?>" type="text" class="form-control" id="invitePerfil" name="invitePerfil">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-10">
                                        <label for="invitePermissaoChamado" class="form-label">Permissão de Abertura Chamado</label>
                                        <input readonly value="<?= $result['permissao_chamado'] ?>" type="text" class="form-control" id="invitePermissaoChamado" name="invitePermissaoChamado">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <br>
                                <form id="statusForm" action="processa/status_invite.php" method="POST">

                                    <input id="idInvite" name="idInvite" readonly value="<?= $id ?>" hidden></input>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="statusAtivo" value="ativo" <?= $result['active'] ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="statusAtivo">
                                                Ativo
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="statusInativo" value="inativo" <?= !$result['active'] ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="statusInativo">
                                                Inativo
                                            </label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cadastros realizados através do invite</h5>
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">CPF</th>
                                    <th scope="col">Aprovar / Recusar</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($invites as $invite) : ?>
                                    <tr>
                                        <th scope="row"><?= $invite['id'] ?></th>

                                        <td>
                                            <?= $invite['nomePessoa'] ?>
                                            <a class="bi bi-info-circle text-primary" role="button" data-bs-toggle="modal" data-bs-target="#modalInviteUser<?= $invite['id'] ?>"></a>
                                        </td>
                                        <td><?= $invite['email'] ?></td>
                                        <td><?= $invite['cpf'] ?></td>
                                        <td>
                                            <?php
                                            if ($invite['status'] == 'Pendente') { ?>
                                                <a href="processa/aprova_user_invite.php?id=<?= $invite['id'] ?>"><button type="button" class="btn btn-success">Aprovar</button></a>
                                                <a href="processa/recusa_user_invite.php?id=<?= $invite['id'] ?>"><button type="button" class="btn btn-danger">Recusar</button></a>
                                            <?php }
                                            ?>

                                        </td>
                                        <td><?= $invite['status'] ?></td>
                                    </tr>

                                    <div class=" modal fade" id="modalInviteUser<?= $invite['id'] ?>" tabindex="-1">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Solicitação de acesso</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <label for="inviteNome" class="form-label">Nome </label>
                                                                <input value="<?= $invite['nomePessoa'] ?>" type="Text" name="inviteNome" class="form-control" id="inviteNome" readonly>
                                                            </div>

                                                            <div class="col-5">
                                                                <label for="inviteEmail" class="form-label">E-mail </label>
                                                                <input value="<?= $invite['email'] ?>" type="Text" name="inviteEmail" class="form-control" id="inviteEmail" readonly>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label for="inviteCPF" class="form-label">CPF</label>
                                                                <input value="<?= $invite['cpf'] ?>" name="inviteCPF" type="text" class="form-control" id="inviteCPF" readonly>
                                                            </div>


                                                            <div class="col-4">
                                                                <label for="inviteTelefone" class="form-label">Telefone</label>
                                                                <input value="<?= $invite['telefone'] ?>" name="inviteTelefone" type="text" class="form-control" id="inviteTelefone" readonly>
                                                            </div>

                                                            <div class="col-4">
                                                                <label for="inviteCelular" class="form-label">Celular</label>
                                                                <input value="<?= $invite['celular'] ?>" name="inviteCelular" type="text" class="form-control" id="inviteCelular" readonly>
                                                            </div>
                                                        </div>

                                                        <hr class="sidebar-divider">

                                                        <div class="row">
                                                            <div class="col-4">
                                                                <label for="inviteCEP" class="form-label">CEP</label>
                                                                <input value="<?= $invite['cep'] ?>" name="inviteCEP" type="text" class="form-control" id="inviteCEP" readonly>
                                                            </div>

                                                            <div class="col-3">
                                                                <label for="inviteIbgecode" class="form-label">Código IBGE</label>
                                                                <input value="<?= $invite['ibgecode'] ?>" name="inviteIbgecode" type="text" class="form-control" id="inviteIbgecode" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-5">
                                                                <label for="inviteLogradouro" class="form-label">Logradouro</label>
                                                                <input value="<?= $invite['logradouro'] ?>" name="inviteLogradouro" type="text" class="form-control" id="inviteLogradouro" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label for="inviteBairro" class="form-label">Bairro</label>
                                                                <input value="<?= $invite['bairro'] ?>" name="inviteBairro" type="text" class="form-control" id="inviteBairro" readonly>
                                                            </div>

                                                            <div class="col-3">
                                                                <label for="inviteCidade" class="form-label">Cidade</label>
                                                                <input value="<?= $invite['cidade'] ?>" name="inviteCidade" type="text" class="form-control" id="inviteCidade" readonly>
                                                            </div>

                                                            <div class="col-3">
                                                                <label for="inviteEstado" class="form-label">Estado</label>
                                                                <input value="<?= $invite['estado'] ?>" name="inviteEstado" type="text" class="form-control" id="inviteEstado" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-2">
                                                                <label for="inviteNumero" class="form-label">Número</label>
                                                                <input value="<?= $invite['numero'] ?>" name="inviteNumero" type="number" class="form-control" id="inviteNumero" readonly>
                                                            </div>

                                                            <div class="col-3">
                                                                <label for="inviteComplemento" class="form-label">Complemento</label>
                                                                <input value="<?= $invite['complemento'] ?>" name="inviteComplemento" type="text" class="form-control" id="inviteComplemento" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->
<?php
require "js_edit_invite.php";
require "../../includes/footer.php";
?>