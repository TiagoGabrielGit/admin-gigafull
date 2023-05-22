<script>
    function despermitirChamado(idCadastro2, nomeEmpresa2, tipoChamado2) {
        document.querySelector("#idCadastro2").value = idCadastro2;

        let mensagemConfirmRemove2 = ` 
        <b>ID Permissão:</b> ${idCadastro2}<br>
        <b>Tipo Chamado:</b> ${tipoChamado2}<br>
                                <b>Empresa:</b> ${nomeEmpresa2}<br><br>
        Deseja remover a permissão dos usuários desta empresa abrir este tipo de chamado?`

        document.querySelector("#msgConfirmRemoveChamado").innerHTML = mensagemConfirmRemove2
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<div class="modal fade" id="modalDespermitirChamado" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <form id="formChamadoRemove" method="POST" class="row g-3 needs-validation">
                                    <input type="Text" name="idCadastro2" class="form-control" id="idCadastro2" hidden>

                                    <span id="msgConfirmRemoveChamado"></span>

                                    <div class="text-center">
                                        <input id="btnDespermitirChamado" name="btnDespermitirChamado" type="button" value="Confirmar" class="btn btn-danger"></input>
                                        <a href="/empresas/view.php?id==<?= $id ?>"> <input type="button" value="Cancelar" class="btn btn-secondary"></input></a>
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
    $("#btnDespermitirChamado").click(function() {
        var dados = $("#formChamadoRemove").serialize();

        $.post("processa/despermitirChamado.php", dados, function(retorna) {
            location.href = "/empresas/view.php?id=<?= $id ?>";

        });
    });
</script>