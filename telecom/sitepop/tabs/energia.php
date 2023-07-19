    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="card-title">Bateria</h5>
                            </div>
                            <div class="col-4">

                                <button style="margin-top: 15px;" type="button" class="btn btn-danger  btn-sm" data-bs-toggle="modal" data-bs-target="#modalAdicionarBateria">Adicionar</button>
                            </div>
                        </div>
                    </div>
                    <div id="baterias-container">
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="row">
                                    <?php
                                    try {
                                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                        $sql_baterias_pop =
                                            "SELECT
                                                pbiu.id as 'id',
                                                pbu.n_serie as 'n_serie',
                                                pbu.patrimonio as 'patrimonio',
                                                DATE_FORMAT(pbiu.data_instalacao, '%d/%m/%Y') AS 'data_instalacao'
                                                FROM 
                                                pop_baterias_in_use as pbiu
                                                LEFT JOIN
                                                produtos_bateria_units as pbu
                                                ON pbu.id = pbiu.bateria_id
                                                WHERE pbiu.pop_id = :idPOP and pbiu.status = 1 ";
                                        $stmt = $pdo->prepare($sql_baterias_pop);
                                        $stmt->bindParam(':idPOP', $idPOP);
                                        $stmt->execute();

                                        $cont = 1;
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>

                                            <div class="row mb-3">

                                                <label for="inputText" class="col-sm-2 col-form-label">Bataria <?= $cont ?></label>
                                                <div class="col-sm-3">
                                                    <input title="Nº Série" readonly value="<?= $row['n_serie'] ?>" type="text" class="form-control">
                                                </div>
                                                <div class="col-sm-3">
                                                    <input title="Patrimonio" readonly value="<?= $row['patrimonio'] ?>" type="text" class="form-control">
                                                </div>
                                                <div class="col-sm-3">
                                                    <input title="Data Instalação" readonly value="<?= $row['data_instalacao'] ?>" type="text" class="form-control">
                                                </div>
                                                <div class="col-sm-1">
                                                    <button data-bs-toggle="modal" data-bs-target="#confirmarExclusao<?= $row['id'] ?>" title="Retirar Bateria" type="button" class="badge rounded-pill bg-danger" onclick="excluirBateria(<?= $row['id'] ?>)">X</button>
                                                </div>

                                                <div class="modal fade" id="confirmarExclusao<?= $row['id'] ?>" tabindex="-1" aria-labelledby="confirmarExclusaoLabel<?= $row['id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="confirmarExclusaoLabel<?= $row['id'] ?>">Confirmação de Retirada</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST" action="processa/retirada_bateria_pop.php">
                                                                <div class="modal-body">
                                                                    <p>Tem certeza que deseja retirar a bateria?</p>
                                                                    <input hidden readonly id="idBateria" name="idBateria" value="<?= $row['id'] ?>"></input>
                                                                    <input hidden readonly id="idPOPBateriaRetirada" name="idPOPBateriaRetirada" value="<?= $idPOP ?>"></input>
                                                                    <div class="mb-3">
                                                                        <label for="dataRetirada<?= $row['id'] ?>" class="form-label">Data de Retirada:</label>
                                                                        <input required type="date" class="form-control" name="dataRetirada<?= $row['id'] ?>" id="dataRetirada<?= $row['id'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                    <button type="submit" class="btn btn-danger">Confirmar Retirada</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                    <?php
                                            $cont++;
                                        }
                                    } catch (PDOException $e) {
                                        echo "Erro: " . $e->getMessage();
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql_pop_energia = "SELECT * FROM pop_energia WHERE pop_id = :pop_id";
            $stmt_pop_energia = $pdo->prepare($sql_pop_energia);
            $stmt_pop_energia->bindParam(':pop_id', $idPOP);
            $stmt_pop_energia->execute();
            $row_pop_energia = $stmt_pop_energia->fetch(PDO::FETCH_ASSOC);

            if ($row_pop_energia && isset($row_pop_energia['energia_autonomia'])) {
                // Se encontrou um registro e o campo tempo_autonomia não é nulo, atribui o valor à variável
                $tempoAutonomia = $row_pop_energia['energia_autonomia'];

                $tempoAutonomia = (new DateTime($tempoAutonomia))->format('H:i');
            } else {
                $tempoAutonomia = "";
            }
        } catch (PDOException $e) {
            echo "Erro ao conectar com o banco de dados: " . $e->getMessage();
        }
        ?>

        <div class="col-lg-5">
            <div class="card-body">
                <h5 class="card-title">Autonomia</h5>
                <form method="POST" action="processa/pop_energia.php">
                    <input hidden readonly id="autonomia_id_pop" name="autonomia_id_pop" value="<?= $idPOP ?>"></input>

                    <div class="col-5">
                        <label for="tempoAutonomia" class="form-label">Tempo de Autonomia</label>
                        <input required type="time" id="tempoAutonomia" name="tempoAutonomia" class="form-control" value="<?= $tempoAutonomia ?>"></input>
                    </div>
                    <br>
                    <div class="text-center">
                        <button type="submit" class="btn btn-sm btn-danger">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Monitoramento AC</h5>

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Fonte e Conversores</h5>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAdicionarBateria" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Bateria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="processa/adicionar_bateria_pop.php">
                    <div class="modal-body">
                        <input readonly hidden name="add_bateria_pop_id" id="add_bateria_pop_id" value="<?= $idPOP ?>"></input>
                        <div class="col-8">
                            <select required id="add_bateria_bateria" name="add_bateria_bateria" class="form-select" aria-label="Default select example">
                                <option disabled selected value="">Selecione uma bateria</option>
                                <?php

                                try {
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    $sql_lista_baterias =
                                        "SELECT 
                            pbu.id as 'id', 
                            pbu.n_serie as 'n_serie',
                            pbu.patrimonio as 'patrimonio',
                            pb.modelo as 'modelo'
                            FROM 
                            produtos_bateria_units as pbu
                            LEFT JOIN
                            produtos_bateria as pb
                            ON
                            pb.id = pbu.produto_bateria_id
                            WHERE
                            pbu.active = 1
                            and
                            pbu.id NOT IN (SELECT pbiu.bateria_id FROM pop_baterias_in_use as pbiu WHERE pbiu.status = 1)";
                                    $stmt_lista_baterias = $pdo->prepare($sql_lista_baterias);
                                    $stmt_lista_baterias->execute();

                                    while ($row_lista_baterias = $stmt_lista_baterias->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?= $row_lista_baterias['id'] ?>"><?= $row_lista_baterias["modelo"] ?> - <?= $row_lista_baterias["n_serie"] ?></option>
                                <?php }
                                } catch (PDOException $e) {
                                    echo "Erro na conexão: " . $e->getMessage();
                                }
                                ?>
                            </select>
                        </div>
                        <br>
                        <div class="col-8">
                            <div class="row mb-3">
                                <label for="inputDate" class="col-sm-6 col-form-label">Data Instalação</label>
                                <div class="col-sm-6">
                                    <input required type="date" name="data_instalacao" id="data_instalacao" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger btn-sm">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>