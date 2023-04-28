<script>
    function permitirSubmenu(idSubmenu, idPerfil) {

        document.querySelector("#idSubmenu").value = idSubmenu;
        document.querySelector("#submenu_idPerfil").value = idPerfil;

        let submenu_msgConfirm = ` Deseja atribuir essa permissão ao perfil?<br><br>`

        document.querySelector("#submenu_msgConfirmPermite").innerHTML = submenu_msgConfirm

    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<div class="modal fade" id="modalPermitirSubmenu" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atribuir Permissão Submenu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <form id="submenu_formPermitir" method="POST" class="row g-3 needs-validation">
                                    <input type="Text" name="idSubmenu" class="form-control" id="idSubmenu" hidden>
                                    <input type="Text" name="submenu_idPerfil" class="form-control" id="submenu_idPerfil" hidden>

                                    <span id="submenu_msgConfirmPermite"></span>

                                    <div class="text-center">
                                        <input id="submenu_btnPermitir" name="submenu_btnPermitir" type="button" value="Permitir" class="btn btn-danger"></input>
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
    $("#submenu_btnPermitir").click(function() {
        var dados = $("#submenu_formPermitir").serialize();
        $.post("processa/permitirSubmenu.php", dados, function(retorna) {
            location.href = "view.php?idPerfil=<?= $idPerfil ?>";
        });
    });
</script>