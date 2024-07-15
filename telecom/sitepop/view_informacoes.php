<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$usuarioID = $_SESSION['id'];
$idPOP = $_GET['id'];

$menu_id = "6";
$uid = $_SESSION['id'];

$permissions_menu =
    "SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_menu pp ON u.perfil_id = pp.perfil_id 
    WHERE u.id = $uid AND pp.url_menu = $menu_id";

$exec_permissions_menu = $pdo->prepare($permissions_menu);
$exec_permissions_menu->execute();

$rowCount_permissions_menu = $exec_permissions_menu->rowCount();

if ($rowCount_permissions_menu > 0) {
$sql_pop =
    "SELECT
    pop.id as id,
    pop.pop as pop,
    pop.apelidoPop as apelidoPop,
    endereco.city as cidade,
    emp.fantasia as empresa,
    emp.id as id_empresa,
    endereco.cep as cep,
    endereco.street as logradouro,
    endereco.neighborhood as bairro,
    endereco.city as cidade,
    endereco.state as estado,
    endereco.number as numero,
    endereco.complement as complemento,
    endereco.ibge_code as ibge_code
    FROM pop as pop
    LEFT JOIN pop_address as endereco ON endereco.pop_id = pop.id
    LEFT JOIN empresas as emp ON emp.id = pop.empresa_id
    WHERE pop.active = 1 and pop.id = $idPOP    
    ORDER BY emp.fantasia asc, endereco.city asc, pop.pop asc
";

$resultado = mysqli_query($mysqli, $sql_pop);
$row = mysqli_fetch_assoc($resultado);

$sql_lista_empresas =
    "SELECT emp.*
FROM empresas as emp
WHERE emp. deleted = 1 and emp.atributoCliente = 1 or emp. deleted = 1 and emp.atributoEmpresaPropria = 1
ORDER BY emp.fantasia asc";
?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">POP <?= $row['pop']; ?></h5>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="informacoes-tab" data-bs-toggle="tab" data-bs-target="#informacoes" type="button" role="tab" aria-controls="informacoes" aria-selected="true" onclick="window.location.href = 'view_informacoes.php?id=<?= $idPOP ?>';">Informacoes</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link " id="equipamentos-tab" data-bs-toggle="tab" data-bs-target="#equipamentos" type="button" role="tab" aria-controls="equipamentos" aria-selected="false" onclick="window.location.href = 'view_equipamentos.php?id=<?= $idPOP ?>';">Equipamentos</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="energia-tab" data-bs-toggle="tab" data-bs-target="#energia" type="button" role="tab" aria-controls="energia" aria-selected="false" onclick="window.location.href = 'view_energia.php?id=<?= $idPOP ?>';">Energia</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="anexo-tab" data-bs-toggle="tab" data-bs-target="#anexo" type="button" role="tab" aria-controls="anexo" aria-selected="false" onclick="window.location.href = 'view_anexo.php?id=<?= $idPOP ?>';">Anexos</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="atividades-tab" data-bs-toggle="tab" data-bs-target="#atividades" type="button" role="tab" aria-controls="atividades" aria-selected="false" onclick="window.location.href = 'view_atividades.php?id=<?= $idPOP ?>';">Atividades</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="vistoria-tab" data-bs-toggle="tab" data-bs-target="#vistoria" type="button" role="tab" aria-controls="vistoria" aria-selected="false" onclick="window.location.href = 'view_vistoria.php?id=<?= $idPOP ?>';">Vistoria</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">

                            <div class="card-body">
                                <h5 class="card-title">Dados do POP</h5>

                                <!-- Multi Columns Form -->

                                <form method="POST" action="processa/editarPOP.php" class="row g-3">
                                    <span id="msgEditarPOP1"></span>
                                    <input name="id" type="text" class="form-control" id="id" value="<?= $idPOP  ?>" hidden>
                                    <div class="col-md-4">
                                        <label for="empresa" class="form-label">Empresa</label>
                                        <select id="empresa" name="empresa" class="form-select">
                                            <option value="<?= $row['id_empresa']; ?>"><?= $row['empresa']; ?></option>
                                            <?php
                                            $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                            while ($emp = $resultado->fetch_assoc()) : ?>
                                                <option value="<?= $emp['id']; ?>"><?= $emp['fantasia']; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="pop" class="form-label">POP</label>
                                        <input type="text" class="form-control" id="pop" name="pop" value="<?= $row['pop']; ?>">
                                    </div>

                                    <div class="col-md-5">
                                        <label for="descricaoPOP" class="form-label">Descrição</label>
                                        <input type="text" class="form-control" id="descricaoPOP" name="descricaoPOP" value="<?= $row['apelidoPop']; ?>">
                                    </div>

                                    <hr class="sidebar-divider">
                                    <li class="nav-heading" style="list-style: none;">Localização</li>

                                    <div class="row">
                                        <div class="col-4">
                                            <label for="cep" class="form-label">CEP</label>
                                            <input value="<?= $row['cep'] ?>" name="cep" type="text" class="form-control" id="cep" onblur="buscarEnderecoPorCep()" required>
                                        </div>


                                        <div class="col-4">
                                            <label for="ibgecode" class="form-label">Código IBGE</label>
                                            <input value="<?= $row['ibge_code'] ?>" name="ibgecode" type="text" class="form-control" id="ibgecode" readonly>
                                        </div>
                                    </div>
                                    <p style='color:red;' id="mensagem-erro"></p>
                                    <div class="col-4">
                                        <label for="inputLogradouro" class="form-label">Logradouro</label>
                                        <input value="<?= $row['logradouro'] ?>" name="logradouro" type="text" class="form-control" id="logradouro" readonly required>
                                    </div>

                                    <div class="col-4">
                                        <label for="inputBairro" class="form-label">Bairro</label>
                                        <input value="<?= $row['bairro'] ?>" name="bairro" type="text" class="form-control" id="bairro" readonly>
                                    </div>

                                    <div class="col-4">
                                        <label for="inputCidade" class="form-label">Cidade</label>
                                        <input value="<?= $row['cidade'] ?>" name="cidade" type="text" class="form-control" id="cidade" readonly>
                                    </div>

                                    <div class="col-4">
                                        <label for="inputEstado" class="form-label">Estado</label>
                                        <input value="<?= $row['estado'] ?>" name="estado" type="text" class="form-control" id="estado" readonly>
                                    </div>


                                    <div class="col-2">
                                        <label for="numero" class="form-label">Número</label>
                                        <input value="<?= $row['numero'] ?>" name="numero" type="number" class="form-control" id="numero" required>
                                    </div>

                                    <div class="col-4">
                                        <label for="complemento" class="form-label">Complemento</label>
                                        <input value="<?= $row['complemento'] ?>" name="complemento" type="text" class="form-control" id="complemento">
                                    </div>


                                    <hr class="sidebar-divider">

                                    <div class="text-center">
                                        <button class="btn btn-sm btn-danger" type="submit">Salvar</button>
                                        <a href="/telecom/sitepop/index.php">
                                            <button class="btn btn-sm btn-secondary" type="button">Voltar</button>
                                        </a>
                                        
                                    </div>
                                </form><!-- End Multi Columns Form -->
                            </div>
                        </div>
                    </div><!-- End Default Tabs -->
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
<?php
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>