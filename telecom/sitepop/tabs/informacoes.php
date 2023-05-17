<div class="card-body">
    <h5 class="card-title">Dados do POP</h5>

    <!-- Multi Columns Form -->

    <form method="POST" id="editarPOP" class="row g-3">
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

        <div class="col-md-4"></div>
        <div class="col-md-4">

            <span id="msgEditarPOP2"></span>
            <input id="btnEditarPOP" name="btnEditarPOP" type="button" value="Salvar" class="btn btn-danger"></input>
            <input type="button" value="Voltar" onClick="history.go(-1)" class="btn btn-secondary btn-sm">

        </div>
        <div class="col-md-2"></div>
        <div class="col-md-2">
            <a href="processa/delete.php?id=<?= $idPOP ?>"><input type="button" class="btn btn-danger btn-sm" value="Excluir permanente"></input></a>
        </div>
    </form><!-- End Multi Columns Form -->
</div>