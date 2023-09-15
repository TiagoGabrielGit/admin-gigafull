<div class="row">
    <div class="col-lg-10">
        <h5 class="card-title">PON</h5>
    </div>
    <div class="col-lg-2" style="margin-top: 10px;">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalAdicionarPON">Adicionar</button>
    </div>
</div>

<?php
if (isset($_GET['error'])) {
    $errorMessage = $_GET['error'];

    if ($errorMessage === 'cadastro_ja_existe') {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
        echo 'O processo foi interrompido devido a ter cadastrados duplicados.';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
    }
}
?>

<hr class="sidebar-divider">
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <table class="table table-striped" id="styleTable">
                <thead>
                    <tr>
                        <th scope="col">OLT</th>
                        <th scope="col">SLOT</th>
                        <th scope="col">PON</th>
                        <th scope="col">Código Integração</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_lista_pons =
                        "SELECT
                        gpp.id as id,
                        gpo.olt_name as olt,
                        gpp.slot as slot,
                        gpp.pon as pon,
                        gpp.cod_int as codigo,
                        CASE
                            WHEN gpp.active = 1 THEN 'Ativo'
                            WHEN gpp.active = 0 THEN 'Inativo'
                        END as active
                    FROM
                        gpon_pon as gpp
                    LEFT JOIN
                        gpon_olts as gpo
                    on
                        gpo.id = gpp.olt_id
                    ORDER BY
                        gpo.olt_name ASC,
                        gpp.slot ASC,
                        gpp.pon ASC
                        ";

                    $r_lista_pons = mysqli_query($mysqli, $sql_lista_pons);

                    while ($c_lista_pon = $r_lista_pons->fetch_array()) {
                    ?>
                        <tr>
                            <td><a href="pon_view.php?id=<?= $c_lista_pon['id']; ?>"><span style="color: red;"><?= $c_lista_pon['olt']; ?></span></a></td>
                            <td><?= $c_lista_pon['slot']; ?></td>
                            <td><?= $c_lista_pon['pon']; ?></td>
                            <td><?= $c_lista_pon['codigo']; ?></td>
                            <td><?= $c_lista_pon['active']; ?></td>
                        </tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAdicionarPON" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar PONs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="card-body">
                    <form action="processa/adicionar_pon.php" method="POST" class="row g-3" id="formulario">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="col-12">
                                    <label for="olt" class="form-label">OLT*</label>
                                    <select class="form-select" id="olt" name="olt" required>
                                        <option value="" disabled selected>Selecione...</option>
                                        <?php
                                        $sql_olt =
                                            "SELECT
                                        gpo.id as idOLT,
                                        gpo.olt_name as oltNAME
                                        FROM
                                        gpon_olts as gpo
                                        WHERE
                                        gpo.active = 1
                                        ORDER BY
                                        gpo.olt_name ASC
                                        ";

                                        $r_olt = mysqli_query($mysqli, $sql_olt);

                                        while ($c_olt = mysqli_fetch_object($r_olt)) :
                                            echo "<option value='$c_olt->idOLT'> $c_olt->oltNAME</option>";
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="col-12">
                                    <div style="margin-top: 15px;" class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-sm btn-info" id="adicionar-campo">Adicionar Mais</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="campos-dinamicos">
                            <!-- Os campos de entrada dinâmicos serão adicionados aqui -->
                        </div>

                        <hr class="sidebar-divider">

                        <div class="text-center">
                            <button type="submit" class="btn btn-danger">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
// Função para adicionar campos de entrada dinamicamente
document.getElementById('adicionar-campo').addEventListener('click', function() {
    var camposDinamicos = document.getElementById('campos-dinamicos');

    // Crie os elementos de entrada dinâmicos
    var novoCampo = document.createElement('div');
    novoCampo.classList.add('row');

    novoCampo.innerHTML = `
        <div class="col-3">
            <label for="slot" class="form-label">SLOT*</label>
            <input name="slot[]" class="form-control" type="text" required>
        </div>
        <div class="col-3">
            <label for="pon" class="form-label">PON*</label>
            <input name="pon[]" class="form-control" type="text" required>
        </div>
        <div class="col-3">
            <label for="codigo" class="form-label">Código Integração*</label>
            <input name="codigo[]" class="form-control" type="text" required>
        </div>
        <div style="margin-top: 35px;" class="col-3">
            <button type="button" class="btn btn-sm btn-danger" onclick="removerLinha(this)">Excluir</button>
        </div>
    `;

    camposDinamicos.appendChild(novoCampo);
});

// Função para remover a linha quando o botão "Excluir" é clicado
function removerLinha(botaoExcluir) {
    var linha = botaoExcluir.parentNode.parentNode;
    var camposDinamicos = document.getElementById('campos-dinamicos');
    camposDinamicos.removeChild(linha);
}

</script>