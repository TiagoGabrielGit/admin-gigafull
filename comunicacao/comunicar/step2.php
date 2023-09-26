<form method="POST" action="processa/step2.php">
    <input hidden readonly id="idComunicacao" name="idComunicacao" value="<?= $idComunicacao ?>"></input>

    <div class="row">
        <div class="col-lg-12">
            <div class="col-7">
                <label for="templateEmail" class="form-label">Escolher um Template</label>
                <select class="form-select" name="templateEmail" id="templateEmail" required>
                    <option selected disabled value="">Selecione...</option>
                    <?php
                    $sql =
                        "SELECT
											ct.id as id,
											ct.titulo as titulo,
											ct.template as template,
											CASE
												WHEN ct.aplicado = 1 THEN 'Incidentes'
												WHEN ct.aplicado = 2 THEN 'Manutenção Programada'
											END as aplicado,
											CASE
												WHEN ct.active = 1 THEN 'Ativo'
												WHEN ct.active = 0 THEN 'Inativo'
											END as active
										FROM comunicacao_templates as ct
										WHERE ct.tipo = 1 AND ct.active = 1
										ORDER BY ct.template ASC";

                    $r_sql = mysqli_query($mysqli, $sql);

                    while ($c_sql = $r_sql->fetch_array()) {
                    ?>
                        <option value="<?= $c_sql['id'] ?>"><?= $c_sql['titulo']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <hr class="sidebar-divider">

            <style>
                .template-container {
                    width: 100%;
                    margin: 0 auto;
                    padding: 20px;
                    border: 1px solid #000;
                }
            </style>


            <div class="col-12">
                <div id="templateSelecionado">
                </div>
            </div>

            <hr class="sidebar-divider">
        </div>

        <style>
            .equal-width-btn {
                width: 60%;
            }
        </style>

        <div class="container">
            <form method="POST" action="processa/step2.php">

                <input readonly hidden id="idComunicacao" name="idComunicacao" value="<?= $idComunicacao ?>" />

                <div class="row">
                    <div class="col-3">
                        <button name="acao" value="salvar_rascunho" class="btn btn-sm btn-primary equal-width-btn">Salvar Rascunho</button>
                    </div>

                    <div class="col-3">
                        <button name="acao" value="voltar" class="btn btn-sm btn-warning equal-width-btn">Voltar</button>
                    </div>

                    <div class="col-3">
                        <button name="acao" value="avancar" class="btn btn-sm btn-danger equal-width-btn">Avançar</button>
                    </div>

                    <div class="col-3">
                        <button name="acao" value="cancelar_comunicacao" class="btn btn-sm btn-secondary equal-width-btn">Cancelar Comunicação</button>
                    </div>
                </div>
            </form>
        </div>

    </div> <!-- A -->
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Quando o valor do select mudar
        $("#templateEmail").change(function() {
            // Pega o valor selecionado
            var templateId = $(this).val();

            $.ajax({
                type: "POST",
                url: "processa/buscar_template.php",
                data: {
                    templateId: templateId
                },
                success: function(response) {
                    // Atualize o conteúdo da div com o HTML retornado sem escapar
                    $("#templateSelecionado").html(response);

                    // Adicione a classe CSS "template-container" à div para estilizá-la
                    //$("#templateSelecionado").addClass("template-container");
                }
            });

        });
    });
</script>