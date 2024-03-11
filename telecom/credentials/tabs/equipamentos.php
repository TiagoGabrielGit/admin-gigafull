<?php
if (empty($_POST['EquipamentoEmpresaPesquisa'])) {
    $_POST['EquipamentoEmpresaPesquisa'] = "%";
}

if (empty($_POST['popPesquisa'])) {
    $_POST['popPesquisa'] = "%";
}

if (empty($_POST['ipaddressPesquisa'])) {
    $_POST['ipaddressPesquisa'] = "%";
}

if (empty($_POST['hostnamePesquisa'])) {
    $_POST['hostnamePesquisa'] = "%";
}

if (empty($_POST['tipoEquipamentoPesquisa'])) {
    $_POST['tipoEquipamentoPesquisa'] = "%";
}

if (empty($_POST['EquipamentoFabricantePesquisa'])) {
    $_POST['EquipamentoFabricantePesquisa'] = "%";
}

if (empty($_POST['equipamentoPesquisa'])) {
    $_POST['equipamentoPesquisa'] = "%";
}

if (empty($_POST['statusEquipamentoPesquisa'])) {
    $_POST['statusEquipamentoPesquisa'] = "Ativado";
}

if (empty($_POST['limiteBusca'])) {
    $_POST['limiteBusca'] = "100";
}

$empresa_id = $_POST['EquipamentoEmpresaPesquisa'];
$pop_id = $_POST['popPesquisa'];
$ipaddress = $_POST['ipaddressPesquisa'];
$hostname = $_POST['hostnamePesquisa'];
$tipoEquipamentoPesquisa = $_POST['tipoEquipamentoPesquisa'];
$fabricante_id = $_POST['EquipamentoFabricantePesquisa'];
$equipamento_id = $_POST['equipamentoPesquisa'];
$statusEquipamentoPesquisa = $_POST['statusEquipamentoPesquisa'];
$limiteBusca = $_POST['limiteBusca'];


$sql_pesquisa_EquipamentosPop =
    "SELECT
equipop.id as id_equipop,
equipop.hostname as hostname,
equipop.tipoEquipamento_id as tipoid,
equipop.ipaddress as ipaddress,
equipop.deleted as deleted,
equipop.criado as criado,
equipop.modificado as modificado,
equipop.statusEquipamento as statuseqp,
emp.fantasia as empresa,
eqp.equipamento as equipamento,
pop.pop as pop
FROM
equipamentospop as equipop
LEFT JOIN
empresas as emp
ON
equipop.empresa_id = emp.id
LEFT JOIN
equipamentos as eqp
ON
eqp.id = equipop.equipamento_id
LEFT JOIN       
pop as pop
ON
pop.id = equipop.pop_id
WHERE
equipop.empresa_id LIKE '$empresa_id'
and
equipop.pop_id LIKE '$pop_id'
and
equipop.ipaddress LIKE '$ipaddress'
and
equipop.hostname LIKE '%$hostname%'
and
equipop.tipoEquipamento_id LIKE '$tipoEquipamentoPesquisa'
and
equipop.equipamento_id LIKE '$equipamento_id'
and
eqp.fabricante LIKE '$fabricante_id'
and
equipop.statusEquipamento LIKE '$statusEquipamentoPesquisa'
and
equipop.deleted = 1
ORDER BY
equipop.hostname ASC


