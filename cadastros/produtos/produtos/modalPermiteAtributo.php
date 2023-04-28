<script>
    function permitirAtributo(idEquipamento, idTipo) {

        document.querySelector("#idEquipamento").value = idEquipamento;
        document.querySelector("#idTipo").value = idTipo;

        let msgConfirm = ` Deseja permitir este atributo para este equipamento?<br><br>`

        document.querySelector("#msgConfirmPermite").innerHTML = msgConfirm

    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<div class="modal fade" id="modalPermitirAtributo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Permitir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <form id="formPermiteAtributo" method="POST" class="row g-3 needs-validation">
                                    <input type="Text" name="idEquipamento" class="form-control" id="idEquipamento" hidden>
                                    <input type="Text" name="idTipo" class="form-control" id="idTipo" hidden>

                                    <span id="msgConfirmPermite"></span>

                                    <div class="text-center">
                                        <input id="btnPermiteAtributo" name="btnPermiteAtributo" type="button" value="Permitir" class="btn btn-danger"></input>
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
    $("#btnPermiteAtributo").click(function() {
        var dados = $("#formPermiteAtributo").serialize();

        $.post("processa/permiteAtributo.php", dados, function(retorna) {
            location.href = "view.php?id=<?= $id_equipamento ?>";

        });
    });
</script>