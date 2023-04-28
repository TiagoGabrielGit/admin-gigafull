<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<!--HOMOLOGANDO-->
<script>
    const cadForm = document.getElementById("formCadastraParceiro");
    const msgAlertaErroCad = document.getElementById("msgAlertaErroCad");
    const msgAlerta = document.getElementById("msgAlerta");

    cadForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const dadosForm = new FormData(cadForm);

        document.getElementById("buttonCadastraParceiro").value = "Cadastrando...";

        const dados = await fetch("/api/insert_cadastra_parceiro.php", { 
            method: "POST",
            body: dadosForm,
        });

        const resposta = await dados.json();

        if (resposta['erro']) {
            msgAlertaErroCad.innerHTML = resposta['msg'];
        } else {
            msgAlerta.innerHTML = resposta['msg'];
            cadForm.reset();

            setTimeout(function() {
                window.location.reload(1);
            }, 1200);
        }
        document.getElementById("buttonCadastraParceiro").value = "Cadastrar";
    });
</script>
<!--HOMOLOGANDO-->