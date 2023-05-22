<div class="card-body">
    <h5 class="card-title">Dados do Empresa</h5>

    <!-- Multi Columns Form -->

    <!-- Multi Columns Form -->
    <form method="POST" id="editarEmpresa" class="row g-3">
        <span id="msgEditarEmpresa"></span>
        <input type="hidden" name="id" value="<?= $row['id_empresa']; ?>">

        <hr class="sidebar-divider">

        <div class="row mb-3">
            <label for="codigo" class="col-sm-12 col-form-label">Código</label>
            <div class="col-sm-2">
                <input name="codigo" type="text" class="form-control" id="codigo" value="<?= $row['id_empresa']; ?>" disabled>
            </div>
        </div>

        <div class="col mb-6">
            <label for="razaoSocial" class="col-sm-12 col-form-label">Razão Social</label>
            <div class="col-sm-12">
                <input name="razaoSocial" type="text" class="form-control" id="razaoSocial" value="<?= $row['razaoSocial']; ?>">
            </div>
        </div>

        <div class="col mb-6">
            <label for="fantasia" class="col-sm-12 col-form-label">Fantasia</label>
            <div class="col-sm-12">
                <input name="fantasia" type="text" class="form-control" id="fantasia" value="<?= $row['fantasia']; ?>">
            </div>
        </div>

        <div class="col-md-12">
        </div>

        <div class="col mb-3">
            <label for="cnpj" class="col-sm-12 col-form-label">CNPJ</label>
            <div class="col-sm-12">
                <input required name="cnpj" type="text" class="form-control" id="cnpj" value="<?= $row['cnpj']; ?>">
            </div>
        </div>

        <div class="col-3">
            <label for="email" class="form-label">E-mail</label>
            <input name="email" type="email" class="form-control" id="email" value="<?= $row['email']; ?>" required>
        </div>

        <div class="col-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input name="telefone" type="text" class="form-control" id="telefone" value="<?= $row['telefone']; ?>" required>
        </div>

        <div class="col-3">
            <label for="celular" class="form-label">Celular</label>
            <input name="celular" type="text" class="form-control" id="celular" value="<?= $row['celular']; ?>" required>
        </div>

        <hr class="sidebar-divider">
        <li class="nav-heading" style="list-style: none;">Atributos</li>

        <div class="col-6">
            <ul class="list-group" style="list-style: none;">
                <li> <input class="form-check-input me-1" name="atributoCliente" type="checkbox" value="1" <?= $atributoClienteChecked; ?>>Cliente</li>
                <li> <input class="form-check-input me-1" name="atributoEmpresaPropria" type="checkbox" value="1" <?= $atributoEmpresaPropriaChecked; ?>> Empresa Própria</li>
                <li> <input class="form-check-input me-1" name="atributoFornecedor" type="checkbox" value="1" <?= $atributoFornecedorChecked; ?>> Fornecedor</li>
            </ul>
        </div>

        <div class="col-6">
            <ul class="list-group" style="list-style: none;">
                <li> <input class="form-check-input me-1" name="atributoPrestadorServico" type="checkbox" value="1" <?= $atributoPrestadorServicoChecked; ?>> Prestador de Serviço</li>
                <li> <input class="form-check-input me-1" name="atributoTransportadora" type="checkbox" value="1" <?= $atributoTransportadoraChecked; ?>> Transportadora</li>
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

        <div class="col-md-6">
            <label for="dateCreated" class="form-label">Data criação</label>
            <div class="col-sm-6">
                <input name="dateCreated" type="text" class="form-control" id="dateCreated" value="<?= $row['data_criado']; ?>" disabled>
            </div>
        </div>

        <div class="col-md-6">
            <label for="dateModified" class="form-label">última modificação</label>
            <div class="col-sm-6">
                <input name="dateModified" type="text" class="form-control" id="dateModified" value="<?= $row['data_modificado']; ?>" disabled>
            </div>
        </div>

        <div class="text-center">
            <span id="msgEditarEmpresa2"></span>
            <input id="btnEditar" name="btnEditar" type="button" value="Salvar Alterações" class="btn btn-danger"></input>
            <input type="button" value="Voltar" onClick="history.go(-1)" class="btn btn-secondary">
        </div>
    </form><!-- End Multi Columns Form -->
</div>