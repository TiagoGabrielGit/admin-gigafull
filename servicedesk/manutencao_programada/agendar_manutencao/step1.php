<h3 class="card-title">Manutenção Programada</h3>

<hr class="sidebar-divider">

<br><br>

<form method="POST" action="processa/step1.php" class="row g-3">
    <div class="row">
        <div class="col-5">
            <label for="titulo" class="form-label">Titulo</label>
            <input maxlength="100" value="<?= $titulo ?>" name="titulo" type="text" class="form-control" id="titulo" required>
        </div>

        <div class="col-3">
            <label for="dataAgendamento" class="form-label">Data Agendamento</label>
            <input value="<?= $dataAgendamento ?>" name="dataAgendamento" type="datetime-local" class="form-control" id="dataAgendamento" required>
        </div>

        <div class="col-2">
            <label for="duracao" class="form-label">Duração (em horas)</label>
            <input value="<?= $duracao ?>" name="duracao" type="number" class="form-control" id="duracao" required>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-5">
            <label for="responsavel_name" class="form-label">Responsável pela Manutenção</label>
            <input maxlength="150" value="<?= $responsavel_name ?>" name="responsavel_name" type="text" class="form-control" id="responsavel_name" required>
        </div>
        <div class="col-3">
            <label for="responsavel_contato" class="form-label">Contato do Responspável pela Manutenção</label>
            <input name="responsavel_contato" value="<?= $responsavel_contato ?>" type="text" class="form-control" id="celular" required>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-12">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea maxlength="500" id="descricao" name="descricao" class="form-control" style="height: 100px" required><?= $descricao ?></textarea>
        </div>
    </div>
    <hr class="sidebar-divider">
    <br><br>
    <div class="container">
        <input readonly hidden id="idMP" name="idMP" value="<?= $idMP ?>" />
        <div class="row">
            <div class="col-4">
                <button name="acao" value="salvar_rascunho" class="btn btn-sm btn-primary">Salvar Rascunho</button>
            </div>
            <div class="col-4">
                <button name="acao" value="avancar" class="btn btn-sm btn-danger">Avançar</button>
            </div>
            <div class="col-4">
                <button name="acao" value="cancelar_agendamento" class="btn btn-sm btn-secondary">Cancelar Agendamento</button>
            </div>
        </div>
    </div>
</form>