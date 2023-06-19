<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Documentação</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-9">
                                <h5 class="card-title">Lista de documentações</h5>
                            </div>
                            <div class="col-lg-3">
                                <a href="document_criar.php">
                                    <button style="margin-top: 15px" type="button" class="btn btn-danger">
                                        Nova Documentação
                                    </button>
                                </a>
                            </div>
                        </div>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Documentação</th>
                                    <th scope="col">Criador</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $lista_documentacoes = "SELECT d.id as 'id', d.title as title, p.nome as criador 
                                FROM documentation as d LEFT JOIN usuarios as u ON u.id = d.criador LEFT JOIN pessoas as p ON p.id = u.pessoa_id";

                                // Executar a consulta SQL
                                $stmt = $pdo->query($lista_documentacoes);

                                // Iterar sobre os resultados
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $idDocument = $row['id'];
                                    $title = $row['title'];
                                    $criador = $row['criador'];
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $idDocument; ?></th>
                                        <td><?= $title; ?></td>
                                        <td><?= $criador; ?></td>
                                        <td><a href="document_edit.php?id=<?= $idDocument; ?>">Visualizar</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
require "../../includes/footer.php";
?>