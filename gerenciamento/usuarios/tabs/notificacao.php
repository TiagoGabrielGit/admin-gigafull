<h5 class="card-title">Usuário: <?= $campos['nome']; ?></h5>
<form method="POST" action="processa/edita_user_notificacao.php">


    <input type="Text" name="notificacaoIdUser" id="notificacaoIdUser" value="<?= $campos['id']; ?>" readonly hidden>

    <div class="col-lg-12">
        <hr class="sidebar-divider">
        <div class="row">
            <div class="col-4">
                <label for="notificaEmail" class="form-label">Notificação por e-mail</label>
                <select name="notificaEmail" id="notificaEmail" class="form-select" required>
                    <?php
                    if ($campos['notify_email'] == "Ativado") { ?>
                        <option selected value="1">Ativado</option>
                        <option value="0">Desativado</option>
                    <?php } else if ($campos['notify_email'] == "Inativado") { ?>
                        <option value="1">Ativado</option>
                        <option selected value="0">Desativado</option>
                    <?php } else { ?>
                        <option selected disabled value="">Selecione uma opção</option>
                        <option value="1">Ativado</option>
                        <option value="0">Desativado</option>
                    <?php }
                    ?>
                </select>
            </div>

            <div class="col-4">
                <label for="notificaTelegram" class="form-label">Notificação por Telegram</label>
                <select name="notificaTelegram" id="notificaTelegram" class="form-select" required>
                    <?php
                    if ($campos['notify_telegram'] == "Ativado") { ?>
                        <option selected value="1">Ativado</option>
                        <option value="0">Desativado</option>
                    <?php } else if ($campos['notify_telegram'] == "Inativado") { ?>
                        <option value="1">Ativado</option>
                        <option selected value="0">Desativado</option>
                    <?php } else { ?>
                        <option selected disabled value="">Selecione uma opção</option>
                        <option value="1">Ativado</option>
                        <option value="0">Desativado</option>
                    <?php }
                    ?>
                </select>
            </div>

            <div class="col-4">
                <label for="chatID" class="form-label">Chat ID Telegram</label>
                <input class="form-control" id="chatID" name="chatID" value="<?= $campos['chatIdTelegram'] ?>"></input>
            </div>
        </div>
        <br><br>

        <div class="row">
            <div class="col-lg-6">
                <div class="col-10">
                    <label for="notificaAbertura" class="form-label">Notificação abertura de chamados</label>
                    <select name="notificaAbertura" id="notificaAbertura" class="form-select" required>
                        <?php
                        if ($campos['notify_email_abertura'] == 2) { ?>
                            <option selected value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option value="1">Recebe de qualquer chamado aberto</option>
                            <option value="0">Não recebe de nenhum chamado</option>
                        <?php } else if ($campos['notify_email_abertura'] == 1) { ?>
                            <option value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option selected value="1">Recebe de qualquer chamado aberto</option>
                            <option value="0">Não recebe de nenhum chamado</option>
                        <?php } else if ($campos['notify_email_abertura'] == 0) { ?>
                            <option value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option value="1">Recebe de qualquer chamado aberto</option>
                            <option selected value="0">Não recebe de nenhum chamado</option>
                        <?php } else { ?>
                            <option selected disabled value="">Selecione uma opção</option>
                            <option value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option value="1">Recebe de qualquer chamado aberto</option>
                            <option value="0">Não recebe de nenhum chamado</option>
                        <?php }
                        ?>
                    </select>
                </div>
                <br>
                <div class="col-10">
                    <label for="notificaEncaminhamento" class="form-label">Notificação encaminhamento de chamados</label>

                    <select name="notificaEncaminhamento" id="notificaEncaminhamento" class="form-select" required>
                        <?php
                        if ($campos['notify_email_encaminhamento'] == 2) { ?>
                            <option selected value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option value="1">Recebe de qualquer chamado aberto</option>
                            <option value="0">Não recebe de nenhum chamado</option>
                        <?php } else if ($campos['notify_email_encaminhamento'] == 1) { ?>
                            <option value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option selected value="1">Recebe de qualquer chamado</option>
                            <option value="0">Não recebe de nenhum chamado</option>
                        <?php } else if ($campos['notify_email_encaminhamento'] == 0) { ?>
                            <option value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option value="1">Recebe de qualquer chamado</option>
                            <option selected value="0">Não recebe de nenhum chamado</option>
                        <?php } else { ?>
                            <option selected disabled value="">Selecione uma opção</option>
                            <option value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option value="1">Recebe de qualquer chamado</option>
                            <option value="0">Não recebe de nenhum chamado</option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="col-10">
                    <label for="notificaRelatos" class="form-label">Recebe de relatos de chamados</label>
                    <select name="notificaRelatos" id="notificaRelatos" class="form-select" required>
                        <?php
                        if ($campos['notify_email_relatos'] == 2) { ?>
                            <option selected value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option value="1">Recebe de qualquer chamado aberto</option>
                            <option value="0">Não recebe de nenhum chamado</option>
                        <?php } else if ($campos['notify_email_relatos'] == 1) { ?>
                            <option value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option selected value="1">Recebe de qualquer chamado</option>
                            <option value="0">Não recebe de nenhum chamado</option>
                        <?php } else if ($campos['notify_email_relatos'] == 0) { ?>
                            <option value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option value="1">Recebe de qualquer chamado</option>
                            <option selected value="0">Não recebe de nenhum chamado</option>
                        <?php } else { ?>
                            <option selected disabled value="">Selecione uma opção</option>
                            <option value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option value="1">Recebe de qualquer chamado</option>
                            <option value="0">Não recebe de nenhum chamado</option>
                        <?php }
                        ?>
                    </select>
                </div>
                <br>
                <div class="col-10">
                    <label for="notificaApropriacao" class="form-label">Recebe na apropriação de chamados</label>

                    <select name="notificaApropriacao" id="notificaApropriacao" class="form-select" required>
                        <?php
                        if ($campos['notify_email_apropriacao'] == 2) { ?>
                            <option selected value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option value="1">Recebe de qualquer chamado</option>
                            <option value="0">Não recebe de nenhum chamado</option>
                        <?php } else if ($campos['notify_email_apropriacao'] == 1) { ?>
                            <option value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option selected value="1">Recebe de qualquer chamado</option>
                            <option value="0">Não recebe de nenhum chamado</option>
                        <?php } else if ($campos['notify_email_apropriacao'] == 0) { ?>
                            <option value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option value="1">Recebe de qualquer chamado</option>
                            <option selected value="0">Não recebe de nenhum chamado</option>
                        <?php } else { ?>
                            <option selected disabled value="">Selecione uma opção</option>
                            <option value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option value="1">Recebe de qualquer chamado</option>
                            <option value="0">Não recebe de nenhum chamado</option>
                        <?php }
                        ?>
                    </select>
                </div>
                <br>
                <div class="col-10">
                    <label for="notificaExecucao" class="form-label">Recebe na execução de chamados</label>
                    <select name="notificaExecucao" id="notificaExecucao" class="form-select" required>
                        <?php
                        if ($campos['notify_email_execucao'] == 2) { ?>
                            <option selected value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option value="1">Recebe de qualquer chamado</option>
                            <option value="0">Não recebe de nenhum chamado</option>
                        <?php } else if ($campos['notify_email_execucao'] == 1) { ?>
                            <option value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option selected value="1">Recebe de qualquer chamado</option>
                            <option value="0">Não recebe de nenhum chamado</option>
                        <?php } else if ($campos['notify_email_execucao'] == 0) { ?>
                            <option value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option value="1">Recebe de qualquer chamado</option>
                            <option selected value="0">Não recebe de nenhum chamado</option>
                        <?php } else { ?>
                            <option selected disabled value="">Selecione uma opção</option>
                            <option value="2">Recebe de chamados aberto por usuários da mesma equipe</option>
                            <option value="1">Recebe de qualquer chamado</option>
                            <option value="0">Não recebe de nenhum chamado</option>
                        <?php }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <br><br>
        <div class="text-center">
            <button type="submit" class="btn btn-sm btn-danger">Aplicar Alterações</button>
        </div>
    </div>
</form>