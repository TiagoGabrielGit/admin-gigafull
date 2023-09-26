<div class="col-lg-12"> <!-- 4 -->
    <div class="row"> <!-- 5 -->
        <span>Comunicação via E-mail</span>
        <hr class="sidebar-divider">
        <div class="col-lg-6"> <!-- 6 -->
            <div class="row"> <!-- 7 -->
                <form method="POST" action="processa/adiciona_destinatarios_email.php"> <!-- 8 -->
                    <input readonly hidden value="<?= $idComunicacao ?>" id="idComunicacao" name="idComunicacao"></input>
                    <div class="col-8">
                        <label class="form-label">Destinatários</label>
                        <select id="empresa_notificacao_id" name="empresa_notificacao_id" class="form-select">
                            <option disabled selected value="">Selecione...</option>
                            <?php
                            $dest_email =
                                "SELECT e.fantasia as empresa, en.midia as email, en.id as idComunicacao
													FROM empresas_notificacao as en
													LEFT JOIN empresas as e ON en.empresa_id = e.id
													WHERE en.active = 1 AND en.metodo_id = 1 AND en.id NOT IN (SELECT empresa_notificacao_id
														FROM comunicacao_destinatarios
														WHERE active = 1 AND comunicacao_id = $idComunicacao)";
                            $r_dest_email = mysqli_query($mysqli, $dest_email) or die("Erro ao retornar dados");
                            while ($c_dest_email = $r_dest_email->fetch_assoc()) : ?>
                                <option value="<?= $c_dest_email['idComunicacao']; ?>"><?= $c_dest_email['empresa'] . " - " . $c_dest_email['email'] ?> </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div style="margin-top: 15px;" class="col-4">
                        <button type="submit" class="btn btn-sm btn-danger"> Adicionar</button>
                    </div>
                </form> <!-- 8 -->
            </div> <!-- 7 -->
        </div> <!-- 6 -->
        <div class="col-lg-6">
            <?php
            $lista_email_dest =
                "SELECT e.fantasia, en.midia, cd.id as idComDest
											FROM comunicacao_destinatarios as cd
											LEFT JOIN empresas_notificacao as en ON cd.empresa_notificacao_id = en.id
											LEFT JOIN empresas as e ON e.id = en.empresa_id
											WHERE cd.comunicacao_id = $idComunicacao AND cd.active = 1
											ORDER BY e.fantasia ASC, en.midia ASC
											";

            $r_lista_email_dest = mysqli_query($mysqli, $lista_email_dest) or die("Erro ao retornar dados");

            while ($c_lista_email_dest = $r_lista_email_dest->fetch_assoc()) : ?>
                <div style="margin-top: 2px;" class="col-12">
                    <span>
                        <div class="row">
                            <form method="POST" action="processa/remover_destinatario.php">
                                <input hidden readonly id="comDest" name="comDest" value="<?= $c_lista_email_dest['idComDest'] ?>"></input>
                                <button title="Remover Destinatário" type="submit" class="badge rounded-pill bg-danger">X</button>
                                <?= $c_lista_email_dest['fantasia'] . " - " . $c_lista_email_dest['midia'] ?>
                            </form>
                        </div>
                    </span>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
<br><br>
<div class="container">
    <form method="POST" action="processa/step1.php">
        <input readonly hidden id="idComunicacao" name="idComunicacao" value="<?= $idComunicacao ?>" />
        <div class="row">
            <div class="col-4">
                <button name="acao" value="salvar_rascunho" class="btn btn-sm btn-primary">Salvar Rascunho</button>
            </div>
            <div class="col-4">
                <button name="acao" value="avancar" class="btn btn-sm btn-danger">Avançar</button>
            </div>
            <div class="col-4">
                <button name="acao" value="cancelar_comunicacao" class="btn btn-sm btn-secondary">Cancelar Comunicação</button>
            </div>
        </div>
    </form>

</div>