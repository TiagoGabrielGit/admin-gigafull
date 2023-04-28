<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";

$id_elemento = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (empty($_POST['pesquisaTipo'])) {
    $_POST['pesquisaTipo'] = "%";
}

if (empty($_POST['empresaPesquisa'])) {
    $_POST['empresaPesquisa'] = "%";
}

if (empty($_POST['pesquisaDescricao'])) {
    $_POST['pesquisaDescricao'] = "%";
}

$varTipo = $_POST['pesquisaTipo'];
$varEmpresa = $_POST['empresaPesquisa'];
$varDescricao = $_POST['pesquisaDescricao'];

require "sql.php";

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Credenciais</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">

                    <div class="card-body">

                        <div class="container">
                            <div class="row">
                                <div class="col-10">
                                    <h5 class="card-title">Filtros</h5>
                                </div>

                                <div class="col-2">
                                    <div class="card">
                                        <!-- Basic Modal -->
                                        <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                            Cadastrar novo
                                        </button>
                                    </div>
                                </div>

                                <div class="modal fade" id="basicModal" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Novo cadastro</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card-body">

                                                    <!-- Vertical Form -->
                                                    <form id="addCredenciais" method="POST" class="row g-3">

                                                        <input name="usuarioCriador" type="text" class="form-control" id="usuarioCriador" value="<?php echo $_SESSION['id']; ?>" hidden>

                                                        <span id="msg"></span>

                                                        <div class="col-6">
                                                            <label for="cadastroEmpresa" class="form-label">Empresa*</label>
                                                            <select id="cadastroEmpresa" name="cadastroEmpresa" class="form-select" required>
                                                                <option value="" selected disabled>Selecione a empresa</option>
                                                                <?php
                                                                $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                                                while ($empresa = mysqli_fetch_object($resultado)) :
                                                                    echo "<option value='$empresa->id'> $empresa->empresa</option>";
                                                                endwhile;
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-3">
                                                            <label for="cadastroTipo" class="form-label">Tipo*</label>
                                                            <select id="cadastroTipo" name="cadastroTipo" class="form-select" required>
                                                                <option disabled selected value="">Selecione</option>>
                                                                <option value="email">E-mail</option>
                                                                <option value="portal">Portal</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-3">
                                                            <label for="cadastroPrivacidade" class="form-label">Privacidade*</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="cadastroPrivacidade" id="cadastroPrivacidade" value="1" checked="">
                                                                <label class="form-check-label" for="cadastroPrivacidade" value="1">Público</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="cadastroPrivacidade" id="cadastroPrivacidade" value="2">
                                                                <label class="form-check-label" for="cadastroPrivacidade" value="2">Privado</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="cadastroPrivacidade" id="cadastroPrivacidade" value="3">
                                                                <label class="form-check-label" for="cadastroPrivacidade" value="3">Somente eu</label>
                                                            </div>

                                                        </div>

                                                        <hr class="sidebar-divider">

                                                        <div class="container" id="formularioCredenciais">
                                                            <div class="row" id="portal">

                                                                <div class="col-8" style="display: inline-block;">
                                                                    <label for="portalPaginaAcesso" class="form-label">Página de Acesso</label>
                                                                    <input name="portalPaginaAcesso" type="text" class="form-control" id="portalPaginaAcesso">
                                                                </div>

                                                                <div class="col-6" style="display: inline-block;">
                                                                    <label for="portalDescricao" class="form-label">Descrição</label>
                                                                    <input name="portalDescricao" type="text" class="form-control" id="portalDescricao">
                                                                </div>

                                                                <div class="col-4" style="display: inline-block;"> </div>

                                                                <div class="col-6" style="display: inline-block;">
                                                                    <label for="portalUsuario" class="form-label">Usuário</label>
                                                                    <input name="portalUsuario" type="text" class="form-control" id="portalUsuario">
                                                                </div>

                                                                <div class="col-5" style="display: inline-block;">
                                                                    <label for="portalSenha" class="form-label">Senha</label>
                                                                    <input name="portalSenha" type="text" class="form-control" id="portalSenha">
                                                                </div>

                                                                <div class="col-12">
                                                                    <label for="portalAnotacao" class="form-label">Anotações</label>
                                                                    <textarea id="portalAnotacao" name="portalAnotacao" class="form-control" maxlength="10000" rows="4"></textarea>
                                                                </div>

                                                            </div>


                                                            <div class="row" id="email">

                                                                <div class="col-8" style="display: inline-block;">
                                                                    <label for="acessoWebmail" class="form-label">Webmail</label>
                                                                    <input name="acessoWebmail" type="text" class="form-control" id="acessoWebmail">
                                                                </div>

                                                                <div class="col-6" style="display: inline-block;">
                                                                    <label for="emailDescricao" class="form-label">Descrição</label>
                                                                    <input name="emailDescricao" type="text" class="form-control" id="emailDescricao">
                                                                </div>

                                                                <div class="col-4" style="display: inline-block;"> </div>

                                                                <div class="col-6" style="display: inline-block;">
                                                                    <label for="emailUsuario" class="form-label">E-mail</label>
                                                                    <input name="emailUsuario" type="text" class="form-control" id="emailUsuario">
                                                                </div>

                                                                <div class="col-5" style="display: inline-block;">
                                                                    <label for="emailSenha" class="form-label">Senha</label>
                                                                    <input name="emailSenha" type="text" class="form-control" id="emailSenha">
                                                                </div>

                                                                <div class="col-12">
                                                                    <label for="emailAnotacao" class="form-label">Anotações</label>
                                                                    <textarea id="emailAnotacao" name="emailAnotacao" class="form-control" maxlength="10000" rows="4"></textarea>
                                                                </div>

                                                            </div>


                                                        </div>

                                                        <hr class="sidebar-divider">

                                                        <div class="text-center">
                                                            <input id="btnSalvar" name="btnSalvar" type="button" value="Salvar" class="btn btn-danger"></input>
                                                            <a href="/telecom/credenciais/index.php"> <input type="button" value="Voltar" class="btn btn-secondary"></input></a>
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

                            <div class="col-4">
                                <label for="empresaPesquisa" class="form-label">Empresa</label>
                                <select id="empresaPesquisa" name="empresaPesquisa" class="form-select">
                                    <option value="%" selected>Todas</option>
                                    <?php
                                    $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                    while ($empresa = mysqli_fetch_object($resultado)) :
                                        echo "<option value='$empresa->id'> $empresa->empresa</option>";
                                    endwhile;

                                    if ($_SERVER["REQUEST_METHOD"] == 'POST') :

                                    ?>
                                        <script>
                                            let nomeEmpresa = '<?= $_POST['empresaPesquisa']; ?>'
                                            if (nomeEmpresa == '%') {} else {
                                                document.querySelector("#empresaPesquisa").value = nomeEmpresa
                                            }
                                        </script>
                                    <?php
                                    endif;
                                    ?>
                                </select>
                            </div>


                            <div class="col-2">
                                <label for="pesquisaTipo" class="form-label">Tipo</label>
                                <select id="pesquisaTipo" name="pesquisaTipo" class="form-select">
                                    <option select value="%">Todos</option>
                                    <option value="email">E-mail</option>
                                    <option value="portal">Portal</option>

                                    <?php
                                    if ($_SERVER["REQUEST_METHOD"] == 'POST') :
                                    ?>
                                        <script>
                                            let pesquisaTipo = '<?= $_POST['pesquisaTipo']; ?>'
                                            if (pesquisaTipo == '%') {} else {
                                                document.querySelector("#pesquisaTipo").value = pesquisaTipo
                                            }
                                        </script>
                                    <?php
                                    endif;
                                    ?>
                                </select>
                            </div>

                            <div class="col-4">
                                <label for="pesquisaDescricao" class="form-label">Descrição</label>
                                <input name="pesquisaDescricao" type="text" class="form-control" id="pesquisaDescricao">
                                <?php
                                if ($_SERVER["REQUEST_METHOD"] == 'POST') :
                                ?>
                                    <script>
                                        let pesquisaDescricao = '<?= $_POST['pesquisaDescricao']; ?>'
                                        if (pesquisaDescricao == '%') {} else {
                                            document.querySelector("#pesquisaDescricao").value = pesquisaDescricao
                                        }
                                    </script>
                                <?php
                                endif;
                                ?>
                            </div>

                            <div class="col-2"></div>

                            <div class="col-6">
                                <button style="margin-top: 15px; " type="submit" class="btn btn-danger">Filtrar</button>
                            </div>

                        </form>

                        <hr class="sidebar-divider">

                        <table class="table table-striped" id="styleTable">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" scope="col">Empresa</th>
                                    <th style="text-align: center;" scope="col">Tipo</th>
                                    <th style="text-align: center;" scope="col">Descrição</th>
                                    <th style="text-align: center;" scope="col">Usuário</th>
                                    <th style="text-align: center;" scope="col">Privacidade</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                require "pesquisa_email.php";
                                require "pesquisa_portal.php";
                                ?>

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
require "../../scripts/credenciais.php";
require "../../includes/footer.php";
?>