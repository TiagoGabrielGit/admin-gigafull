<script>
    function AddSenhaEquipamento(id, nomeEq, idEmpresa) {
        document.querySelector("#idSenha1").value = id;
        document.querySelector("#idSenha2").value = id;
        document.querySelector("#nomeEq").value = nomeEq;
        document.querySelector("#idEmpresa1").value = idEmpresa;
    }
</script>

<div class="modal fade" id="AddSenhaEquipamento" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar senha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <form id="cadastraSenhaEquipamento" method="POST" class="row g-3 needs-validation">

                                    <span id="msgAlertCad"></span>

                                    <div class="col-3">
                                        <label for="idSenha1" class="form-label">Equipamento ID</label>
                                        <input type="Text" name="idSenha1" class="form-control" id="idSenha1" disabled>
                                    </div>

                                    <div class="col-6">
                                        <label for="nomeEq" class="form-label">Equipamento</label>
                                        <input type="Text" name="nomeEq" class="form-control" id="nomeEq" disabled>
                                    </div>

                                    <input type="Text" name="idSenha2" class="form-control" id="idSenha2" hidden>
                                    <input type="Text" name="idEmpresa1" class="form-control" id="idEmpresa1" hidden>


                                    <div class="col-3">
                                        <label for="cadastroPrivacidade" class="form-label">Privacidade*</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cadastroPrivacidade" id="cadastroPrivacidade" value="1" checked="">
                                            <label class="form-check-label" for="cadastroPrivacidade" value="1">Público</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cadastroPrivacidade" id="cadastroPrivacidade" value="2">
                                            <label class="form-check-label" for="cadastroPrivacidade" value="2">Privado</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cadastroPrivacidade" id="cadastroPrivacidade" value="3">
                                            <label class="form-check-label" for="cadastroPrivacidade" value="3">Somente eu</label>
                                        </div>

                                    </div>

                                    <div class="col-6" style="display: inline-block;">
                                        <label for="equipamentoDescricao" class="form-label">Descrição</label>
                                        <input name="equipamentoDescricao" type="text" class="form-control" id="equipamentoDescricao">
                                    </div>

                                    <div class="col-4" style="display: inline-block;"> </div>

                                    <div class="col-4" style="display: inline-block;">
                                        <label for="equipamentoUsuario" class="form-label">Usuário</label>
                                        <input name="equipamentoUsuario" type="text" class="form-control" id="equipamentoUsuario">
                                    </div>

                                    <div class="col-4" style="display: inline-block;">
                                        <label for="equipamentoSenha" class="form-label">Senha</label>
                                        <input name="equipamentoSenha" type="text" class="form-control" id="equipamentoSenha">
                                    </div>

                                    <hr class="sidebar-divider">

                                    <div class="text-center">
                                        <input id="btnSalvar" name="btnSalvar" type="button" value="Salvar" class="btn btn-danger"></input>
                                        <a href="/telecom/credentials/index.php"> <input type="button" value="Voltar" class="btn btn-secondary"></input></a>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  