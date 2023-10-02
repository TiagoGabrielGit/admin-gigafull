<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['cred_descricao']; ?></h5>

                        <form action="processa/editar.php" method="POST" class="row g-3">

                            <input hidden name="id" type="text" class="form-control" id="id" value="<?= $row['cred_id']; ?>">

                            <span id="msg"></span>

                            <div class="col-4">
                                <label for="editEmpresa" class="form-label">Empresa</label>
                                <input disabled name="editEmpresa" type="text" class="form-control" id="editEmpresa" value="<?= $row['emp_fantasia'];  ?>">
                            </div>

                            <div class="col-3">
                                <label for="editTipo" class="form-label">Tipo</label>
                                <input disabled name="editTipo" type="text" class="form-control" id="editTipo" value="<?= $row['cred_tipo'];  ?>">
                            </div>

                            <div class="col-2"></div>

                            <div class="col-3">
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

                            <div class="col-9"> </div>

                            <div class="col-3">
                                <label for="nomeUsuarioCriador" class="form-label">Usuário Criador</label>
                                <input name="nomeUsuarioCriador" type="text" class="form-control" id="nomeUsuarioCriador" value="<?= $row['nomeCriador']; ?>" disabled>
                            </div>


                            <hr class="sidebar-divider">

                            <div class="col-6" style="display: inline-block;">
                                <label for="editDescricao" class="form-label">Descrição</label>
                                <input name="editDescricao" type="text" class="form-control" id="editDescricao" value="<?= $row['cred_descricao']; ?>">
                            </div>

                            <div class="col-4" style="display: inline-block;">
                                <label for="editWebmail" class="form-label">Webmail</label>
                                <input name="editWebmail" type="text" class="form-control" id="editWebmail" value="<?= $row['cred_webmail']; ?>">
                            </div>
                            <div class="col-2" style="display: inline-block;"> </div>

                            <div class="col-4" style="display: inline-block;">
                                <label for="editUsuario" class="form-label">Usuário</label>
                                <input name="editUsuario" type="text" class="form-control" id="editUsuario" value="<?= $row['cred_usuario']; ?>">
                            </div>

                            <div class="col-4" style="display: inline-block;">
                                <label for="editSenha" class="form-label">Senha</label>
                                <input name="editSenha" type="text" class="form-control" id="editSenha" value="<?= $row['cred_senha']; ?>">
                            </div>

                            <hr class="sidebar-divider">

                            <div class="col-12">
                                <label for="anotacaoEmail" class="form-label">Anotações</label>
                                <textarea id="anotacaoEmail" name="anotacaoEmail" class="form-control" maxlength="10000" rows="4"><?= $row['anotacaoEmail'] ?></textarea>
                            </div>

                            <hr class="sidebar-divider">

                            <div class="col-4"></div>

                            <div class="col-4" style="text-align: center;">
                                <button class="btn btn-sm btn-danger" type="submit">Salvar Alterações</button>
                                <a href="/telecom/credentials/index.php"><input type="button" class="btn btn-sm btn-secondary" value="Voltar"></input></a>
                            </div>

                            <div class="col-4" style="text-align: right;">
                                <a onclick="return confirm('Tem certeza que deseja deletar este registro?')" href="processa/delete.php?id=<?= $id ?>&tipo=<?= $row['cred_tipo']; ?>"><input type="button" class="btn btn-warning" value="Excluir permanente"></input></a>

                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->

<?php
require "modal.php";
require "scripts_permissoes.php";
?>