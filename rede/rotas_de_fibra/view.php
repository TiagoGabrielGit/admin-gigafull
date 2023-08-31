<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";
$idRota = $_GET['id'];

$sql_rota = "SELECT
                rf.codigo as codigo,
                rf.ponta_a as pontaA,
                rf.ponta_b as pontaB,
                rf.active as active
            FROM
                rotas_fibra as rf
            WHERE
                rf.id = :idRota";

try {
    // Prepara e executa a consulta usando prepared statements
    $stmt = $conn->prepare($sql_rota);
    $stmt->bindParam(':idRota', $idRota, PDO::PARAM_INT);
    $stmt->execute();

    // Obtém o resultado da consulta como um array associativo
    $rota = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro na consulta: " . $e->getMessage();
}

?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">ID: <?= $idRota ?></h5>

                        <?php
                        if (isset($_GET['error'])) {
                            $errorMessage = $_GET['error'];

                            if ($errorMessage === 'codigo_ja_existe') {
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                echo 'O código já esta cadastrado no banco de dados.';
                                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                                echo '</div>';
                            }
                        }
                        ?>

                        <br>
                        <form action="processa/updateCadastroCoordenada.php" method="POST" class="row g-3">

                            <input readonly hidden name="id" type="text" class="form-control" id="id" value="<?= $idRota ?>">
                            <div class="row">
                                <div class="col-4">
                                    <label for="pontaA" class="form-label">Ponta A</label>
                                    <select class="form-select" id="pontaA" name="pontaA" required>
                                        <option value="<?= $rota['pontaA'] ?>" selected><?= $rota['pontaA'] ?></option>
                                        <?php
                                        $sql_pop =
                                            "SELECT
                                                    p.id as idPOP,
                                                    p.pop as pop,
                                                    pa.city
                                                FROM
                                                    pop as p
                                                LEFT JOIN
                                                pop_address as pa
                                                ON
                                                pa.pop_id = p.id    
                                                WHERE
                                                    p.active = 1
                                                ORDER BY
                                                    p.pop ASC";

                                        $r_pop = mysqli_query($mysqli, $sql_pop);
                                        while ($c_pop = mysqli_fetch_object($r_pop)) :
                                            echo "<option value='$c_pop->pop ($c_pop->city)'> $c_pop->pop ($c_pop->city)</option>";
                                        endwhile;
                                        ?>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="pontaB" class="form-label">Ponta B</label>
                                    <select class="form-select" id="pontaB" name="pontaB" required>
                                        <option value="<?= $rota['pontaB'] ?>" selected><?= $rota['pontaB'] ?></option>
                                        <?php
                                        $sql_pop =
                                            "SELECT
                                                    p.id as idPOP,
                                                    p.pop as pop,
                                                    pa.city
                                                FROM
                                                    pop as p
                                                LEFT JOIN
                                                pop_address as pa
                                                ON
                                                pa.pop_id = p.id    
                                                WHERE
                                                    p.active = 1
                                                ORDER BY
                                                    p.pop ASC";

                                        $r_pop = mysqli_query($mysqli, $sql_pop);
                                        while ($c_pop = mysqli_fetch_object($r_pop)) :
                                            echo "<option value='$c_pop->pop ($c_pop->city)'> $c_pop->pop ($c_pop->city)</option>";
                                        endwhile;
                                        ?>
                                    </select>
                                </div>

                                <div class="col-2">
                                    <label for="codigoRota" class="form-label">Código</label>
                                    <input name="codigoRota" type="number" class="form-control" id="codigoRota" value="<?= $rota['codigo']; ?>" required>
                                </div>

                                <div class="col-2">
                                    <label for="activeRota" class="form-label">Status</label>
                                    <select class="form-select" id="activeRota" name="activeRota" required>
                                        <option value="" disabled selected>Selecione...</option>
                                        <option value="0" <?= ($rota['active'] == 0) ? 'selected' : ''; ?>>Inativo</option>
                                        <option value="1" <?= ($rota['active'] == 1) ? 'selected' : ''; ?>>Ativo</option>
                                    </select>
                                </div>
                            </div>
                            <hr class="sidebar-divider">

                            <div class="text-center">
                                <button type="submit" class="btn btn-danger">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Coordenadas</h5>
                        <br>
                        <form action="processa/cadastrarCoordenadas.php" method="POST" class="row g-3">

                            <input readonly hidden name="idRota" type="text" class="form-control" id="idRota" value="<?= $idRota ?>">


                            <div class="row">
                                <div class="col-3">
                                    <label for="coordenada_inicial" class="form-label">Coordenada Inicial:</label>
                                    <input class="form-control" type="text" id="coordenada_inicial" name="coordenada_inicial">
                                </div>
                                <div class="col-3">
                                    <label for="coordenada_final" class="form-label">Coordenada Final:</label>
                                    <input class="form-control" type="text" id="coordenada_final" name="coordenada_final">
                                </div>
                                <div class="col-4">
                                    <label for="proprietario" class="form-label">Proprietário:</label>
                                    <select class="form-select" id="proprietario" name="proprietario">
                                        <option value="" disabled selected>Selecione...</option>
                                        <?php
                                        $sql_empresa =
                                            "SELECT
                                                    e.id as idEmpresa,
                                                    e.fantasia as fantasia
                                                    FROM
                                                    empresas as e
                                                    WHERE
                                                    e.atributoFornecedor = 1
                                                    or
                                                    e.atributoEmpresaPropria = 1
                                                    ORDER BY
                                                    e.fantasia ASC
                                                    ";

                                        $r_empresa = mysqli_query($mysqli, $sql_empresa);
                                        while ($c_empresa = mysqli_fetch_object($r_empresa)) :
                                            echo "<option value='$c_empresa->idEmpresa'> $c_empresa->fantasia</option>";
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <br> <button type="submit" class="btn btn-danger">Adicionar</button>
                                </div>
                            </div>
                        </form>

                        <br><br>
                        <table class="table table-striped" id="styleTable">
                            <thead>
                                <tr>
                                    <th scope="col">Coordenada Inicial</th>
                                    <th scope="col">Coordenada Final</th>
                                    <th scope="col">Proprietário</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_lista_coordenadas =
                                    "SELECT
                                    rfc.id as id,
                                    rfc.coordenada_inicial as ci,
                                    rfc.coordenada_final as cf,
                                    e.fantasia as proprietario
                                    FROM
                                    rotas_fibras_coordenadas as rfc
                                    LEFT JOIN
                                    empresas as e
                                    ON
                                    e.id = rfc.proprietario
                                    WHERE
                                    rfc.rota_fibra_id = $idRota
                                    and
                                    rfc.active = 1
                                    ";

                                $r_coordenadas = mysqli_query($mysqli, $sql_lista_coordenadas);

                                while ($c_coordenadas = $r_coordenadas->fetch_array()) {
                                ?>
                                    <tr>
                                        <td style="vertical-align: middle;"><?= $c_coordenadas['ci']; ?></td>
                                        <td style="vertical-align: middle;"><?= $c_coordenadas['cf']; ?></td>
                                        <td style="vertical-align: middle;"><?= $c_coordenadas['proprietario']; ?></td>
                                        <td style="vertical-align: middle;">
                                            <form action="processa/excluirCoordenada.php" method="POST">
                                                <input type="hidden" name="rotaID" value="<?= $idRota ?>">
                                                <input type="hidden" name="coordenada_id" value="<?= $c_coordenadas['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </section>

</main><!-- End #main -->

<?php
require "../../includes/footer.php";
?>