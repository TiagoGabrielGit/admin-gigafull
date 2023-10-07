<h3 class="card-title">Rotas de Fibra</h3>

<form method="POST" action="processa/step3.php" class="row g-3">
    <div class="row">
        <div class="col-lg-12">
            <ul>
                <?php
                $query = "SELECT
                                                rf.id as id,
                                                rf.ponta_a as ponta_a,
                                                rf.ponta_b as ponta_b
                                                FROM
                                                rotas_fibra as rf
                                                WHERE
                                                rf.active = 1";

                try {
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $pdo->prepare($query);
                    $stmt->execute();
                    $rotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo "Erro na consulta SQL: " . $e->getMessage();
                }

                foreach ($rotas as $rota) :
                ?>
                    <li>
                        <label class="form-check-label">
                            <input value="<?= $rota['id'] ?>" class=" form-check-input me-1" name="rotasDeFibra[]" type="checkbox">
                            <?= $rota['ponta_a'] . " <b> <> </b> " . $rota['ponta_b']; ?>
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
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
</form><!-- Vertical Form -->