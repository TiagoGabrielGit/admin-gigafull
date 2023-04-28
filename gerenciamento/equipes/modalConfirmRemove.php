<script>
    function removeIntegrante(idCadastro, nomeUsuario, nomeEquipe) {
        document.querySelector("#idCadastro").value = idCadastro;

        let mensagemConfirmRemove = ` <b>Usuário:</b> ${nomeUsuario}<br>
                                <b>Equipe:</b> ${nomeEquipe}<br><br>
        Deseja confirmar a remoção do usuário na equipe?`
        
        document.querySelector("#msgConfirmRemove").innerHTML = mensagemConfirmRemove

    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<div class="modal fade" id="modalConfirmRemove" tabindex="-1">
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
                                <form id="formIntegranteRemove" method="POST" class="row g-3 needs-validation">
                                    <input type="Text" name="idCadastro" class="form-control" id="idCadastro" hidden>

                                    <span id="msgConfirmRemove"></span>

                                    <div class="text-center">
                                        <input id="btnConfirmRemove" name="btnConfirmRemove" type="button" value="Confirmar" class="btn btn-danger"></input>
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

<script>
    $("#btnConfirmRemove").click(function() {
        var dados = $("#formIntegranteRemove").serialize();

        $.post("processa/removeIntegrante.php", dados, function(retorna) {
            location.href = "/gerenciamento/equipes/view.php?id=<?= $id_equipe?>";

        });
    });

</script>