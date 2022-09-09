<script>
    function AddIntegrante(idEquipe, idUsuario, nomeEquipe, nomeUsuario) {
        document.querySelector("#idUsuarioForm").value = idUsuario;
        document.querySelector("#idEquipeForm").value = idEquipe;

        let mensagemConfirm = ` 
                                <b>Usuário:</b> ${nomeUsuario}<br>
                                <b>Equipe:</b> ${nomeEquipe}<br><br>
        Deseja confirmar a inclusão do usuário na equipe?`
        document.querySelector("#msgConfirmAdd").innerHTML = mensagemConfirm

    }
</script>

<div class="modal fade" id="modalConfirm" tabindex="-1">
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
                                <form id="formIntegrante" method="POST" class="row g-3 needs-validation">
                                    <input type="Text" name="idUsuarioForm" class="form-control" id="idUsuarioForm" hidden>
                                    <input type="Text" name="idEquipeForm" class="form-control" id="idEquipeForm" hidden>

                                    <span id="msgConfirmAdd"></span>

                                    <div class="text-center">
                                        <input id="btnConfirmAdd" name="btnConfirmAdd" type="button" value="Confirmar" class="btn btn-danger"></input>
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
    $("#btnConfirmAdd").click(function() {
        var dados = $("#formIntegrante").serialize();


        $.post("processa/addIntegrante.php", dados, function(retorna) {
            location.href = "/gerenciamento/equipes/view.php?id=<?= $id_equipe ?>";

        });
    });
</script>