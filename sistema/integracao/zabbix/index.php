<?php
require "../../../includes/menu.php";
require "../../../conexoes/conexao_pdo.php";

$integracao_zabbix =
    "SELECT
iz.id as id,
iz.tokenAPI as tokenAPI,
iz.statusIntegracao as statusIntegracao,
iz.urlZabbix as urlZabbix
FROM
integracao_zabbix as iz
WHERE
iz.id = 1
";

$r_integracao_zabbix = $pdo->query($integracao_zabbix);
$c_integracao_zabbix = $r_integracao_zabbix->fetch(PDO::FETCH_ASSOC);
?>

<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Parâmetros Integração Zabbix</h5>
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="processa/update.php" method="POST">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="urlZabbix" class="form-label">URL Zabbix</label>
                                            <input <?= ($c_integracao_zabbix['urlZabbix'] === NULL) ? "" : 'value="' . $c_integracao_zabbix['urlZabbix'] . '"' ?> placeholder="Ex: http://zabbix.dominio.com.br/api_jsonrpc.php" name="urlZabbix" id="urlZabbix" class="form-control" type="text">
                                        </div>
                                        <div class="col-3">
                                            <label for="statusIntegracao" class="form-label">Integração Ativa</label>
                                            <select name="statusIntegracao" id="statusIntegracao" class="form-select" aria-label="Default select example">
                                                <option <?= ($c_integracao_zabbix['statusIntegracao'] == "1") ? "selected" : "" ?> value="1">Sim</option>
                                                <option <?= ($c_integracao_zabbix['statusIntegracao'] == "0") ? "selected" : "" ?> value="0">Não</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="tokenAPI" class="form-label">Token API Zabbix</label>
                                            <input <?= ($c_integracao_zabbix['tokenAPI'] === NULL) ? "" : 'value="' . $c_integracao_zabbix['tokenAPI'] . '"' ?> name="tokenAPI" id="tokenAPI" class="form-control" type="text"></input>
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="text-center">
                                        <button class="btn btn-danger" type="submit">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require "../../../includes/footer.php";
?>