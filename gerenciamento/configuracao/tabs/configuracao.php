<div class="row">
    <div class="col-lg-12">

        <div class="ml-auto">
            <button type="button" class="btn btn-info rounded-circle position-absolute top-0 end-0 mt-3 me-5" data-bs-toggle="modal" data-bs-target="#modalAdicionarServidor">
                <i class="bi bi-plus"></i>
            </button>
        </div>
        <div class="card">

            <div class="card-body">
                <!--<h5 class="card-title">Dados da Conta</h5>-->
                <div class="row">
                    <div class="col-md-4">
                        <label for="select-servidores" class="form-label">Selecione o Servidor</label>
                        <select id="select-servidores" class="form-select">
                            <option disabled selected>Selecione</option>
                            <?php foreach ($resultados as $row) : ?>
                                <option value="<?= $row['id']; ?>"><?= $row['server']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <hr class="sidebar-divider">
                <form id="formEditServidor">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Servidor*</label>
                        <div class="col-sm-6">
                            <input type="text" name="servidor" class="form-control">
                        </div>

                        <label class="col-sm-1 col-form-label">Status</label>
                        <div class="col-sm-2">
                            <select name="status" class="form-select" aria-label="Default select example">
                                <option selected="" disabled>Selecione</option>
                                <option value="1">Ativo</option>
                                <option value="0">Inativo</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">Nome do Remetente*</label>
                        <div class="col-sm-9">
                            <input type="text" name="nome_remetente" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Conta de Envio*</label>
                        <div class="col-sm-9">
                            <input type="email" name="conta_envio" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Senha da Conta de Envio*</label>
                        <div class="col-sm-9">
                            <input type="password" name="senha_conta_envio" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-3 col-form-label">Servidor SMTP*</label>
                        <div class="col-sm-9">
                            <input type="text" name="servidor_smtp" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputNumber" class="col-sm-3 col-form-label">Porta SMTP*</label>
                        <div class="col-sm-3">
                            <input type="number" name="porta_smtp" class="form-control">
                        </div>

                        <label class="col-sm-2 col-form-label">Segurança SMTP*</label>
                        <div class="col-sm-3">
                            <select name="seguranca_smtp" class="form-select" aria-label="Default select example">
                                <option selected="" disabled>Selecione</option>
                                <option value="ssl">SSL</option>
                            </select>
                        </div>
                    </div>
                    <div class="text-center">
                        <!--<input id="btnEditar" name="btnEditar" type="button" value="Editar Dados" class="btn btn-danger"></input>-->
                        <button data-bs-toggle="modal" data-bs-target="#modalTestarEnvio" type="button" class="btn btn-success">Testar Envio</button>
                    </div>
                </form><!-- End General Form Elements -->
            </div>

        </div>

    </div>
</div>

<div class="modal fade" id="modalAdicionarServidor" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar Servidor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form method="POST" id="formAdicionarServidor">
                    <span id="msgAdicionarServidor"></span>
                    <div class="row mb-3">
                        <label for="adicionarServidor" class="col-sm-4 col-form-label">Servidor*</label>
                        <div class="col-sm-8">
                            <input id="adicionarServidor" name="adicionarServidor" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="adicionarNomeRemetente" class="col-sm-4 col-form-label">Nome do Remetente*</label>
                        <div class="col-sm-8">
                            <input id="adicionarNomeRemetente" name="adicionarNomeRemetente" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="adicionarContaEnvio" class="col-sm-4 col-form-label">Conta de Envio*</label>
                        <div class="col-sm-8">
                            <input id="adicionarContaEnvio" name="adicionarContaEnvio" type="email" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="adicionarSenha" class="col-sm-4 col-form-label">Senha da Conta de Envio*</label>
                        <div class="col-sm-8">
                            <input id="adicionarSenha" name="adicionarSenha" type="password" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="adicionarServidorSMTP" class="col-sm-4 col-form-label">Servidor SMTP*</label>
                        <div class="col-sm-8">
                            <input id="adicionarServidorSMTP" name="adicionarServidorSMTP" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="adicionarPortaSMTP" class="col-sm-4 col-form-label">Porta SMTP*</label>
                        <div class="col-sm-8">
                            <input id="adicionarPortaSMTP" name="adicionarPortaSMTP" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label">Segurança SMTP*</label>
                        <div class="col-sm-8">
                            <select id="adicionarSegurancaSMTP" name="adicionarSegurancaSMTP" class="form-select" aria-label="Default select example" required>
                                <option selected value="ssl">SSL</option>
                            </select>
                        </div>
                    </div>


                    <div class="text-center">

                        <input id="btnSalvar" name="btnSalvar" type="button" value="Salvar Dados" class="btn btn-danger"></input>

                    </div>
                </form><!-- End General Form Elements -->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTestarEnvio" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Teste de envio de e-mail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form method="POST" id="formTestarEnvio">
                    <span id="msgTestarEnvio"></span>

                    <div class="row mb-3">
                        <label for="serverID" class="col-sm-2 col-form-label">Servidor*</label>
                        <div class="col-sm-1">
                            <input disabled id="serverID" name="serverID" type="text" class="form-control">
                            <input readonly hidden id="servidorID" name="servidorID" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="destinatario" class="col-sm-2 col-form-label">Destinatário*</label>
                        <div class="col-sm-6">
                            <input id="destinatario" name="destinatario" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="assunto" class="col-sm-2 col-form-label">Assunto*</label>
                        <div class="col-sm-8">
                            <input id="assunto" name="assunto" type="text" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="mensagem" class="col-sm-2 col-form-label">Mensagem*</label>
                        <div class="col-sm-8">
                            <textarea id="mensagem" name="mensagem" rows="8" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="text-center">
                        <input id="btnTestarEnvio" name="btnTestarEnvio" type="button" value="Enviar" class="btn btn-info"></input>
                    </div>
                </form><!-- End General Form Elements -->
            </div>
        </div>
    </div>
</div>