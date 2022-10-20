<script>
    function permitirMenu(idMenu, idPerfil) {

        document.querySelector("#idMenu").value = idMenu;
        document.querySelector("#idPerfil").value = idPerfil;

        let msgConfirm = ` Deseja atribuir essa permissão ao perfil?<br><br>`

        document.querySelector("#msgConfirmPermite").innerHTML = msgConfirm

    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<div class="modal fade" id="modalPermitirMenu" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atribuir Permissão Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <form id="formPermitir" method="POST" class="row g-3 needs-validation">
                                    <input type="Text" name="idMenu" class="form-control" id="idMenu" hidden>
                                    <input type="Text" name="idPerfil" class="form-control" id="idPerfil" hidden>

                                    <span id="msgConfirmPermite"></span>

                                    <div class="text-center">
                                        <input id="btnPermitir" name="btnPermitir" type="button" value="Permitir" class="btn btn-danger"></input>
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
    $("#btnPermitir").click(function() {
        var dados = $("#formPermitir").serialize();
        $.post("processa/permitirMenu.php", dados, function(retorna) {
            location.href = "view.php?idPerfil=<?= $idPerfil ?>";
        });
    });
</script>