<script>
    function despermitirOLT(idPermissao) {

        document.querySelector("#idPermissao").value = idPermissao;

        let msgConfirm = ` Deseja despermitir o uso desta OLT para este parceiro?<br><br>`

        document.querySelector("#msgConfirmDespermite").innerHTML = msgConfirm

    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<div class="modal fade" id="modalDespermitirOLT" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Despermitir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <form id="formDespermiteOLT" method="POST" class="row g-3 needs-validation">
                                    <input type="Text" name="idPermissao" class="form-control" id="idPermissao" hidden>

                                    <span id="msgConfirmDespermite"></span>

                                    <div class="text-center">
                                        <input id="btnDespermiteOLT" name="btnDespermiteOLT" type="button" value="Despermitir" class="btn btn-danger"></input>
                                        <a href="view.php?idParceiro=<?=$idParceiro?>"> <input type="button" value="Cancelar" class="btn btn-secondary"></input></a>
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
    $("#btnDespermiteOLT").click(function() {
        var dados = $("#formDespermiteOLT").serialize();

        $.post("processa/despermiteOLT.php", dados, function(retorna) {
            location.href = "view.php?idParceiro=<?= $idParceiro ?>";

        });
    });
</script>