<script>
    function permitirChamado(idTipoChamado1, idEquipe1, nomeEquipe1, tipoChamado1) {
        document.querySelector("#idTipoChamadoFormChamado").value = idTipoChamado1;
        document.querySelector("#idEquipeFormChamado").value = idEquipe1;

        let mensagemConfirm1 = ` 
                                <b>Tipo Chamado:</b> ${tipoChamado1}<br>
                                <b>Equipe:</b> ${nomeEquipe1}<br><br>
        Deseja confirmar a permissão para abrir este tipo de chamado aos usuários desta equipe?`
        document.querySelector("#msgConfirmChamado").innerHTML = mensagemConfirm1

    }
</script>

<div class="modal fade" id="modalPermitirChamado" tabindex="-1">
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
                                <form id="formChamadoPermit" method="POST" class="row g-3 needs-validation">
                                    <input type="Text" name="idTipoChamadoFormChamado" class="form-control" id="idTipoChamadoFormChamado" hidden>
                                    <input type="Text" name="idEquipeFormChamado" class="form-control" id="idEquipeFormChamado" hidden>

                                    <span id="msgConfirmChamado"></span>

                                    <div class="text-center">
                                        <input id="btnConfirmChamado" name="btnConfirmChamado" type="button" value="Confirmar" class="btn btn-danger"></input>
                                        <a href="/gerenciamento/equipes/view.php?id=<?= $id_equipe ?>"> <input type="button" value="Cancelar" class="btn btn-secondary"></input></a>
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



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>


<script>
    $("#btnConfirmChamado").click(function() {
        var dados = $("#formChamadoPermit").serialize();


        $.post("processa/addPermissaoChamado.php", dados, function(retorna) {
            location.href = "/gerenciamento/equipes/view.php?id=<?= $id_equipe ?>";

        });
    });
</script>