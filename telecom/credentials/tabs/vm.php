<?php
if (empty($_POST['VMempresaPesquisa'])) {
    $_POST['VMempresaPesquisa'] = "%";
}

if (empty($_POST['VMpopPesquisa'])) {
    $_POST['VMpopPesquisa'] = "%";
}

if (empty($_POST['ipaddressPesquisa'])) {
    $_POST['ipaddressPesquisa'] = "%";
}

if (empty($_POST['limiteBusca'])) {
    $_POST['limiteBusca'] = "100";
}

if (empty($_POST['hostnamePesquisa'])) {
    $_POST['hostnamePesquisa'] = "%";
}

if (empty($_POST['VMservidorPesquisa'])) {
    $_POST['VMservidorPesquisa'] = "%";
}

if (empty($_POST['SOPesquisa'])) {
    $_POST['SOPesquisa'] = "%";
}

if (empty($_POST['statusVMPesquisa'])) {
    $_POST['statusVMPesquisa'] = "Ativado";
}

$empresa_id = $_POST['VMempresaPesquisa'];
$pop_id = $_POST['VMpopPesquisa'];
$ipaddress = $_POST['ipaddressPesquisa'];
$limiteBusca = $_POST['limiteBusca'];
$hostname = $_POST['hostnamePesquisa'];
$servidor = $_POST['VMservidorPesquisa'];
$SO = $_POST['SOPesquisa'];
$statusvm = $_POST['statusVMPesquisa'];


$sql_pesquisa_vms =
    "SELECT
vm.id as idvm,
vm.hostname as hostname,
vm.ipaddress as ipaddress,
vm.statusvm as statusvm,
emp.fantasia as empresa,
pop.pop as pop,
eqpop.hostname as servidor,
so.sistemaOperacional as sistemaOperacional
FROM
vms as vm
LEFT JOIN
empresas as emp
ON
emp.id = vm.empresa_id
LEFT JOIN
pop as pop
ON
pop.id = vm.pop_id
LEFT JOIN
equipamentospop as eqpop
ON
eqpop.id = vm.servidor_id
LEFT JOIN
sistemaoperacional as so
ON
so.id = vm.sistemaOperacional
WHERE
vm.empresa_id LIKE '$empresa_id'
and
vm.pop_id LIKE '$pop_id'
and
vm.ipaddress LIKE '$ipaddress'
and
vm.hostname LIKE '%$hostname%'
and
vm.servidor_id LIKE '$servidor'
and
vm.sistemaOperacional LIKE '$SO'
and
vm.statusvm LIKE '$statusvm'
ORDER BY
vm.hostname ASC

LIMIT $limiteBusca
";

