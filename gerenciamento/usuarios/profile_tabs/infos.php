<div class="col-lg-12">

    <div class="row">
        <div class="col-lg-8">
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
            <br>
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
        </div>


        <div class="col-lg-4">
            <?php
            if ($campos['tipoUsuario'] == "1") { ?>
                <form action="processa/profile_notificacao.php" method="POST">
                    <div class="col-12">
                        <input id="idUsuario" name="idUsuario" readonly value="<?= $usuarioID ?>" hidden></input>

                        <label for="notificaEmail" class="form-label">Notificação E-mail</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="notificaEmail" id="notificaEmailAtivo" value="1" <?= $checkNotifEmail1 ?>>
                            <label class="form-check-label" for="notificaEmailAtivo">
                                Ativo
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="notificaEmail" id="notificaEmailInativo" value="0" <?= $checkNotifEmail0 ?>>
                            <label class="form-check-label" for="notificaEmailInativo">
                                Inativo
                            </label>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-6">
                            <label for="notificaTelegram" class="form-label">Notificação Telegram</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="notificaTelegram" id="notificaTelegramAtivo" value="1" <?= $checkNotificaTelegram1 ?>>
                                <label class="form-check-label" for="notificaTelegramAtivo">
                                    Ativo
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="notificaTelegram" id="notificaTelegramInativo" value="0" <?= $checkNotificaTelegram0 ?>>
                                <label class="form-check-label" for="notificaTelegramInativo">
                                    Inativo
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="chatIdTelegram" class="form-label">Chat ID</label>
                            <input type="number" class="form-control" id="chatIdTelegram" name="chatIdTelegram" value="<?= $campos['chatIdTelegram'] ?>"></input>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button class="btn btn-sm btn-success" type="submit">Aplicar</button>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>