<?php
require "../includes/menu.php";
require "../conexoes/conexao.php";
require "../conexoes/sql.php";
require '../includes/remove_setas_number.php';
?>


<?php
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql_pessoas =
    "SELECT
pessoa.id as id,
pessoa.nome as nome,
pessoa.email as email, 
pessoa.cpf as cpf,
pessoa.telefone as telefone,
pessoa.celular as celular,
atributoCliente as atributoCliente,
permiteUsuario as permiteUsuario,
atributoPrestadorServico as atributoPrestadorServico,
endereco.cep as cep,
endereco.street as logradouro,
endereco.neighborhood as bairro,
endereco.city as cidade,
endereco.state as estado,
endereco.number as numero,
endereco.complement as complemento,
endereco.ibge_code as ibge_code
FROM
    pessoas as pessoa
LEFT JOIN
people_address as endereco
ON
endereco.people_id = pessoa.id    
WHERE
pessoa.id = $id
";

$resultado = mysqli_query($mysqli, $sql_pessoas);
$row = mysqli_fetch_assoc($resultado);



if (isset($row['atributoCliente']) and ($row['atributoCliente'] == 1)) {
    $atributoClienteChecked = "checked";
} else {
    $atributoClienteChecked = "";
}

if (isset($row['permiteUsuario']) and ($row['permiteUsuario'] == 1)) {
    $permiteUsuarioChecked = "checked";
} else {
    $permiteUsuarioChecked = "";
}

if (isset($row['atributoPrestadorServico']) and ($row['atributoPrestadorServico'] == 1)) {
    $atributoPrestadorServicoChecked = "checked";
} else {
    $atributoPrestadorServicoChecked = "";
}

?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Código <?= $row['id']; ?> - <?= $row['nome']; ?></h5>

                        <form method="POST" id="editarPessoa" class="row g-3">
                            <span id="msgEditarPessoa1"></span>
                            <li class="nav-heading" style="list-style: none;">Dados</li>


                            <input name="id" type="text" class="form-control" id="id" value="<?= $row['id']; ?>" hidden>


                            <div class="col-8">
                                <label for="nomePessoa" class="form-label">Nome</label>
                                <input name="nomePessoa" type="text" class="form-control" id="nomePessoa" value="<?= $row['nome']; ?>" required>
                            </div>

                            <div class="col-4">
                                <label for="cpf" class="form-label">CPF</label>
                                <input name="cpf" type="text" class="form-control" id="cpf" value="<?= $row['cpf']; ?>" required>
                            </div>

                            <div class="col-4">
                                <label for="email" class="form-label">E-mail</label>
                                <input name="email" type="text" class="form-control" id="email" value="<?= $row['email']; ?>" required>
                            </div>

                            <div class="col-4">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input name="telefone" type="text" class="form-control" id="telefone" value="<?= $row['telefone']; ?>">
                            </div>

                            <div class="col-4">
                                <label for="celular" class="form-label">Celular</label>
                                <input name="celular" type="text" class="form-control" id="celular" value="<?= $row['celular']; ?>" required>
                            </div>

                            <hr class="sidebar-divider">
                            <li class="nav-heading" style="list-style: none;">Atributos</li>

                            <div class="col-6">
                                <ul class="list-group" style="list-style: none;">
                                    <li> <input class="form-check-input me-1" name="atributoCliente" type="checkbox" value="1" <?= $atributoClienteChecked; ?>> Cliente</li>
                                    <li> <input class="form-check-input me-1" name="permiteUsuario" type="checkbox" value="1" <?= $permiteUsuarioChecked; ?>> Permite Usuário</li>
                                    <li> <input class="form-check-input me-1" name="atributoPrestadorServico" type="checkbox" value="1" <?= $atributoPrestadorServicoChecked; ?>> Prestador de Serviço</li>
                                </ul>
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
                                <span id="msgEditarPessoa2"></span>
                                <input id="btnEditar" name="btnEditar" type="button" value="Salvar Alterações" class="btn btn-danger"></input>
                                <input type="button" value="Voltar" onClick="history.go(-1)" class="btn btn-secondary">
                            </div>
                        </form><!-- Vertical Form -->

                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->

<?php
require "js.php";
require "../includes/footer.php";
?>