LIMIT $limiteBusca
"; ?>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-10">
                            </div>
                            <div class="col-2">
                                <div class="card">
                                    <!-- Basic Modal -->
                                    <button style="margin-top: 15px" type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalNovoEquipamento">
                                        Cadastrar novo
                                    </button>
                                </div>
                            </div>
                            <div class="modal fade" id="modalNovoEquipamento" tabindex="-1">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Novo cadastro</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <!-- Vertical Form -->
                                                <form method="POST" action="/telecom/credentials/equipamentos/processa/add.php" class="row g-3">

                                                    <div class="col-4">
                                                        <label for="EquipamentocadastroEmpresa" class="form-label">Empresa*</label>
                                                        <select id="EquipamentocadastroEmpresa" name="EquipamentocadastroEmpresa" class="form-select" required>
                                                            <option selected disabled>Selecione a empresa</option>
                                                            <?php
                                                            $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                                            while ($empresa = mysqli_fetch_object($resultado)) :
                                                                echo "<option value='$empresa->id'> $empresa->empresa</option>";
                                                            endwhile;
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-4">
                                                        <label for="EquipamentoCadastroPop" class="form-label">POP*</label>
                                                        <select id="EquipamentoCadastroPop" name="EquipamentoCadastroPop" class="form-select" required>
                                                            <option selected disabled>Selecione o pop</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-4">
                                                        <label for="EquipamentoCadastroRackPop" class="form-label">Rack*</label>
                                                        <select id="EquipamentoCadastroRackPop" name="EquipamentoCadastroRackPop" class="form-select" required>
                                                            <option selected disabled>Selecione o rack</option>
                                                        </select>
                                                    </div>

                                                    <hr class="sidebar-divider">

                                                    <div class="col-4">
                                                        <label for="EquipamentoCadastroFabricante" class="form-label">Fabricante*</label>
                                                        <select id="EquipamentoCadastroFabricante" name="EquipamentoCadastroFabricante" class="form-select" required>
                                                            <option selected disabled>Selecione o fabricante</option>
                                                            <?php
                                                            $resultado = mysqli_query($mysqli, $sql_lista_fabricantes);
                                                            while ($fabricante = mysqli_fetch_object($resultado)) :
                                                                echo "<option value='$fabricante->id'> $fabricante->fabricante</option>";
                                                            endwhile;
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-4">
                                                        <label for="EquipamentocadastroEquipamento" class="form-label">Equipamento*</label>
                                                        <select id="EquipamentocadastroEquipamento" name="EquipamentocadastroEquipamento" class="form-select" required>
                                                            <option selected disabled>Selecione o equipamento</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-4">
                                                        <label for="EquipamentoCadastroTipoEquipamento" class="form-label select-label">Tipo de equipamento*</label>
                                                        <select id="EquipamentoCadastroTipoEquipamento" name="EquipamentoCadastroTipoEquipamento" class="form-select" required>
                                                            <option selected disabled>Selecione o tipo</option>
                                                        </select>
                                                    </div>

                                                    <hr class="sidebar-divider">

                                                    <div class="col-4">
                                                        <label for="EquipamentoCadastrohostname" class="form-label">Hostname*</label>
                                                        <input name="EquipamentoCadastrohostname" type="text" class="form-control" id="EquipamentoCadastrohostname" placeholder="Ex: sw01.POPABC" required>
                                                    </div>

                                                    <div class="col-4">
                                                        <label for="EquipamentoCadastroIPAddress" class="form-label">Endereço IP*</label>
                                                        <input id="EquipamentoCadastroIPAddress" name="EquipamentoCadastroIPAddress" type="text" class="form-control" placeholder="Ex: 192.168.1.1" maxlength="15" required>
                                                    </div>

                                                    <div class="col-4"></div>


                                                    <div class="col-4">
                                                        <label for="EquipamentoCadastroSerial" class="form-label">Serial</label>
                                                        <input id="EquipamentoCadastroSerial" name="EquipamentoCadastroSerial" type="text" class="form-control" placeholder="Ex: AXT123ZXC">
                                                    </div>

                                                    <div class="col-4">
                                                        <label for="EquipamentoCadastroStatus" class="form-label">Status*</label>
                                                        <select id="EquipamentoCadastroStatus" name="EquipamentoCadastroStatus" class="form-select" required>
                                                            <option selected disabled>Selecione o status</option>>
                                                            <option value="Ativado">Ativado</option>
                                                            <option value="Em Implementação">Em Implementação</option>
                                                            <option value="Inativado">Inativado</option>
                                                        </select>
                                                    </div>
                                                    <hr class="sidebar-divider">

                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-sm btn-danger">Salvar</button>
                                                        <a href="/telecom/credentials/index.php"> <input type="button" value="Voltar" class="btn btn-sm btn-secondary"></input></a>
                                                    </div>
                                                </form><!-- Vertical Form -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Basic Modal-->
                        </div>
                    </div>
                    <?= 'Status: ' .$statusEquipamentoPesquisa ?>

                    <form method="POST" action="#" class="row g-3">
                        <input type="hidden" id="tabequipamento" name="tabequipamento">
                        <div class="col-4">
                            <label for="EquipamentoEmpresaPesquisa" class="form-label">Empresa</label>
                            <select id="EquipamentoEmpresaPesquisa" name="EquipamentoEmpresaPesquisa" class="form-select">
                                <option selected disabled>Selecione a empresa</option>
                                <?php
                                $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                while ($empresa = mysqli_fetch_object($resultado)) :
                                    echo "<option value='$empresa->id'> $empresa->empresa</option>";
                                endwhile;

                                if ($_SERVER["REQUEST_METHOD"] == 'POST') :

                                ?>
                                    <script>
                                        let nomeEmpresa = '<?= $_POST['EquipamentoEmpresaPesquisa']; ?>'
                                        if (nomeEmpresa == '%') {} else {
                                            document.querySelector("#EquipamentoEmpresaPesquisa").value = nomeEmpresa
                                        }
                                    </script>
                                <?php
                                endif;
                                ?>
                            </select>
                        </div>

                        <div class="col-3">
                            <label for="popPesquisa" class="form-label">POP</label>
                            <select id="popPesquisa" name="popPesquisa" class="form-select">
                                <option selected disabled>Selecione o pop</option>
                            </select>
                        </div>

                        <div class="col-3">
                            <label for="ipaddressPesquisa" class="form-label">Endereço IP</label>
                            <input id="ipaddressPesquisa" name="ipaddressPesquisa" type="text" class="form-control" placeholder="Ex: 192.168.1.1" maxlength="15">

                            <?php if ($_SERVER["REQUEST_METHOD"] == 'POST') : ?>
                                <script>
                                    let ipaddr = '<?= $_POST['ipaddressPesquisa']; ?>'
                                    if (ipaddr == '%') {} else {
                                        document.querySelector("#ipaddressPesquisa").value = ipaddr
                                    }
                                </script>
                            <?php
                            endif;
                            ?>
                        </div>

                        <div class="col-2"></div>


                        <div class="col-3">
                            <label for="hostnamePesquisa" class="form-label">Hostname</label>
                            <input name="hostnamePesquisa" type="text" class="form-control" id="hostnamePesquisa">

                            <?php if ($_SERVER["REQUEST_METHOD"] == 'POST') : ?>
                                <script>
                                    let hostname = '<?= $_POST['hostnamePesquisa']; ?>'
                                    if (hostname == '%') {} else {
                                        document.querySelector("#hostnamePesquisa").value = hostname
                                    }
                                </script>
                            <?php
                            endif;
                            ?>

                        </div>

                        <div class="col-3">
                            <label for="tipoEquipamentoPesquisa" class="form-label">Tipo de Equipamento</label>
                            <select id="tipoEquipamentoPesquisa" name="tipoEquipamentoPesquisa" class="form-select">
                                <option selected disabled>Selecione o tipo</option>
                                <?php
                                $resultado = mysqli_query($mysqli, $sql_lista_tipos);
                                while ($tipos = mysqli_fetch_object($resultado)) :
                                    echo "<option value='$tipos->id'> $tipos->tipo</option>";
                                endwhile;

                                if ($_SERVER["REQUEST_METHOD"] == 'POST') :

                                ?>
                                    <script>
                                        let tipoEquipamentoPesquisa = '<?= $_POST['tipoEquipamentoPesquisa']; ?>'
                                        if (tipoEquipamentoPesquisa == '%') {} else {
                                            document.querySelector("#tipoEquipamentoPesquisa").value = tipoEquipamentoPesquisa
                                        }
                                    </script>
                                <?php
                                endif;
                                ?>
                            </select>
                        </div>

                        <div class="col-3">
                            <label for="EquipamentoFabricantePesquisa" class="form-label">Fabricante</label>
                            <select id="EquipamentoFabricantePesquisa" name="EquipamentoFabricantePesquisa" class="form-select">
                                <option selected disabled>Selecione o fabricante</option>
                                <?php
                                $resultado = mysqli_query($mysqli, $sql_lista_fabricantes);
                                while ($fabricante = mysqli_fetch_object($resultado)) :
                                    echo "<option value='$fabricante->id'> $fabricante->fabricante</option>";
                                endwhile;

                                if ($_SERVER["REQUEST_METHOD"] == 'POST') :

                                ?>
                                    <script>
                                        let EquipamentoFabricantePesquisa = '<?= $_POST['EquipamentoFabricantePesquisa']; ?>'
                                        if (EquipamentoFabricantePesquisa == '%') {} else {
                                            document.querySelector("#EquipamentoFabricantePesquisa").value = EquipamentoFabricantePesquisa
                                        }
                                    </script>
                                <?php
                                endif;
                                ?>
                            </select>
                        </div>

                        <div class="col-3">
                            <label for="equipamentoPesquisa" class="form-label">Equipamento</label>
                            <select id="equipamentoPesquisa" name="equipamentoPesquisa" class="form-select">
                                <option selected disabled>Selecione o equipamento</option>
                            </select>
                        </div>

                        <div class="col-3">
                            <label for="statusEquipamentoPesquisa" class="form-label">Status</label>
                            <select id="statusEquipamentoPesquisa" name="statusEquipamentoPesquisa" class="form-select" required>

                                <option value="%">Todos</option>
                                <option selected value="Ativado">Ativado</option>
                                <option value="Em Implementação">Em Implementação</option>
                                <option value="Inativado">Inativado</option>


                                <?php if ($_SERVER["REQUEST_METHOD"] == 'POST') : ?>
                                    <script>
                                        let statusEquipamentoPesquisa = '<?= $_POST['statusEquipamentoPesquisa']; ?>'
                                        if (statusEquipamentoPesquisa == 'Ativado') {} else {
                                            document.querySelector("#statusEquipamentoPesquisa").value = statusEquipamentoPesquisa
                                        }
                                    </script>
                                <?php
                                endif;
                                ?>

                            </select>
                        </div>

                        <div class="col-2">
                            <label for="limiteBusca" class="form-label">Limite de busca*</label>
                            <select id="limiteBusca" name="limiteBusca" class="form-select" required>
                                <option disabled selected>100 Resultados</option>
                                <option value="10">10 Resultados</option>
                                <option value="50">50 Resultados</option>
                                <option value="500">500 Resultados</option>
                                <option value="1000">1000 Resultados</option>

                                <?php if ($_SERVER["REQUEST_METHOD"] == 'POST') : ?>
                                    <script>
                                        let limiteBusca = '<?= $_POST['limiteBusca']; ?>'
                                        if (limiteBusca == '100') {} else {
                                            document.querySelector("#limiteBusca").value = limiteBusca
                                        }
                                    </script>
                                <?php
                                endif;
                                ?>

                            </select>
                        </div>

                        <div class="col-6">
                            <button style="margin-top: 30px; " type="submit" class="btn btn-sm btn-danger">Filtrar</button>
                        </div>

                    </form>

                    <hr class="sidebar-divider">

                    <table class="table table-striped" id="styleTable">
                        <thead>
                            <tr>
                                <th style="text-align: center;" scope="col">Hostname</th>
                                <th style="text-align: center;" scope="col">Empresa / POP</th>
                                <th style="text-align: center;" scope="col">Endereço IP</th>
                                <th style="text-align: center;" scope="col">Equipamento</th>
                                <th style="text-align: center;" scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Preenchendo a tabela com os dados do banco: -->
                            <?php
                            $resultado = mysqli_query($mysqli, $sql_pesquisa_EquipamentosPop) or die("Erro ao retornar dados");

                            // Obtendo os dados por meio de um loop while
                            while ($campos = $resultado->fetch_array()) {
                                $id = $campos['id_equipop']; ?>

                                <tr>
                                    <td style="text-align: center;">
                                        <a style="color: red;" href="equipamentos/view.php?id=<?= $campos['id_equipop']; ?>"><?= $campos['hostname']; ?></a>
                                    </td>
                                    <td><?= $campos['empresa']; ?> / <?= $campos['pop']; ?></td>
                                    <td><?= $campos['ipaddress']; ?></td>
                                    <td><?= $campos['equipamento']; ?></td>
                                    <td><?= $campos['statuseqp']; ?></td>
                                <?php } ?>
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>

        </div>
    </div>
</section>


<script>
    let inputIP = document.querySelector("#ipaddress");
    inputIP.addEventListener("keydown", (e) => {
        if (e.key >= "0" && e.key <= "9" || e.key == "." || e.key == "Backspace" || e.key == "CTRL" || e.key == "v" || e.key == "Delete" || e.key == "V" || e.key == "A" || e.key == "a" || e.key == "C" || e.key == "c") {} else {
            e.preventDefault();
        }
    });
</script>

<script>
    let inputIPPesquisa = document.querySelector("#ipaddressPesquisa");
    inputIPPesquisa.addEventListener("keydown", function(e) {
        if (e.key >= "0" && e.key <= "9" || e.key == "." || e.key == "Backspace" || e.key == "CTRL" || e.key == "v" || e.key == "Delete" || e.key == "V" || e.key == "A" || e.key == "a" || e.key == "C" || e.key == "c") {

        } else {
            e.preventDefault();
        }
    });
</script>