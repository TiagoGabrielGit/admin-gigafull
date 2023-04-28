<script>
    function despermitirMenu(idPermissao) {

        document.querySelector("#idPermissao").value = idPermissao;
        let msgConfirm = ` Deseja remover essa permissão deste perfil?<br><br>`
        document.querySelector("#msgConfirmDespermite").innerHTML = msgConfirm

    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<div class="modal fade" id="modalDespermitirMenu" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Remover permissão Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <form id="formDespermitir" method="POST" class="row g-3 needs-validation">
                                    <input type="Text" name="idPermissao" class="form-control" id="idPermissao" hidden>

                                    <span id="msgConfirmDespermite"></span>

                                    <div class="text-center">
                                        <input id="btnDespermitir" name="btnDespermitir" type="button" value="Remover" class="btn btn-danger"></input>
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
    $("#btnDespermitir").click(function() {
        var dados = $("#formDespermitir").serialize();

        $.post("processa/despermitirMenu.php", dados, function(retorna) {
            location.href = "view.php?idPerfil=<?= $idPerfil ?>";

        });
    });
</script>