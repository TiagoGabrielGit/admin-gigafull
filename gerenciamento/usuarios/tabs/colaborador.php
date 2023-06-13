<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Horário de Trabalho</h2>
                    <form id="formHorarioTrabalho" method="POST">

                        <input hidden readonly value="<?= $idUsuario ?>" id="user_id" name="user_id">

                        <table class="table">
                            <tr>
                                <th style="text-align: center;">Dia da Semana</th>
                                <th style="text-align: center;">Início P1</th>
                                <th style="text-align: center;">Fim P1</th>
                                <th style="text-align: center;">Início P2</th>
                                <th style="text-align: center;">Fim P2</th>
                            </tr>
                            <tr>
                                <td>Segunda</td>
                                <td><input value="<?= $seg_ini_p1 ?>" class="form-control" type="time" name="segunda_inicio_p1" required></td>
                                <td><input value="<?= $seg_fim_p1 ?>" class="form-control" type="time" name="segunda_fim_p1" required></td>
                                <td><input value="<?= $seg_ini_p2 ?>" class="form-control" type="time" name="segunda_inicio_p2" required></td>
                                <td><input value="<?= $seg_fim_p2 ?>" class="form-control" type="time" name="segunda_fim_p2" required></td>
                            </tr>
                            <tr>
                                <td>Terça</td>
                                <td><input value="<?= $ter_ini_p1 ?>" class="form-control" type="time" name="terca_inicio_p1" required></td>
                                <td><input value="<?= $ter_fim_p1 ?>" class="form-control" type="time" name="terca_fim_p1" required></td>
                                <td><input value="<?= $ter_ini_p2 ?>" class="form-control" type="time" name="terca_inicio_p2" required></td>
                                <td><input value="<?= $ter_fim_p2 ?>" class="form-control" type="time" name="terca_fim_p2" required></td>
                            </tr>
                            <tr>
                                <td>Quarta</td>
                                <td><input value="<?= $qua_ini_p1 ?>" class="form-control" type="time" name="quarta_inicio_p1" required></td>
                                <td><input value="<?= $qua_fim_p1 ?>" class="form-control" type="time" name="quarta_fim_p1" required></td>
                                <td><input value="<?= $qua_ini_p2 ?>" class="form-control" type="time" name="quarta_inicio_p2" required></td>
                                <td><input value="<?= $qua_fim_p2 ?>" class="form-control" type="time" name="quarta_fim_p2" required></td>
                            </tr>
                            <tr>
                                <td>Quinta</td>
                                <td><input value="<?= $qui_ini_p1 ?>" class="form-control" type="time" name="quinta_inicio_p1" required></td>
                                <td><input value="<?= $qui_fim_p1 ?>" class="form-control" type="time" name="quinta_fim_p1" required></td>
                                <td><input value="<?= $qui_ini_p2 ?>" class="form-control" type="time" name="quinta_inicio_p2" required></td>
                                <td><input value="<?= $qui_fim_p2 ?>" class="form-control" type="time" name="quinta_fim_p2" required></td>
                            </tr>
                            <tr>
                                <td>Sexta</td>
                                <td><input value="<?= $sex_ini_p1 ?>" class="form-control" type="time" name="sexta_inicio_p1" required></td>
                                <td><input value="<?= $sex_fim_p1 ?>" class="form-control" type="time" name="sexta_fim_p1" required></td>
                                <td><input value="<?= $sex_ini_p2 ?>" class="form-control" type="time" name="sexta_inicio_p2" required></td>
                                <td><input value="<?= $sex_fim_p2 ?>" class="form-control" type="time" name="sexta_fim_p2" required></td>
                            </tr>
                            <tr>
                                <td>Sábado</td>
                                <td><input value="<?= $sab_ini_p1 ?>" class="form-control" type="time" name="sabado_inicio_p1" required></td>
                                <td><input value="<?= $sab_fim_p1 ?>" class="form-control" type="time" name="sabado_fim_p1" required></td>
                                <td><input value="<?= $sab_ini_p2 ?>" class="form-control" type="time" name="sabado_inicio_p2" required></td>
                                <td><input value="<?= $sab_fim_p2 ?>" class="form-control" type="time" name="sabado_fim_p2" required></td>
                            </tr>
                            <tr>
                                <td>Domingo</td>
                                <td><input value="<?= $dom_ini_p1 ?>" class="form-control" type="time" name="domingo_inicio_p1" required></td>
                                <td><input value="<?= $dom_fim_p1 ?>" class="form-control" type="time" name="domingo_fim_p1" required></td>
                                <td><input value="<?= $dom_ini_p2 ?>" class="form-control" type="time" name="domingo_inicio_p2" required></td>
                                <td><input value="<?= $dom_fim_p2 ?>" class="form-control" type="time" name="domingo_fim_p2" required></td>
                            </tr>
                            <!-- Repita os blocos <tr> para cada dia da semana -->
                        </table>
                        <div class="col-12" style="text-align: center;">
                            <span id="msgHorarioTrabalho"></span>
                            <input id="btnHorarioTrabalho" name="btnHorarioTrabalho" type="button" value="Salvar" class="btn btn-danger"></input>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Organização</h2>
                    <form id="formGerencia" method="POST">

                        <input hidden readonly value="<?= $idUsuario ?>" id="user_id_gerencia" name="user_id_gerencia">
                        <div class="col-12">
                            <label for="gerente" class="form-label">Gerente</label>
                            <select id="gerente" name="gerente" class="form-select">
                                <?= $opcaoGerente ?>
                                <?php
                                $lista_gerentes = "SELECT p.nome as 'nome', u.id as 'id' FROM usuarios as u LEFT JOIN pessoas as p ON u.pessoa_id = p.id WHERE u.tipo_usuario = 1 and active = 1 ORDER BY p.nome ASC";

                                try {
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    // Executar a consulta SQL e obter os resultados
                                    $stmt = $pdo->query($lista_gerentes);
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $nome = $row['nome'];
                                        $id = $row['id'];
                                        echo "<option value='$id'>$nome</option>";
                                    }
                                } catch (PDOException $e) {
                                    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
                                }

                                ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="coordenador" class="form-label">Coordenador</label>
                            <select id="coordenador" name="coordenador" class="form-select">
                                <?= $opcaoCoordenador ?>
                                <?php
                                $lista_colaborador = "SELECT p.nome as 'nome', u.id as 'id' FROM usuarios as u LEFT JOIN pessoas as p ON u.pessoa_id = p.id WHERE u.tipo_usuario = 1 and active = 1 ORDER BY p.nome ASC";

                                try {
                                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    // Executar a consulta SQL e obter os resultados
                                    $stmt = $pdo->query($lista_colaborador);
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $nome = $row['nome'];
                                        $id = $row['id'];
                                        echo "<option value='$id'>$nome</option>";
                                    }
                                } catch (PDOException $e) {
                                    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
                                }

                                ?>
                            </select>
                        </div>
                        <hr class="sidebar-divider">
                        <div class="col-12" style="text-align: center;">
                            <span id="msgGerencia"></span>
                            <input id="btnGerencia" name="btnGerencia" type="button" value="Salvar" class="btn btn-danger"></input>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>