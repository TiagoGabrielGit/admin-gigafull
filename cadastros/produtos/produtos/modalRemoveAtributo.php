<script>
    function removerAtributo(idAtributo) {

        document.querySelector("#idAtributo").value = idAtributo;

        let msgConfirm = ` Deseja remover o atributo?<br><br>`

        document.querySelector("#msgConfirmDespermite").innerHTML = msgConfirm

    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<div class="modal fade" id="modalRemoverAtributo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Remover atributo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <form id="formRemoverAtributo" method="POST" class="row g-3 needs-validation">
                                    <input type="Text" name="idAtributo" class="form-control" id="idAtributo" hidden>

                                    <span id="msgConfirmDespermite"></span>

                                    <div class="text-center">
                                        <input id="btnRemoverAtributo" name="btnRemoverAtributo" type="button" value="Remover" class="btn btn-danger"></input>
                                        <a href="view.php?id=<?= $id_equipamento ?>"> <input type="button" value="Cancelar" class="btn btn-secondary"></input></a>
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
    $("#btnRemoverAtributo").click(function() {
        var dados = $("#formRemoverAtributo").serialize();

        $.post("processa/removerAtributo.php", dados, function(retorna) {
            location.href = "view.php?id=<?= $id_equipamento ?>";

        });
    });
</script>