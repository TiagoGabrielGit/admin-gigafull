<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>


<script>
    $("#btnSalvar").click(function() {
        var dados = $("#cadastraTipoChamado").serialize();

        $.post("processa/add.php", dados, function(retorna) {

            if (retorna.includes("Error")) {
                $("#msg").slideDown('slow').html(retorna);
            } else {
                var id = retorna;
                window.location.href = "/servicedesk/tipos_chamados/tipos/view.php?id=" + id;
            }

            //Apresentar a mensagem leve
            retirarMsg();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsg() {
        setTimeout(function() {
            $("#msg").slideUp('slow', function() {});
        }, 1700);
    }
</script>

<script>
    $("#btnEditar").click(function() {
        var dadosEditarTipo = $("#editarTipoChamado").serialize();

        $.post("processa/edit.php", dadosEditarTipo, function(retornaEditarTipo) {
            $("#msgEditarTipoChamado1").slideDown('slow').html(retornaEditarTipo);
            $("#msgEditarTipoChamado2").slideDown('slow').html(retornaEditarTipo);

            //Apresentar a mensagem leve
            retirarMsgEditarTipo();
        });
    });

    //Retirar a mensagem após 1700 milissegundos
    function retirarMsgEditarTipo() {
        setTimeout(function() {
            $("#msgEditarTipoChamado1").slideUp('slow', function() {});
            $("#msgEditarTipoChamado2").slideUp('slow', function() {});
        }, 1700);
    }
</script>

<script>
    function incluirCompetencia(idCompetencia, idTipoChamado, tipoChamado, competencia) {
        document.querySelector("#idIncluirCompetencia").value = idCompetencia;
        document.querySelector("#idTipoChamadoCompetencia").value = idTipoChamado;

        let mensagemConfirmCompetencia = ` 
                     
        Deseja atribuir a competência <b> ${competencia} </b> ao tipo de chamado  <b> ${tipoChamado} </b>?`
        document.querySelector("#msgConfirmCompetencia").innerHTML = mensagemConfirmCompetencia
    }
</script>

<script>
    function retirarCompetencia(idTCC, tipoChamado2, competencia2) {
        document.querySelector("#idTCC").value = idTCC;

        let mensagemRetirarCompetencia = ` 
                     
        Deseja retirar a competência <b> ${competencia2} </b> do tipo de chamado  <b> ${tipoChamado2} </b>?`
        document.querySelector("#msgRetirarCompetencia").innerHTML = mensagemRetirarCompetencia
    }
</script>

<script>
    $("#btnConfirmCompetencia").click(function() {
        var dadosIncluiCompetencia = $("#formIncluiCompetencia").serialize();

        $.post("processa/incluiCompetencia.php", dadosIncluiCompetencia, function(retornaIncluiCompetencia) {
            location.reload();

        });
    });
</script>

<script>
    $("#btnRetirarCompetencia").click(function() {
        var dadosRetirarCompetencia = $("#formRetirarCompetencia").serialize();

        $.post("processa/retiraCompetencia.php", dadosRetirarCompetencia, function(retornaRetirarCompetencia) {
            location.reload();

        });
    });
</script>

<script>
    function mostrarOcultarCampoEntrega() {
        // Obtém o valor selecionado no select
        var selectEntrega = document.getElementById("selectEntrega").value;

        // Obtém o campo de tempo mínimo de entrega
        var campoEntrega = document.getElementById("campoEntrega");

        // Verifica se a opção selecionada é "Sim"
        if (selectEntrega === "1") {
            // Mostra o campo de tempo mínimo de entrega
            campoEntrega.style.display = "block";
        } else {
            // Oculta o campo de tempo mínimo de entrega
            campoEntrega.style.display = "none";
        }
    }

    // Chama a função para mostrar ou ocultar o campo durante a inicialização
    mostrarOcultarCampoEntrega();

    // Define um evento de mudança para o select
    document.getElementById("selectEntrega").addEventListener("change", mostrarOcultarCampoEntrega);
</script>