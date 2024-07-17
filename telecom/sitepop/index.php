<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$menu_id = "6";
$uid = $_SESSION['id'];
$empresa_usuario = $_SESSION['empresa_id'];

$permissions_menu =
    "SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_menu pp ON u.perfil_id = pp.perfil_id 
    WHERE u.id = $uid AND pp.url_menu = $menu_id";

$exec_permissions_menu = $pdo->prepare($permissions_menu);
$exec_permissions_menu->execute();

$rowCount_permissions_menu = $exec_permissions_menu->rowCount();
$permissao_pop_site = $_SESSION['permissao_pop_site'];

if (($rowCount_permissions_menu > 0) & ($permissao_pop_site != 0)) {


    if (empty($_POST['permissao_pop_site'])) {
        if ($permissao_pop_site == 1) {
            $_POST['permissao_pop_site'] = $empresa_usuario;
        } else if ($permissao_pop_site == 2) {
            $_POST['permissao_pop_site'] = "%";
        }
    }

    $empresa_id = $_POST['permissao_pop_site'];


    if ($permissao_pop_site == 1) {
        $sql_lista_empresas =
            "SELECT emp.id as id, emp.fantasia as empresa
                    FROM empresas as emp
                    WHERE emp.deleted = 1 AND id = $empresa_usuario
                    ORDER BY emp.fantasia ASC";
    } else if ($permissao_pop_site == 2) {
        $sql_lista_empresas =
            "SELECT emp.id as id, emp.fantasia as empresa
                        FROM empresas as emp
                        WHERE emp.deleted = 1
                        ORDER BY emp.fantasia ASC";
    }


    $sql_lista_pops =
        "SELECT
        pop.id as id,
        pop.pop as pop,
        pop.apelidoPop as apelidoPop,
        emp.fantasia as empresa,
        endereco.city as cidade
        FROM pop as pop
        LEFT JOIN pop_address as endereco ON endereco.pop_id = pop.id
        LEFT JOIN empresas as emp ON emp.id = pop.empresa_id
        WHERE pop.active = 1 AND pop.empresa_id LIKE '$empresa_id'       
        ORDER BY emp.fantasia asc, pop.pop asc";
?>

    <style>
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
    </style>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>POP / SITE</h1>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <h5 class="card-title">Listagem de POPs</h5>
                                </div>
                                <div class="col-3">
                                    <div class="card">
                                        <button style="margin-top: 15px" type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalNovoPOP">
                                            Novo POP
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <p>Listagem completa de POPs</p>

                            <table class="table table-striped  table-hover">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">POP</th>
                                        <th style="text-align: center;">Melhorias</th>
                                        <th style="text-align: center;">Empresa</th>
                                        <th style="text-align: center;">Cidade</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $resultado = mysqli_query($mysqli, $sql_lista_pops) or die("Erro ao retornar dados");

                                    while ($campos = $resultado->fetch_array()) {
                                        $id = $campos['id'];
                                        $sql_melhorias = "SELECT COUNT(*) AS total_melhorias FROM pop_melhorias_conhecidas WHERE status = :status and pop_id = :id";
                                        $stmt = $pdo->prepare($sql_melhorias);
                                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                                        $stmt->bindValue(':status', '1', PDO::PARAM_INT);
                                        $stmt->execute();
                                        $dados_melhorias = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $total_melhorias = $dados_melhorias['total_melhorias'];


                                    ?>
                                        <tr onclick="window.location.href='view_informacoes.php?id=<?= $id ?>'">
                                            <td style="text-align: center;"><?= $campos['pop']; ?></td>
                                            <td style="text-align: center;">
                                                <?php if ($total_melhorias > 0) { ?>
                                                    <h6>
                                                        <span title="Melhorias Conhecidas" class="badge bg-danger"><?= $total_melhorias ?></span>
                                                    </h6>
                                                <?php } ?>
                                            </td>
                                            <td style="text-align: center;"><?= $campos['empresa']; ?></td>
                                            <td style="text-align: center;"><?= $campos['cidade']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#cep').inputmask('99999-999');
        });
    </script>

    <script>
        function buscarEnderecoPorCep() {
            var cep = document.getElementById('cep').value;

            // Fazer a chamada à API de CEP
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {
                    if (data.erro) {
                        throw new Error('CEP incorreto');
                    }
                    preencherCamposEndereco(data);
                })
                .catch(error => exibirErro(error));
        }

        function exibirErro(error) {
            console.error(error);
            var mensagemErro = document.getElementById('mensagem-erro');
            mensagemErro.textContent = 'CEP incorreto. Por favor, verifique o valor digitado.';

            document.getElementById('ibgecode').value = '';
            document.getElementById('logradouro').value = '';
            document.getElementById('bairro').value = '';
            document.getElementById('cidade').value = '';
            document.getElementById('estado').value = '';
            document.getElementById('ibgecode').readOnly = true;
            document.getElementById('logradouro').readOnly = true;
            document.getElementById('bairro').readOnly = true;
            document.getElementById('cidade').readOnly = true;
            document.getElementById('estado').readOnly = true;

            // Remover mensagem de erro após 2 segundos
            setTimeout(() => {
                mensagemErro.textContent = '';
            }, 2000);
        }

        function preencherCamposEndereco(data) {
            if (!data.erro) {
                if (data.logradouro !== '') {
                    document.getElementById('logradouro').value = data.logradouro;
                    document.getElementById('logradouro').readOnly = true;
                } else {
                    document.getElementById('logradouro').value = "";
                    document.getElementById('logradouro').readOnly = false;
                }

                if (data.bairro !== '') {
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('bairro').readOnly = true;
                } else {
                    document.getElementById('bairro').value = "";
                    document.getElementById('bairro').readOnly = false;
                }

                document.getElementById('cidade').value = data.localidade;
                document.getElementById('cidade').readOnly = true;
                document.getElementById('estado').value = data.uf;
                document.getElementById('estado').readOnly = true;
                document.getElementById('ibgecode').value = data.ibge;
                document.getElementById('ibgecode').readOnly = true;
            } else {
                // Desbloquear todos os campos caso o endereço não seja encontrado
                document.getElementById('logradouro').readOnly = false;
                document.getElementById('bairro').readOnly = false;
                document.getElementById('cidade').readOnly = false;
                document.getElementById('estado').readOnly = false;
            }
        }
    </script>

    <div class="modal fade" id="modalNovoPOP" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo POP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="card-body">
                        <!-- Vertical Form -->
                        <form method="POST" action="processa/criar_pop.php" class="row g-3">
                            <li class="nav-heading" style="list-style: none;">Dados</li>

                            <div class="col-3">
                                <label for="pop" class="form-label">POP*</label>
                                <input name="pop" type="text" class="form-control" id="pop" required>
                            </div>

                            <div class="col-5">
                                <label for="description" class="form-label">Descrição*</label>
                                <input name="description" type="text" class="form-control" id="description" required>
                            </div>

                            <div class="col-4">
                                <label for="empresa" class="form-label">Empresa*</label>
                                <select id="empresa" name="empresa" class="form-select" required>
                                    <option selected disabled value="">Selecione a empresa</option>
                                    <?php
                                    $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                    while ($empresa = mysqli_fetch_object($resultado)) :
                                        echo "<option value='$empresa->id'> $empresa->empresa</option>";
                                    endwhile;
                                    ?>
                                </select>
                            </div>

                            <hr class="sidebar-divider">
                            <li class="nav-heading" style="list-style: none;">Localização</li>


                            <div class="row">
                                <div class="col-4">
                                    <label for="cep" class="form-label">CEP*</label>
                                    <input name="cep" type="text" class="form-control" id="cep" onblur="buscarEnderecoPorCep()" required>
                                </div>

                                <div class="col-4">
                                    <label for="ibgecode" class="form-label">Código IBGE</label>
                                    <input name="ibgecode" type="text" class="form-control" id="ibgecode" readonly>
                                </div>
                            </div>
                            <p style='color:red;' id="mensagem-erro"></p>
                            <div class="col-4">
                                <label for="inputLogradouro" class="form-label">Logradouro*</label>
                                <input name="logradouro" type="text" class="form-control" id="logradouro" readonly required>
                            </div>

                            <div class="col-4">
                                <label for="inputBairro" class="form-label">Bairro*</label>
                                <input name="bairro" type="text" class="form-control" id="bairro" readonly required>
                            </div>

                            <div class="col-4">
                                <label for="inputCidade" class="form-label">Cidade*</label>
                                <input name="cidade" type="text" class="form-control" id="cidade" readonly>
                            </div>

                            <div class="col-4">
                                <label for="inputEstado" class="form-label">Estado*</label>
                                <input name="estado" type="text" class="form-control" id="estado" readonly>
                            </div>


                            <div class="col-2">
                                <label for="numero" class="form-label">Número*</label>
                                <input name="numero" type="number" class="form-control" id="numero" required>
                            </div>

                            <div class="col-4">
                                <label for="complemento" class="form-label">Complemento</label>
                                <input name="complemento" type="text" class="form-control" id="complemento">
                            </div>

                            <hr class="sidebar-divider">

                            <div class="text-center">
                                <button class="btn btn-sm btn-danger" type="submit">Salvar</button>
                                <button type="reset" class="btn btn-sm btn-secondary">Limpar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>