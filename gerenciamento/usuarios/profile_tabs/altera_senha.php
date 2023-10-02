<?php
if (isset($_GET['msgChangeUser'])) {
    if ($_GET['msgChangeUser'] == 700) {
        $msgContent = "Senha alterada com sucesso!";
        $alert = "success";
    } else if ($_GET['msgChangeUser'] == 800) {
        $msgContent = "Senha atual incorreta. Tente novamente.";
        $alert = "danger";
    } else if (($_GET['msgChangeUser'] == 900)) {
        $msgContent = "As senhas não coincidem. Tente novamente.";
        $alert = "danger";
    } ?>

    <div class="alert alert-<?= $alert ?> alert-dismissible fade show" role="alert">
        <b><?= $msgContent ?></b>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">

            <form action="processa/alterar_senha.php" method="POST">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label" for="senha_atual">Senha Atual</label>
                        <input class="form-control" type="password" name="senha_atual" id="senha_atual" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label class="form-label" for="nova_senha">Nova Senha:</label>
                        <input class="form-control" type="password" name="nova_senha" id="nova_senha" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label" for="confirmar_senha">Confirmar Nova Senha:</label>
                        <input class="form-control" type="password" name="confirmar_senha" id="confirmar_senha" required>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="text-center">
                        <button class="btn btn-sm btn-danger" type="submit">Trocar Senha</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>