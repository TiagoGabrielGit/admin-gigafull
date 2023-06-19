<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao.php";

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$tipo = filter_input(INPUT_GET, 'tipo');

require "sql_view.php";

$tabela = "sql_credenciais_portal";
$resultado = mysqli_query($mysqli, $$tabela);
$row = mysqli_fetch_assoc($resultado);

if ($row['cred_priv'] == 1) {
    $checkPublico = "checked";
} else {
    $checkPublico = "";
}

if ($row['cred_priv'] == 2) {
    $checkEquipe = "checked";
    $aplicaButton = "<div class='col-4' style='text-align: left;'>
        <a onclick='dadosCredencial(" . $row['cred_id'] . ")' data-bs-toggle='modal' data-bs-target='#modalConfigPermissoes'><input type='button' class='btn btn-outline-dark btn-sm' value='Configurar permissões'></input></a>
    </div>";
} else {
    $checkEquipe = "";
    $aplicaButton = "";
}

if ($row['cred_priv'] == 3) {
    $checkSomEu = "checked";
} else {
    $checkSomEu = "";
} ?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['cred_descricao']; ?></h5>

                        <form id="editCredenciais" method="POST" class="row g-3">

                            <!-- APENSAS PARA PASSAR ID PARA O SQL -->
                            <input hidden name="usuarioCriador" type="text" class="form-control" id="usuarioCriador" value="<?= $_SESSION['id']; ?>">
                            <input hidden name="id" type="text" class="form-control" id="id" value="<?= $row['cred_id']; ?>">
                            <input hidden name="IDTipo" type="text" class="form-control" id="IDTipo" value="<?= $row['cred_tipo'];  ?>">
                            <!-- FIM -->

                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-8">
                                        <label for="editEmpresa" class="form-label">Empresa</label>
                                        <input disabled name="editEmpresa" type="text" class="form-control" id="editEmpresa" value="<?= $row['emp_fantasia'];  ?>">
                                    </div>
                                </div>

                                <div class="col-4">
                                    <label for="editDescricao" class="form-label">Descrição</label>
                                    <input name="editDescricao" type="text" class="form-control" id="editDescricao" value="<?= $row['cred_descricao']; ?>">
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <label for="editPagina" class="form-label">Página de Acesso</label>
                                        <input name="editPagina" type="text" class="form-control" id="editPagina" value="<?= $row['cred_portal']; ?>">
                                    </div>

                                    <div class="col-4">
                                        <label for="editUsuario" class="form-label">Usuário</label>
                                        <input name="editUsuario" type="text" class="form-control" id="editUsuario" value="<?= $row['cred_usuario']; ?>">
                                    </div>

                                    <div class="col-4">
                                        <label for="editSenha" class="form-label">Senha</label>
                                        <input name="editSenha" type="text" class="form-control" id="editSenha" value="<?= $row['cred_senha']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="col-12">
                                    <label for="editPrivacidade" class="form-label">Privacidade</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="editPrivacidade" id="editPrivacidade" value="1" <?= $checkPublico ?>>
                                        <label class="form-check-label" for="editPrivacidade" value="1">Público</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="editPrivacidade" id="editPrivacidade" value="2" <?= $checkEquipe ?>>
                                        <label class="form-check-label" for="editPrivacidade" value="2">Privado</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="editPrivacidade" id="editPrivacidade" value="3" <?= $checkSomEu ?>>
                                        <label class="form-check-label" for="editPrivacidade" value="3">Somente criador</label>
                                    </div>
                                    <?= $aplicaButton ?>
                                </div>

                                <div class="col-12">
                                    <label for="nomeUsuarioCriador" class="form-label">Usuário Criador</label>
                                    <input name="nomeUsuarioCriador" type="text" class="form-control" id="nomeUsuarioCriador" value="<?= $row['nomeCriador']; ?>" disabled>
                                </div>
                            </div>

                            <hr class="sidebar-divider">

                            <div class="col-12">
                                <label for="anotacaoPortal" class="form-label">Anotações</label>
                                <textarea id="anotacaoPortal" name="anotacaoPortal" class="form-control" maxlength="10000" rows="4"><?= $row['anotacaoEmail'] ?></textarea>
                            </div>

                            <hr class="sidebar-divider">

                            <div class="col-4"></div>

                            <div class="col-4" style="text-align: center;">
                                <span id="msgEditar"></span>
                                <!-- <div class="text-center"> -->
                                <input id="btnSalvarEdit" name="btnSalvarEdit" type="button" value="Salvar" class="btn btn-danger"></input>
                                <a href="/telecom/credentials/index.php"><input type="button" class="btn btn-secondary" value="Voltar"></input></a>
                            </div>

                            <div class="col-4" style="text-align: right;">
                                <a onclick="return confirm('Tem certeza que deseja deletar este registro?')" href="processa/delete.php?id=<?= $id ?>&tipo=<?= $row['cred_tipo']; ?>"><input type="button" class="btn btn-warning" value="Excluir permanente"></input></a>

                            </div>
                        </form><!-- Vertical Form -->

                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->

<?php
require "includes/modal.php";
require "includes/scripts.php";
require "../../../includes/footer.php";
?>