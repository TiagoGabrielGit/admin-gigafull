<script>
    function modalAnexos(id) {
        document.querySelector("#idEquipamento").value = id;
    }
</script>

<div class="modal fade" id="modalAnexos" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Anexos</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">

                                <?php
                                $equipamentID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
                                $diretoriodb = "/telecom/equipamentos/upload/idEquipamento_$equipamentID/";
                                $index_upload =
                                    "SELECT
                                        u.id as id_upload,
                                        u.title as title_upload,
                                        u.diretorio as diretorio_upload,
                                        u.active as active_upload
                                    FROM
                                        upload as u
                                    WHERE
                                        u.active = 1
                                    and
                                        u.diretorio = '$diretoriodb'
                                    ";

                                $result_upload_index = mysqli_query($mysqli, $index_upload)
                                ?>

                                <div class="card">
                                    <div class="card-body">
                                        <!-- Slides with captions -->
                                        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators">
                                                <?php
                                                $cont = 0;
                                                while ($linhas = mysqli_fetch_array($result_upload_index)) {
                                                    if ($cont == 0) { ?>
                                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?= $cont ?>" class="active" aria-current="true" aria-label="Slide <?= $cont ?>"></button>
                                                    <?php } else { ?>
                                                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?= $cont ?>" aria-label="Slide <?= $cont ?>"></button>
                                                <?php }
                                                    $cont++;
                                                } ?>
                                            </div>

                                            <div class="carousel-inner">
                                                <?php

                                                $pesquisa_upload_conteudo =
                                                    "SELECT
                                                    u.id as id_upload,
                                                    u.title as title_upload,
                                                    u.diretorio as diretorio_upload,
                                                    u.active as active_upload
                                                    FROM
                                                    upload as u
                                                    WHERE
                                                    u.active = 1
                                                    and
                                                    u.diretorio = '$diretoriodb'
                                                    ";

                                                $result_upload_conteudo = mysqli_query($mysqli, $pesquisa_upload_conteudo);

                                                $contagem = 0;
                                                while ($conteudo = mysqli_fetch_array($result_upload_conteudo)) {
                                                    if ($contagem == 0) { ?>
                                                        <div class="carousel-item active">
                                                            <img src="<?= $diretoriodb ?><?= $conteudo['title_upload'] ?>" class="d-block w-100" alt="...">
                                                            <label for="titleFile" class="col-12">
                                                                <h4 style="text-align: center;"><?= $conteudo['title_upload'] ?></h4>
                                                            </label>
                                                        </div>

                                                    <?php  } else { ?>
                                                        <div class="carousel-item">
                                                            <img src="<?= $diretoriodb ?><?= $conteudo['title_upload'] ?>" class="d-block w-100" alt="...">
                                                            <label for="titleFile" class="col-12">
                                                                <h4 style="text-align: center;"><?= $conteudo['title_upload'] ?></h4>
                                                            </label>
                                                        </div>

                                                <?php  }

                                                    $contagem++;
                                                } ?>
                                            </div>

                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>

                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>

                                        </div><!-- End Slides with captions -->

                                    </div>
                                </div>



                            </div>


                            <div class="col-12" style="text-align: right;">
                                <a onclick="gerenciaAnexo(<?= $equipamentID ?>)" data-bs-toggle="modal" data-bs-target="#gerenciaAnexos"><input type="button" class="btn btn-secondary" value="Gerenciar arquivos"></input></a>
                            </div>

                            <hr class="sidebar-divider">

                            <form action="processa/upload.php" method="POST" enctype="multipart/form-data" class="row needs-validation">
                            <!--  <form id="insert_anexo" method="POST" enctype="multipart/form-data" class="row needs-validation"> -->

                                <span id="msg"></span>

                                <input hidden name="idEquipamento" id="idEquipamento" />

                                <label for="inputFile" class="col-6 col-form-label">
                                    <h4>Enviar novo arquivo</h4>
                                    <span id="msg"></span>
                                </label>

                                <div class="col-8">
                                    <label for="titleFile" class="form-label">Titulo</label>
                                    <input name="titleFile" type="text" class="form-control" id="titleFile" required>
                                </div>

                                <div class="col-12">
                                    <input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
                                    <label class="form-label"></label>
                                </div>

                                <div class="col-8">
                                    <input class="form-control" type="file" name="file" required />
                                    <label class="form-label">
                                        Formatos suportados: jpeg, jpg, png<br>
                                        <span>Tamanho máximo 50Mb</span>
                                    </label>
                                </div>

                                <div class="col-4" style="text-align: right;">
                                    <!--  <input id="btnAnexar" name="btnAnexar" type="button" value="Enviar arquivo" class="btn btn-primary"></input>  -->
                                    <input class="btn btn-primary" type="submit" value="Enviar arquivo" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class=" modal fade" id="gerenciaAnexos" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Arquivos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Active Table -->
                                        <table class="table table-borderless">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;" scope="col">Arquivo</th>
                                                    <th style="text-align: center;" scope="col">Excluir</th>
                                                    <th style="text-align: center;" scope="col">Download</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $lista_conteudo =
                                                    "SELECT
                                                u.id as id_upload,
                                                u.title as title_upload,
                                                u.diretorio as diretorio_upload,
                                                u.active as active_upload
                                                FROM
                                                upload as u
                                                WHERE
                                                u.active = 1
                                                and
                                                u.diretorio = '$diretoriodb'
                                                ";
                                                $result_lista_conteudos = mysqli_query($mysqli, $lista_conteudo);

                                                while ($popula_table_conteudos = $result_lista_conteudos->fetch_array()) { ?>
                                                    <tr>
                                                        <td style="text-align: center;">
                                                            <?= $popula_table_conteudos['title_upload'] ?>
                                                        </td>

                                                        <td style="text-align: center;">
                                                            <a class="bi bi-trash" onclick=" return confirm('Tem certeza que deseja excluir?')" href="processa/unlink.php?img=<?= $popula_table_conteudos['id_upload'] ?>&eqp=<?= $equipamentID ?>&param=0"></a>
                                                        </td>

                                                        <td style="text-align: center;">
                                                            <a class="bi bi-download" download="" href="<?= $diretoriodb ?><?= $popula_table_conteudos['title_upload'] ?>"></a>
                                                        </td>
                                                    <?php } ?>
                                                    </tr>
                                            </tbody>
                                        </table>
                                        <!-- End Tables without borders -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>