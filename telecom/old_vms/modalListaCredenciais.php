<div class="accordion-item">
    <h2 class="accordion-header" id="heading<?= $cont ?>">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $cont ?>" aria-expanded="false" aria-controls="collapse<?= $cont ?>">
            <?= $campos['descricao'] ?>
        </button>
    </h2>
    <div id="collapse<?= $cont ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $cont ?>" data-bs-parent="#accordionExample" style="">
        <div class="accordion-body">
            <div class="row justify-content-between">
                <div class="col-9">
                    <strong>IP:</strong> <?= $campos['ip']; ?><br>
                    <strong>Privacidade:</strong> <?= $campos['privacidade']; ?><br>
                    <strong>Usuário:</strong> <?= $campos['vmuser']; ?> <br>
                    <strong>Senha:</strong> <?= $campos['vmsenha']; ?><br>
                </div>
                <div class="col-3">
                    <a href="/telecom/credenciais/view.php?id=<?= $id_credencial ?>&tipo=VM" title="Editar">
                        <button type="button" class="btn btn-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wrench-adjustable-circle" viewBox="0 0 16 16">
                                <path d="M12.496 8a4.491 4.491 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11c.027.2.04.403.04.61Z"></path>
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0Zm-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.49 4.49 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8Zm-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27.596-.894Z"></path>
                            </svg>

                        </button>
                    </a>
                    <a href="/telecom/vms/processa/active.php?id=<?= $id_credencial ?>&parametro=0&idVM=<?= $id ?>" title="Inativar">
                        <button type="button" class="btn btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" />
                            </svg>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>