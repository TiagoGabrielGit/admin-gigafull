<script>
    function capturaDadosLogin(id, usuario, nome) {
        document.querySelector("#id").value = id;
        document.querySelector("#id_disable").value = id;
        document.querySelector("#usuario").value = usuario;
        document.querySelector("#usuario_disable").value = usuario;
        document.querySelector("#nomeUsuario").value = nome;
    }
</script>

<div class=" modal fade" id="basicModalSenha" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alterar senha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <!-- Vertical Form -->
                    <form method="POST" action="/gerenciamento/usuarios/processa/alterarSenha.php" class="row g-3 needs-validation" novalidate>

                        <div class="col-12">
                            <label for="nomeUsuario" class="form-label">Nome </label>
                            <input type="Text" name="nomeUsuario" class="form-control" id="nomeUsuario" disabled>

                        </div>

                        <div class="col-3">
                            <label for="id" class="form-label">ID</label>
                            <input type="text" name="id_disable" class="form-control" id="id_disable" disabled>
                            <input type="text" name="id" class="form-control" id="id" hidden>
                        </div>

                        <div class="col-9">
                            <label for="usuario" class="form-label">Usuário </label>
                            <input type="Text" name="usuario_disable" class="form-control" id="usuario_disable" disabled>
                            <input type="text" name="usuario" class="form-control" id="usuario" hidden>
                        </div>

                        <div class="col-12">
                            <label for="senha" class="form-label">Digite a senha nova</label>
                            <input type="password" name="senha" class="form-control" id="senha" required>
                            <div class="invalid-feedback">Digite a senha</div>
                        </div>

                        <div class="col-12">
                            <label for="senhaRepeat" class="form-label">Repita a senha</label>
                            <input type="password" name="senhaRepeat" class="form-control" id="senhaRepeat" required>
                            <div class="invalid-feedback">Digite a senha</div>
                        </div>

                        <div class="col-4"></div>
                        <div class="col-4">
                            <button class="btn btn-danger" type="submit">Alterar Senha</button>
                        </div>
                        <div class="col-4"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>