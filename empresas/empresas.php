<?php
require '../includes/menu.php';
require '../conexoes/conexao.php';
require "../conexoes/conexao_pdo.php";
require '../conexoes/sql.php';
require '../includes/remove_setas_number.php';

$uid = $_SESSION['id'];
$page_type = "menu";
$menu_submenu_id = "2";


if ($page_type == "submenu") {
    $permissions =
        "SELECT 
	u.perfil_id
FROM 
	usuarios u
JOIN 
	perfil_permissoes_submenu pp
ON 
	u.perfil_id = pp.perfil_id
WHERE
	u.id = $uid
AND 
	pp.url_submenu = $menu_submenu_id";
} else if ($page_type == "menu") {
    $permissions =
        "SELECT 
	u.perfil_id
FROM 
	usuarios u
JOIN 
	perfil_permissoes_menu pp
ON 
	u.perfil_id = pp.perfil_id
WHERE
	u.id = $uid
AND 
	pp.url_menu = $menu_submenu_id";
}
$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {

?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Empresas</h1>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="card-title">Cadastro de empresas</h5>
                                    </div>
                                    <div class="col-2"></div>
                                    <div class="col-2">
                                        <div class="card">
                                            <!-- Basic Modal -->
                                            <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                                Nova empresa
                                            </button>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="basicModal" tabindex="-1">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Nova empresa</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="card-body">
                                                        <!-- Vertical Form -->
                                                        <form method="POST" id="cadastrarEmpresa" class="row g-3">
                                                            <span id="msgCadastrarEmpresa"></span>
                                                            <div class="col-6">
                                                                <label for="razaoSocial" class="form-label">Razão Social</label>
                                                                <input name="razaoSocial" type="text" class="form-control" id="razaoSocial" required>
                                                            </div>

                                                            <div class="col-6">
                                                                <label for="fantasia" class="form-label">Fantasia</label>
                                                                <input name="fantasia" type="text" class="form-control" id="fantasia" required>
                                                            </div>

                                                            <div class="col-6">
                                                                <label for="cnpj" class="form-label">CNPJ</label>
                                                                <input name="cnpj" type="text" class="form-control" id="cnpj" required>
                                                            </div>

                                                            <div class="col-6">
                                                                <label for="email" class="form-label">E-mail</label>
                                                                <input name="email" type="text" class="form-control" id="email" required>

                                                            </div>

                                                            <div class="col-6">
                                                                <label for="telefone" class="form-label">Tefone</label>
                                                                <input name="telefone" type="text" class="form-control" id="telefone">
                                                            </div>

                                                            <div class="col-6">
                                                                <label for="celular" class="form-label">Celular</label>
                                                                <input name="celular" type="text" class="form-control" id="celular" required>
                                                            </div>

                                                            <hr class="sidebar-divider">
                                                            <li class="nav-heading" style="list-style: none;">Atributos</li>

                                                            <div class="col-6">
                                                                <ul class="list-group" style="list-style: none;">
                                                                    <li> <input class="form-check-input me-1" name="atributoCliente" type="checkbox" value="1"> Cliente</li>
                                                                    <li> <input class="form-check-input me-1" name="atributoEmpresaPropria" type="checkbox" value="1"> Empresa Própria</li>
                                                                    <li> <input class="form-check-input me-1" name="atributoFornecedor" type="checkbox" value="1"> Fornecedor</li>
                                                                </ul>
                                                            </div>

                                                            <div class="col-6">
                                                                <ul class="list-group" style="list-style: none;">
                                                                    <li> <input class="form-check-input me-1" name="atributoPrestadorServico" type="checkbox" value="1"> Prestador de Serviço</li>
                                                                    <li> <input class="form-check-input me-1" name="atributoTransportadora" type="checkbox" value="1"> Transportadora</li>
                                                                </ul>
                                                            </div>

                                                            <hr class="sidebar-divider">
                                                            <li class="nav-heading" style="list-style: none;">Localização</li>

                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <label for="cep" class="form-label">CEP</label>
                                                                    <input name="cep" type="text" class="form-control" id="cep" onblur="buscarEnderecoPorCep()" required>
                                                                </div>

                                                                <div class="col-4">
                                                                    <label for="ibgecode" class="form-label">Código IBGE</label>
                                                                    <input name="ibgecode" type="text" class="form-control" id="ibgecode" readonly>
                                                                </div>
                                                            </div>
                                                            <p style='color:red;' id="mensagem-erro"></p>
                                                            <div class="col-4">
                                                                <label for="inputLogradouro" class="form-label">Logradouro</label>
                                                                <input name="logradouro" type="text" class="form-control" id="logradouro" readonly required>
                                                            </div>

                                                            <div class="col-4">
                                                                <label for="inputBairro" class="form-label">Bairro</label>
                                                                <input name="bairro" type="text" class="form-control" id="bairro" readonly>
                                                            </div>

                                                            <div class="col-4">
                                                                <label for="inputCidade" class="form-label">Cidade</label>
                                                                <input name="cidade" type="text" class="form-control" id="cidade" readonly>
                                                            </div>

                                                            <div class="col-4">
                                                                <label for="inputEstado" class="form-label">Estado</label>
                                                                <input name="estado" type="text" class="form-control" id="estado" readonly>
                                                            </div>


                                                            <div class="col-2">
                                                                <label for="numero" class="form-label">Número</label>
                                                                <input name="numero" type="number" class="form-control" id="numero" required>
                                                            </div>

                                                            <div class="col-4">
                                                                <label for="complemento" class="form-label">Complemento</label>
                                                                <input name="complemento" type="text" class="form-control" id="complemento">
                                                            </div>

                                                            <hr class="sidebar-divider">

                                                            <div class="text-center">

                                                                <input id="btnSalvar" name="btnSalvar" type="button" value="Salvar" class="btn btn-danger"></input>
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

                            <p>Listagem de empresas</p>

                            <!-- Table with stripped rows -->
                            <table class="table table-striped" id="styleTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Razão Social</th>
                                        <th scope="col">Fantasia</th>
                                        <th scope="col">CNPJ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Preenchendo a tabela com os dados do banco: -->
                                    <?php
                                    $resultado = mysqli_query($mysqli, $sql_empresas) or die("Erro ao retornar dados");
                                    // Obtendo os dados por meio de um loop while
                                    while ($campos = $resultado->fetch_array()) {
                                        $id = $campos['id']; ?>
                                        <tr>


                                            <td style="text-align: center;">
                                                <a style="color: red;" href="view.php?id=<?= $campos['id'] ?>"><?= $campos['razaoSocial']; ?></a>
                                            </td>

                                            <td><?= $campos['fantasia']; ?></td>
                                            <td><?= $campos['cnpj']; ?></td>
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

    </main><!-- End #main -->

<?php
    require 'js.php';
} else {
    require "../acesso_negado.php";
}
require "../includes/securityfooter.php";
?>