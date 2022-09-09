<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['vm_hostname']; ?></h5>

                        <form id="editCredenciais" method="POST" class="row g-3">

                            <!-- APENSAS PARA PASSAR ID PARA O SQL -->
                            <input hidden name="usuarioCriador" type="text" class="form-control" id="usuarioCriador" value="<?= $_SESSION['id']; ?>">
                            <input hidden name="id" type="text" class="form-control" id="id" value="<?= $row['cred_id']; ?>">
                            <input hidden name="IDEmpresa" type="text" class="form-control" id="IDEmpresa" value="<?= $row['emp_id'];  ?>">
                            <input hidden name="IDTipo" type="text" class="form-control" id="IDTipo" value="<?= $row['cred_tipo'];  ?>">
                            <!-- FIM -->

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

                            <div class="col-4">
                                <label class="form-label">VM</label>
                                <input disabled type="text" class="form-control"  value="<?= $row['vm_hostname']; ?>">
                            </div>

                            <div class="col-3" style="display: inline-block;">
                                <label class="form-label">Endereço IP</label>
                                <input disabled type="text" class="form-control" value="<?= $row['cred_ip']; ?>">
                            </div>

                            <div class="col-2"> </div>

                            <div class="col-3"> 
                                <label for="nomeUsuarioCriador" class="form-label">Usuário Criador</label>
                                <input name="nomeUsuarioCriador" type="text" class="form-control" id="nomeUsuarioCriador" value="<?= $row['nomeCriador']; ?>" disabled>
                            </div>
 
                            <hr class="sidebar-divider">

                            <div class="col-6" style="display: inline-block;">
                                <label for="editDescricao" class="form-label">Descrição</label>
                                <input name="editDescricao" type="text" class="form-control" id="editDescricao" value="<?= $row['cred_descricao']; ?>">
                            </div>

                            <div class="col-4" style="display: inline-block;"> </div>

                            <div class="col-4" style="display: inline-block;">
                                <label for="editUsuario" class="form-label">Usuário</label>
                                <input name="editUsuario" type="text" class="form-control" id="editUsuario" value="<?= $row['cred_usuario']; ?>">
                            </div>

                            <div class="col-4" style="display: inline-block;">
                                <label for="editSenha" class="form-label">Senha</label>
                                <input name="editSenha" type="text" class="form-control" id="editSenha" value="<?= $row['cred_senha']; ?>">
                            </div>


                            <hr class="sidebar-divider">

                            <div class="col-4"></div>

                            <div class="col-4" style="text-align: center;">
                                <!-- <div class="text-center"> -->
                                <input id="btnSalvarEdit" name="btnSalvarEdit" type="button" value="Salvar" class="btn btn-danger"></input>
                                <a href="/telecom/vms/view.php?id=<?=$row['vm_id'];?>"><input type="button" class="btn btn-secondary" value="Voltar"></input></a>
                            </div>
                        </form><!-- Vertical Form -->

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