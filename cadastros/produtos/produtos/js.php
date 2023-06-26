<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script>
    // Obtém o elemento do grupo de rádio
    var gridRadios = document.getElementsByName("gridRadios");

    // Adiciona o evento de alteração ao grupo de rádio
    for (var i = 0; i < gridRadios.length; i++) {
        gridRadios[i].addEventListener("change", function() {
            // Obtém o valor da opção selecionada
            var selectedValue = document.querySelector('input[name="gridRadios"]:checked').value;


            if (selectedValue === "option1") {
                document.getElementById("bateriaForm").style.display = "block";
            } else {
                document.getElementById("bateriaForm").style.display = "none";
            }

            if (selectedValue === "option2") {
                document.getElementById("componentesForm").style.display = "block";
            } else {
                document.getElementById("componentesForm").style.display = "none";
            }

            if (selectedValue === "option3") {
                document.getElementById("equipamentoForm").style.display = "block";
            } else {
                document.getElementById("equipamentoForm").style.display = "none";
            }

            if (selectedValue === "option4") {
                document.getElementById("transceiverForm").style.display = "block";
            } else {
                document.getElementById("transceiverForm").style.display = "none";
            }

        });
    }
</script> 