?>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">

                <div class="card-body">

                    <div class="container">
                        <div class="row">
                            <div class="col-10">
                                <h5 class="card-title">Pesquisar</h5>
                            </div>

                            <div class="col-2">
                                <div class="card">
                                    <!-- Basic Modal -->
                                    <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalNovaVM">
                                        Cadastrar novo
                                    </button>
                                </div>
                            </div>
                            <div class="modal fade" id="modalNovaVM" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Novo cadastro</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card-body">
                                                <!-- Vertical Form -->
                                                <form method="POST" action="/telecom/credentials/vm/processa/add.php" class="row g-3">

                                                    <div class="col-6">
                                                        <label for="VMcadastroEmpresa" class="form-label">Empresa*</label>
                                                        <select id="VMcadastroEmpresa" name="VMcadastroEmpresa" class="form-select" required>
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
                                                        <label for="VMcadastroPop" class="form-label">POP*</label>
                                                        <select id="VMcadastroPop" name="VMcadastroPop" class="form-select" required>
                                                            <option selected disabled>Selecione o pop</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-4">
                                                        <label for="VMcadastroServidor" class="form-label">Servidor virtualizador*</label>
                                                        <select id="VMcadastroServidor" name="VMcadastroServidor" class="form-select" required>
                                                            <option selected disabled>Selecione o servidor</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-8"></div>

                                                    <hr class="sidebar-divider">

                                                    <div class="col-4">
                                                        <label for="VMcadastroHostname" class="form-label">Hostname*</label>
                                                        <input name="VMcadastroHostname" type="text" class="form-control" id="VMcadastroHostname" placeholder="Ex: vm01.ABCD" required>
                                                    </div>

                                                    <div class="col-4">
                                                        <label for="VMcadastroSO" class="form-label">Sistema operacional*</label>
                                                        <select id="VMcadastroSO" name="VMcadastroSO" class="form-select" required>
                                                            <option selected disabled>Selecione</option>>
                                                            <?php
                                                            $resultado = mysqli_query($mysqli, $sql_lista_so);
                                                            while ($so = mysqli_fetch_object($resultado)) :
                                                                echo "<option value='$so->id'> $so->so</option>";
                                                            endwhile;
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-4"></div>

                                                    <div class="col-3">
                                                        <label for="VMcadastroIPAddress" class="form-label">Endereço IP*</label>
                                                        <input id="VMcadastroIPAddress" name="VMcadastroIPAddress" type="text" class="form-control" placeholder="Ex: 192.168.1.1" maxlength="15" require>
                                                    </div>

                                                    <div class="col-4">
                                                        <label for="VMcadastroDomino" class="form-label">Dominio</label>
                                                        <input id="VMcadastroDomino" name="VMcadastroDomino" type="text" class="form-control" placeholder="Ex: server.dominio.com.br">
                                                    </div>

                                                    <div class="col-2">
                                                        <label for="VMcadastroVLAN" class="form-label">VLAN</label>
                                                        <input id="VMcadastroVLAN" name="VMcadastroVLAN" type="number" class="form-control" maxlength="4" placeholder="Ex: 3577">
                                                    </div>


                                                    <div class="col-3">
                                                        <label for="VMcadastroStatus" class="form-label">Status*</label>
                                                        <select id="VMcadastroStatus" name="VMcadastroStatus" class="form-select" required>
                                                            <option selected disabled>Selecione</option>>
                                                            <option value="Ativado">Ativado</option>
                                                            <option value="Em Implementação">Em Implementação</option>
                                                            <option value="Inativado">Inativado</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-3">
                                                        <label for="VMcadastroMemoria" class="form-label">Memória (Mb)*</label>
                                                        <input name="VMcadastroMemoria" type="number" class="form-control" id="VMcadastroMemoria" placeholder="4096" required>
                                                    </div>

                                                    <div class="col-2">
                                                        <label for="VMcadastroVCPU" class="form-label">vCPU*</label>
                                                        <input name="VMcadastroVCPU" type="number" class="form-control" id="VMcadastroVCPU" placeholder="4" required>
                                                    </div>

                                                    <div class="col-3">
                                                        <label for="VMcadastroDisco1" class="form-label">Disco partição 1 (Gb)*</label>
                                                        <input name="VMcadastroDisco1" type="number" class="form-control" id="VMcadastroDisco1" placeholder="120" required>
                                                    </div>

                                                    <div class="col-3">
                                                        <label for="VMcadastroDisco2" class="form-label">Disco partição 2 (Gb)</label>
                                                        <input name="VMcadastroDisco2" type="number" class="form-control" id="VMcadastroDisco2" placeholder="80">
                                                    </div>

                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-danger">Salvar</button>
                                                        <button type="reset" class="btn btn-secondary">Limpar</button>
                                                    </div>
                                                </form><!-- Vertical Form -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- End Basic Modal-->
                        </div>
                    </div>

                    <form method="POST" action="#" class="row g-3">

                        <input type="hidden" id="tabVM" name="tabVM">

                        <div class="col-4">
                            <label for="VMempresaPesquisa" class="form-label">Empresa</label>
                            <select id="VMempresaPesquisa" name="VMempresaPesquisa" class="form-select">
                                <option selected disabled>Selecione a empresa</option>
                                <?php
                                $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                while ($empresa = mysqli_fetch_object($resultado)) :
                                    echo "<option value='$empresa->id'> $empresa->empresa</option>";
                                endwhile;

                                if ($_SERVER["REQUEST_METHOD"] == 'POST') :

                                ?>
                                    <script>
                                        let nomeEmpresa = '<?= $_POST['VMempresaPesquisa']; ?>'
                                        if (nomeEmpresa == '%') {} else {
                                            document.querySelector("#VMempresaPesquisa").value = nomeEmpresa
                                        }
                                    </script>
                                <?php
                                endif;
                                ?>
                            </select>
                        </div>

                        <div class="col-3">
                            <label for="VMpopPesquisa" class="form-label">POP</label>
                            <select id="VMpopPesquisa" name="VMpopPesquisa" class="form-select">
                                <option selected disabled>Selecione a empresa</option>
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
                            <label for="VMservidorPesquisa" class="form-label">Servidor</label>
                            <select id="VMservidorPesquisa" name="VMservidorPesquisa" class="form-select">
                                <option selected disabled>Selecione primeiro o pop</option>
                            </select>
                        </div>

                        <div class="col-3">
                            <label for="SOPesquisa" class="form-label">Sistema Operacional</label>
                            <select id="SOPesquisa" name="SOPesquisa" class="form-select">
                                <option selected disabled>Selecione o SO</option>
                                <?php
                                $resultado = mysqli_query($mysqli, $sql_lista_so);
                                while ($so = mysqli_fetch_object($resultado)) :
                                    echo "<option value='$so->id'> $so->so</option>";
                                endwhile;

                                if ($_SERVER["REQUEST_METHOD"] == 'POST') :

                                ?>
                                    <script>
                                        let so = '<?= $_POST['SOPesquisa']; ?>'
                                        if (so == '%') {} else {
                                            document.querySelector("#SOPesquisa").value = so
                                        }
                                    </script>
                                <?php
                                endif;
                                ?>
                            </select>
                        </div>

                        <div class="col-3">
                            <label for="statusVMPesquisa" class="form-label">Status</label>
                            <select id="statusVMPesquisa" name="statusVMPesquisa" class="form-select" required>
                                <option selected disabled>Ativado</option>>
                                <option value="Ativado">Ativado</option>
                                <option value="Em Implementação">Em Implementação</option>
                                <option value="Inativado">Inativado</option>

                                <?php if ($_SERVER["REQUEST_METHOD"] == 'POST') : ?>
                                    <script>
                                        let status = '<?= $_POST['statusVMPesquisa']; ?>'
                                        if (status == 'Ativado') {} else {
                                            document.querySelector("#statusVMPesquisa").value = status
                                        }
                                    </script>
                                <?php
                                endif;
                                ?>

                            </select>
                        </div>

                        <div class="col-6">
                            <button style="margin-top: 15px; " type="submit" class="btn btn-danger">Filtrar</button>
                        </div>

                    </form>

                    <hr class="sidebar-divider">

                    <table class="table table-striped" id="styleTable">
                        <thead>
                            <tr>
                                <th style="text-align: center;" scope="col">Hostname</th>
                                <th style="text-align: center;" scope="col">Empresa / POP</th>
                                <th style="text-align: center;" scope="col">Servidor</th>
                                <th style="text-align: center;" scope="col">Endereço IP</th>
                                <th style="text-align: center;" scope="col">Sistema Operacional</th>
                                <th style="text-align: center;" scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Preenchendo a tabela com os dados do banco: -->
                            <?php
                            $resultado = mysqli_query($mysqli, $sql_pesquisa_vms) or die("Erro ao retornar dados");

                            // Obtendo os dados por meio de um loop while
                            while ($campos = $resultado->fetch_array()) {
                                $id = $campos['idvm']; ?>
                                <tr>

                                    <td style="text-align: center;">
                                        <a style="color: red;" href="vm/view.php?id=<?= $campos['idvm']; ?>"><?= $campos['hostname']; ?></a>
                                    </td>

                                    <td style="text-align: center;"><?php echo $campos['empresa']; ?> / <?php echo $campos['pop']; ?></td>
                                    <td style="text-align: center;"><?php echo $campos['servidor']; ?></td>
                                    <td style="text-align: center;"><?php echo $campos['ipaddress']; ?></td>
                                    <td style="text-align: center;"><?php echo $campos['sistemaOperacional']; ?></td>
                                    <td style="text-align: center;" style="text-align: center;"><?= $campos['statusvm']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>

        </div>
    </div>
</section>


<?php
/* require "../../scripts/vms.php"; */
?> 