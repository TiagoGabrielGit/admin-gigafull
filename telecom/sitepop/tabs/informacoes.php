<div class="card-body">
    <h5 class="card-title">Dados do POP</h5>

    <!-- Multi Columns Form -->
    <form class="row g-3">
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
            <label for="apelidoPop" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="apelidoPop" name="apelidoPop" value="<?= $row['apelidoPop']; ?>">
        </div>

        <hr class="sidebar-divider">
        <li class="nav-heading" style="list-style: none;">Localização</li>

        <div class="col-md-4">
            <label for="cidade" class="form-label">Cidade</label>
            <select id="cidade" name="cidade" class="form-select" value="<?= $row['nome_bairro']; ?>">
                <option value="<?= $row['id_cidade']; ?>"><?= $row['nome_cidade']; ?></option>
                <?php
                $resultado = mysqli_query($mysqli, $sql_cidade);
                while ($c = $resultado->fetch_assoc()) : ?>
                    <option value="<?= $c['id']; ?>"><?= $c['cidade']; ?></option>
                <?php endwhile; ?>

            </select>
        </div>

        <div class="col-md-4">
            <label for="bairro" class="form-label">Bairro</label>
            <select id="bairro" name="bairro" class="form-select">
                <option value="<?= $row['id_bairro']; ?>"><?= $row['nome_bairro']; ?></option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="cep" class="form-label">CEP</label>
            <select id="cep" name="cep" class="form-select">
                <option value="<?= $row['cep']; ?>"><?= $row['cep']; ?></option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="logradouro" class="form-label">Logradouro</label>
            <select id="logradouro" name="logradouro" class="form-select" aria-label="Default select example">
                <option value="<?= $row['id_logradouro']; ?>"><?= $row['nome_logradouro']; ?></option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="numero" class="form-label">Número</label>
            <input name="numero" type="number" class="form-control" id="numero" value="<?= $row['numero']; ?>" required>
        </div>

        <div class="col-md-4">
            <label for="complemento" class="form-label">Complemento</label>
            <input name="complemento" type="text" class="form-control" id="complemento" value="<?= $row['complemento']; ?>">
        </div>

        <hr class="sidebar-divider">

        <div class="col-md-4"></div>
        <div class="col-md-4">
            <button name="salvar" type="submit" class="btn btn-danger btn-sm">Atualizar</button>
            <input type="button" value="Voltar" onClick="history.go(-1)" class="btn btn-secondary btn-sm">

        </div>
        <div class="col-md-2"></div>
        <div class="col-md-2">
            <a href="processa/delete.php?id=<?= $idPOP ?>"><input type="button" class="btn btn-danger btn-sm" value="Excluir permanente"></input></a>
        </div>
    </form><!-- End Multi Columns Form -->
</div>