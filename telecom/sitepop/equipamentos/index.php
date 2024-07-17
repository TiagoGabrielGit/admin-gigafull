<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$menu_id = "35";
$uid = $_SESSION['id'];
$empresa_usuario = $_SESSION['empresa_id'];
$permissions_menu =
    "SELECT  u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_menu pp ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_menu = $menu_id";

$exec_permissions_menu = $pdo->prepare($permissions_menu);
$exec_permissions_menu->execute();

$rowCount_permissions_menu = $exec_permissions_menu->rowCount();
$permissao_equipamentos_pop = $_SESSION['permissao_equipamentos_pop'];


if (($rowCount_permissions_menu > 0) & ($permissao_equipamentos_pop != 0)) {

    if (empty($_POST['EquipamentoEmpresaPesquisa'])) {
        if ($permissao_equipamentos_pop == 1) {
            $_POST['EquipamentoEmpresaPesquisa'] = $empresa_usuario;
        } else if ($permissao_equipamentos_pop == 2) {
            $_POST['EquipamentoEmpresaPesquisa'] = "%";
        }
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

?>
    <style>
        /* CSS para mudar a cor de fundo da linha ao passar o mouse */
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
            /* Escolha a cor que desejar */
            cursor: pointer;
        }
    </style>


    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-10">
                            <h5 class="card-title">Equipamentos POP</h5>
                        </div>

                        <div class="col-2">
                            <div class="card">
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
                                            <form method="POST" action="processa/adiciona_equipamento.php" class="row g-3">

                                                <div class="col-4">
                                                    <label for="EquipamentocadastroEmpresa" class="form-label">Empresa*</label>
                                                    <select id="EquipamentocadastroEmpresa" name="EquipamentocadastroEmpresa" class="form-select" required>
                                                        <option selected disabled value="">Selecione a empresa</option>
                                                        <?php
                                                        if ($permissao_equipamentos_pop == 1) {
                                                            $sql_lista_empresas =
                                                                "SELECT emp.id as id, emp.fantasia as empresa
                                                                    FROM empresas as emp
                                                                    WHERE emp.deleted = 1 AND id = $empresa_usuario
                                                                    ORDER BY emp.fantasia ASC";
                                                        } else if ($permissao_equipamentos_pop == 2) {
                                                            $sql_lista_empresas =
                                                                "SELECT emp.id as id, emp.fantasia as empresa
                                                                        FROM empresas as emp
                                                                        WHERE emp.deleted = 1
                                                                        ORDER BY emp.fantasia ASC";
                                                        }
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
                                                        <option selected disabled value="">Selecione o pop</option>
                                                    </select>
                                                </div>

                                                <hr class="sidebar-divider">

                                                <div class="col-4">
                                                    <label for="EquipamentoCadastroFabricante" class="form-label">Fabricante*</label>
                                                    <select id="EquipamentoCadastroFabricante" name="EquipamentoCadastroFabricante" class="form-select" required>
                                                        <option selected disabled value="">Selecione o fabricante</option>
                                                        <?php
                                                        $sql_lista_fabricantes =
                                                            "SELECT fab.id as id, fab.fabricante as fabricante
                                                        FROM fabricante as fab
                                                        WHERE fab.deleted = 1
                                                        ORDER BY fab.fabricante ASC";
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
                                                        <option selected disabled value="">Selecione o status</option>>
                                                        <option value="Ativado">Ativado</option>
                                                        <option value="Em Implementação">Em Implementação</option>
                                                        <option value="Inativado">Inativado</option>
                                                    </select>
                                                </div>
                                                <hr class="sidebar-divider">

                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-sm btn-danger">Salvar</button>
                                                    <a href="/telecom/sitepop/equipamentos/index.php"> <input type="button" value="Voltar" class="btn btn-sm btn-secondary"></input></a>
                                                </div>
                                            </form><!-- Vertical Form -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Basic Modal-->
                    </div>

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
                                $sql_lista_tipos =
                                    "SELECT tipo.id as id, tipo.tipo as tipo
                                        FROM tipoequipamento as tipo
                                        WHERE tipo.deleted = 1
                                        ORDER BY tipo.tipo ASC";

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
                                $sql_lista_fabricantes =
                                    "SELECT fab.id as id, fab.fabricante as fabricante
                                FROM fabricante as fab
                                WHERE fab.deleted = 1
                                ORDER BY fab.fabricante ASC";

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
                        <br>
                        <div class="text-center">
                            <button style="margin-top: 30px; " type="submit" class="btn btn-sm btn-danger">Filtrar</button>
                        </div>

                    </form>

                    <hr class="sidebar-divider">

                    <table class="table table-striped table-hover">
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
                            <?php
                            $sql_pesquisa_EquipamentosPop =
                                "SELECT
                            equipop.id as id_equipop,
                            equipop.hostname as hostname,
                            equipop.tipoEquipamento_id as tipoid,
                            equipop.ipaddress as ipaddress,
                            equipop.deleted as deleted,
                            equipop.usuario_criador as usuario_criador,
                            equipop.privacidade as privacidade,
                            equipop.criado as criado,
                            equipop.modificado as modificado,
                            equipop.statusEquipamento as statuseqp,
                            emp.fantasia as empresa,
                            eqp.equipamento as equipamento,
                            pop.pop as pop
                            FROM equipamentospop as equipop
                            LEFT JOIN empresas as emp ON equipop.empresa_id = emp.id
                            LEFT JOIN equipamentos as eqp ON eqp.id = equipop.equipamento_id
                            LEFT JOIN pop as pop ON pop.id = equipop.pop_id
                            WHERE 
                            equipop.empresa_id LIKE '$empresa_id' and
                            equipop.pop_id LIKE '$pop_id' and
                            equipop.ipaddress LIKE '$ipaddress' and
                            equipop.hostname LIKE '%$hostname%' and
                            equipop.tipoEquipamento_id LIKE '$tipoEquipamentoPesquisa' and
                            equipop.equipamento_id LIKE '$equipamento_id' and
                            eqp.fabricante LIKE '$fabricante_id' and
                            equipop.statusEquipamento LIKE '$statusEquipamentoPesquisa' and
                            equipop.deleted = 1
                            ORDER BY
                            equipop.hostname ASC
                            LIMIT $limiteBusca";

                            $resultado = mysqli_query($mysqli, $sql_pesquisa_EquipamentosPop) or die("Erro ao retornar dados");

                            while ($campos = $resultado->fetch_array()) {
                                $id = $campos['id_equipop'];

                                if (($campos['usuario_criador'] == $_SESSION['id']) || ($campos['privacidade'] == 1)) {
                            ?>
                                    <tr onclick="window.location.href='view.php?id=<?= $id ?>'">
                                        <td style="text-align: center;"><?= $campos['hostname']; ?></td>
                                        <td style="text-align: center;"><?= $campos['empresa']; ?> / <?= $campos['pop']; ?></td>
                                        <td style="text-align: center;"><?= $campos['ipaddress']; ?></td>
                                        <td style="text-align: center;"><?= $campos['equipamento']; ?></td>
                                        <td style="text-align: center;"><?= $campos['statuseqp']; ?></td>
                                    </tr>
                                    <?php } else {
                                    $sql_check_perm_user = "SELECT * FROM equipamentos_pop_privacidade_usuario WHERE equipamento_id = :id AND usuario_id = :userId";
                                    $stmt_check_perm_user = $pdo->prepare($sql_check_perm_user);
                                    $stmt_check_perm_user->bindParam(':id', $id, PDO::PARAM_INT);
                                    $stmt_check_perm_user->bindParam(':userId', $_SESSION['id'], PDO::PARAM_INT);
                                    $stmt_check_perm_user->execute();

                                    $sql_check_perm_equipe = "SELECT * FROM equipamentos_pop_privacidade_equipe WHERE equipamento_id = :id AND equipe_id IN (SELECT equipe_id FROM equipes_integrantes WHERE integrante_id = :userId)";
                                    $stmt_check_perm_equipe = $pdo->prepare($sql_check_perm_equipe);
                                    $stmt_check_perm_equipe->bindParam(':id', $id, PDO::PARAM_INT);
                                    $stmt_check_perm_equipe->bindParam(':userId', $_SESSION['id'], PDO::PARAM_INT);
                                    $stmt_check_perm_equipe->execute();

                                    if ($stmt_check_perm_user->rowCount() > 0 || $stmt_check_perm_equipe->rowCount() > 0) { ?>
                                        <tr onclick="window.location.href='view.php?id=<?= $id ?>'">
                                            <td style="text-align: center;"><?= $campos['hostname']; ?></td>
                                            <td style="text-align: center;"><?= $campos['empresa']; ?> / <?= $campos['pop']; ?></td>
                                            <td style="text-align: center;"><?= $campos['ipaddress']; ?></td>
                                            <td style="text-align: center;"><?= $campos['equipamento']; ?></td>
                                            <td style="text-align: center;"><?= $campos['statuseqp']; ?></td>
                                        </tr>
                            <?php }
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <script>
        $(document).ready(function() {
            $("#EquipamentoEmpresaPesquisa").change(function() {
                var empresaSelecionada = $(this).val();

                if (empresaSelecionada) {
                    $.ajax({
                        url: "/api/pesquisa_pop.php",
                        method: "GET",
                        dataType: "html",
                        data: {
                            id: empresaSelecionada
                        }
                    }).done(function(resposta) {
                        $("#popPesquisa").html(resposta);
                    }).fail(function(resposta) {
                        alert(resposta);
                    });
                }
            });
        });
    </script>

    <script>
        //Pesquisa os equipamentos atraves do fabricante
        $("#EquipamentoFabricantePesquisa").change(function() {
            var fabricanteSelecionado = $(this).children("option:selected").val();

            $.ajax({
                url: "/api/pesquisa_equipamentos.php",
                method: "GET",
                dataType: "HTML",
                data: {
                    id: fabricanteSelecionado
                }
            }).done(function(resposta) {
                $("#equipamentoPesquisa").html(resposta);
            }).fail(function(resposta) {
                alert(resposta)
            });
        });
    </script>

    <script>
        $("#EquipamentocadastroEmpresa").change(function() {
            var empresaSelecionada = $(this).children("option:selected").val();

            $.ajax({
                url: "/api/pesquisa_pop.php",
                method: "GET",
                dataType: "HTML",
                data: {
                    id: empresaSelecionada
                }
            }).done(function(resposta) {
                $("#EquipamentoCadastroPop").html(resposta);
            }).fail(function(resposta) {
                alert(resposta)
            });
        });
    </script>

    <script>
        //Pesquisa os equipamentos atraves do fabricante
        $("#EquipamentoCadastroFabricante").change(function() {
            var fabricanteSelecionado = $(this).children("option:selected").val();

            $.ajax({
                url: "/api/pesquisa_equipamentos.php",
                method: "GET",
                dataType: "HTML",
                data: {
                    id: fabricanteSelecionado
                }
            }).done(function(resposta) {
                $("#EquipamentocadastroEquipamento").html(resposta);
            }).fail(function(resposta) {
                alert(resposta)
            });
        });
    </script>

    <script>
        //Procura os tipos de equipamentos atraves do equipamento selecionado
        $("#EquipamentocadastroEquipamento").change(function() {
            var equipamentoSelecionado = $(this).children("option:selected").val();

            $.ajax({
                url: "/api/pesquisa_tipos.php",
                method: "GET",
                dataType: "HTML",
                data: {
                    id: equipamentoSelecionado
                }
            }).done(function(resposta) {
                $("#EquipamentoCadastroTipoEquipamento").html(resposta);
            }).fail(function(resposta) {
                alert(resposta)
            });
        });
    </script>
<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>