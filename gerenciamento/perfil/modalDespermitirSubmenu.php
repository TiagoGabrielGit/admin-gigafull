<script>
    function despermitirSubmenu(idPermissao) {
        document.querySelector("#submenu_idPermissao").value = idPermissao;
        let submenu_msgConfirm = `Deseja remover essa permissão deste perfil?<br><br>`
        document.querySelector("#submenu_msgConfirmDespermite").innerHTML = submenu_msgConfirm

    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<div class="modal fade" id="modalDespermitirSubmenu" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Remover permissão Submenu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <form id="submenu_formDespermitir" method="POST" class="row g-3 needs-validation">
                                    <input type="Text" name="submenu_idPermissao" class="form-control" id="submenu_idPermissao" hidden>

                                    <span id="submenu_msgConfirmDespermite"></span>

                                    <div class="text-center">
                                        <input id="submenu_btnDespermitir" name="submenu_btnDespermitir" type="button" value="Remover" class="btn btn-danger"></input>
                                        <a href="view.php?idPerfil=<?= $idPerfil ?>"> <input type="button" value="Cancelar" class="btn btn-secondary"></input></a>
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

<script>
    $("#submenu_btnDespermitir").click(function() {
        var dados = $("#submenu_formDespermitir").serialize();

        $.post("processa/despermitirSubmenu.php", dados, function(retorna) {
            location.href = "view.php?idPerfil=<?= $idPerfil ?>";

        });
    });
</script>