<script>
    function AddSenhaVM(id, nomevm, idEmpresa) {
        document.querySelector("#idVMModalSenha1").value = id;
        document.querySelector("#idVMModalSenha2").value = id;
        document.querySelector("#nomeVM").value = nomevm;
        document.querySelector("#idEmpresa1").value = idEmpresa;
    }
</script>

<div class="modal fade" id="AddSenhaVM" tabindex="-1">
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
                                <form id="cadastraSenhaVM" method="POST" class="row g-3 needs-validation">

                                    <span id="msg"></span>

                                    <div class="col-3">
                                        <label for="idVMModalSenha1" class="form-label">VM ID</label>
                                        <input type="Text" name="idVMModalSenha1" class="form-control" id="idVMModalSenha1" disabled>
                                    </div>

                                    <div class="col-6">
                                        <label for="nomeVM" class="form-label">VM</label>
                                        <input type="Text" name="nomeVM" class="form-control" id="nomeVM" disabled>
                                    </div>

                                    <input type="Text" name="idVMModalSenha2" class="form-control" id="idVMModalSenha2" hidden>
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
                                        <label for="vmDescricao" class="form-label">Descrição</label>
                                        <input name="vmDescricao" type="text" class="form-control" id="vmDescricao">
                                    </div>

                                    <div class="col-4" style="display: inline-block;"> </div>

                                    <div class="col-4" style="display: inline-block;">
                                        <label for="vmUsuario" class="form-label">Usuário</label>
                                        <input name="vmUsuario" type="text" class="form-control" id="vmUsuario">
                                    </div>

                                    <div class="col-4" style="display: inline-block;">
                                        <label for="vmSenha" class="form-label">Senha</label>
                                        <input name="vmSenha" type="text" class="form-control" id="vmSenha">
                                    </div>

                                    <hr class="sidebar-divider">

                                    <div class="text-center">
                                        <input id="btnSalvar" name="btnSalvar" type="button" value="Salvar" class="btn btn-danger"></input>
                                        <a href="/telecom/vms/index.php"> <input type="button" value="Voltar" class="btn btn-secondary"></input></a>
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