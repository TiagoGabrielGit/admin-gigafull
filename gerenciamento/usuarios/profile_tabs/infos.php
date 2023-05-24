<div class="col-lg-12">
    <div class="row">
        <div class="col-6">
            <label class="form-label">Nome</label>
            <input type="text" class="form-control" value="<?= $campos['nome']; ?>" disabled>
        </div>

        <div class="col-6">
            <label class="form-label">Empresa</label>
            <input type="text" class="form-control" value="<?= $campos['empresa']; ?>" disabled>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <label class="form-label">Usuário</label>
            <input type="text" class="form-control" value="<?= $campos['usuario']; ?>" disabled>
        </div>
        <div class="col-4">
            <label class="form-label">Perfil</label>
            <input type="text" class="form-control" value="<?= $campos['perfil']; ?>" disabled>
        </div>
    </div>

    <hr class="sidebar-divider">
    <div class="col-lg-12">
        <span><b>Alterar senha</b></span>
    </div>

    <form method="POST" action="/gerenciamento/usuarios/processa/alterarSenha.php" class="needs-validation" novalidate>
        <div class="row">
            <input type="text" name="id" class="form-control" id="id" value="<?= $campos['idUsuario'] ?>" hidden>
            <input type="text" name="usuario" class="form-control" id="usuario" value="<?= $campos['nome'] ?>" hidden>

            <div class="col-4">
                <label for="senha" class="form-label">Digite a senha nova</label>
                <input type="password" name="senha" class="form-control" id="senha" required>
                <div class="invalid-feedback">Digite uma senha</div>
            </div>

            <div class="col-4">
                <label for="senhaRepeat" class="form-label">Repita a senha</label>
                <input type="password" name="senhaRepeat" class="form-control" id="senhaRepeat" required>
                <div class="invalid-feedback">Digite uma senha</div>
            </div>
        </div>
        <br>
        <div class="col-3">
            <button class="btn btn-danger w-100" type="submit">Alterar Senha</button>
        </div>
    </form>
</div>