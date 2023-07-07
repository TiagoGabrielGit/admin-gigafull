<?php

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

?>

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
                                    <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalNovoPortal">
                                        Cadastrar novo
                                    </button>
                                </div>
                            </div>

                            <div class="modal fade" id="modalNovoPortal" tabindex="-1">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Novo cadastro</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card-body">

                                                <form method="POST" action="/telecom/credentials/portal/processa/add.php" class="row g-3">


                                                    <input name="usuarioCriador" type="text" class="form-control" id="usuarioCriador" value="<?php echo $_SESSION['id']; ?>" hidden>

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

                                                    <div class="col-lg-12">
                                                        <div class="col-6">
                                                            <label for="portalDescricao" class="form-label">Descrição</label>
                                                            <input name="portalDescricao" type="text" class="form-control" id="portalDescricao" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <label for="portalPaginaAcesso" class="form-label">Página de Acesso</label>
                                                                <input name="portalPaginaAcesso" type="text" class="form-control" id="portalPaginaAcesso" required>
                                                            </div>

                                                            <div class="col-4">
                                                                <label for="portalUsuario" class="form-label">Usuário</label>
                                                                <input name="portalUsuario" type="text" class="form-control" id="portalUsuario" required>
                                                            </div>

                                                            <div class="col-4">
                                                                <label for="portalSenha" class="form-label">Senha</label>
                                                                <input name="portalSenha" type="text" class="form-control" id="portalSenha" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="portalAnotacao" class="form-label">Anotações</label>
                                                        <textarea id="portalAnotacao" name="portalAnotacao" class="form-control" maxlength="10000" rows="4"></textarea>
                                                    </div>

                                                    <hr class="sidebar-divider">

                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-danger">Salvar</button>
                                                        <a href="/telecom/credentials/index.php"> <input type="button" value="Voltar" class="btn btn-secondary"></input></a>
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

                        <input type="hidden" id="tabportal" name="tabportal">

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
                                <th style="text-align: center;" scope="col">Descrição</th>
                                <th style="text-align: center;" scope="col">Empresa</th>
                                <th style="text-align: center;" scope="col">Usuário</th>
                                <th style="text-align: center;" scope="col">Privacidade</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            require "portal/pesquisa_portal.php";
                            ?>

                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>

        </div>
    </div>
</section>