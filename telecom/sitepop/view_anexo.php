<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$usuarioID = $_SESSION['id'];
$idPOP = $_GET['id'];


$menu_id = "6";
$uid = $_SESSION['id'];

$permissions_menu =
    "SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_menu pp ON u.perfil_id = pp.perfil_id 
    WHERE u.id = $uid AND pp.url_menu = $menu_id";

$exec_permissions_menu = $pdo->prepare($permissions_menu);
$exec_permissions_menu->execute();

$rowCount_permissions_menu = $exec_permissions_menu->rowCount();

if ($rowCount_permissions_menu > 0) {

$sql_pop =
    "SELECT
    pop.id as id,
    pop.pop as pop,
    pop.apelidoPop as apelidoPop
    FROM pop as pop
    LEFT JOIN pop_address as endereco ON endereco.pop_id = pop.id
    LEFT JOIN empresas as emp ON emp.id = pop.empresa_id
    WHERE pop.active = 1 and pop.id = $idPOP    
    ORDER BY emp.fantasia asc, endereco.city asc, pop.pop asc
";

$resultado = mysqli_query($mysqli, $sql_pop);
$row = mysqli_fetch_assoc($resultado);


?>

<main id="main" class="main">

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">POP <?= $row['pop']; ?></h5>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="informacoes-tab" data-bs-toggle="tab" data-bs-target="#informacoes" type="button" role="tab" aria-controls="informacoes" aria-selected="true" onclick="window.location.href = 'view_informacoes.php?id=<?= $idPOP ?>';">Informacoes</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link " id="equipamentos-tab" data-bs-toggle="tab" data-bs-target="#equipamentos" type="button" role="tab" aria-controls="equipamentos" aria-selected="false" onclick="window.location.href = 'view_equipamentos.php?id=<?= $idPOP ?>';">Equipamentos</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="energia-tab" data-bs-toggle="tab" data-bs-target="#energia" type="button" role="tab" aria-controls="energia" aria-selected="false" onclick="window.location.href = 'view_energia.php?id=<?= $idPOP ?>';">Energia</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="anexo-tab" data-bs-toggle="tab" data-bs-target="#anexo" type="button" role="tab" aria-controls="anexo" aria-selected="false" onclick="window.location.href = 'view_anexo.php?id=<?= $idPOP ?>';">Anexos</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="atividades-tab" data-bs-toggle="tab" data-bs-target="#atividades" type="button" role="tab" aria-controls="atividades" aria-selected="false" onclick="window.location.href = 'view_atividades.php?id=<?= $idPOP ?>';">Atividades</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="vistoria-tab" data-bs-toggle="tab" data-bs-target="#vistoria" type="button" role="tab" aria-controls="vistoria" aria-selected="false" onclick="window.location.href = 'view_vistoria.php?id=<?= $idPOP ?>';">Vistoria</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="card-body">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-8">
                                            <h2 class="card-title">Anexos</h2>
                                        </div>
                                        <div class="col-4 d-flex justify-content-end">
                                            <button style="margin-top: 15px" type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalAnexarImagem">
                                                Anexar Imagem
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <style>
                                    .image-gallery {
                                        display: flex;
                                        flex-wrap: wrap;
                                        justify-content: center;
                                    }

                                    .image-container {
                                        margin: 10px;
                                        text-align: center;
                                    }

                                    .image-container img {
                                        display: block;
                                        margin-bottom: 10px;
                                    }

                                    .image-container .image-caption {
                                        font-size: 14px;
                                    }
                                </style>

                                <?php
                                $dirDates = "../../../uploads/pop/pop$idPOP/";

                                if (is_dir($dirDates)) {
                                    $folders = glob($dirDates . '*', GLOB_ONLYDIR);
                                ?>
                                    <div class="col-lg-12">

                                        <div class="col-12">
                                            <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <select class="form-select" required name="pastas">
                                                            <option disabled value="" selected>Selecione uma data</option>
                                                            <?php
                                                            foreach ($folders as $folder) {
                                                                if ($folder !== "." && $folder !== "..") {
                                                                    $dirname = basename($folder);
                                                                    // Verifica se a opção atual corresponde à data pesquisada
                                                                    $selected = ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["pastas"]) && $_POST["pastas"] === $dirname) ? "selected" : "";
                                                                    echo '<option value="' . $dirname . '" ' . $selected . '>' . $dirname . '</option>';
                                                                }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <button type="submit" class="btn btn-danger btn-sm">Buscar Imagens</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                <?php
                                } else {
                                    echo "Nenhuma imagem encontrada para o POP.";
                                }

                                function getProtocol()
                                {
                                    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
                                }

                                function getRootDomain($host)
                                {
                                    $hostParts = explode('.', $host);
                                    $count = count($hostParts);

                                    if ($count > 2) {
                                        if (strlen($hostParts[$count - 2]) <= 3 && strlen($hostParts[$count - 1]) <= 3) {
                                            return $hostParts[$count - 3] . '.' . $hostParts[$count - 2] . '.' . $hostParts[$count - 1];
                                        }
                                    }

                                    return $hostParts[$count - 2] . '.' . $hostParts[$count - 1];
                                }

                                $protocol = getProtocol();
                                $fullDomain = $_SERVER['HTTP_HOST'];
                                $rootDomain = getRootDomain($fullDomain);

                                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["pastas"])) {
                                    $selectedDir = $_POST["pastas"];

                                    $dir = "../../../uploads/pop/pop$idPOP/$selectedDir/";
                                    $finalUrl = $protocol . '://smartuploads.' . $rootDomain . '/pop/pop' . $idPOP . '/' . $selectedDir;

                                    $dir = $dirDates . $selectedDir . "/";

                                    if (is_dir($dir)) {
                                        // Obtém a lista de arquivos no diretório
                                        $files = scandir($dir);

                                        // Tamanho desejado para as imagens
                                        $width = 300; // Largura
                                        $height = 300; // Altura

                                        // Exibe as imagens em uma galeria
                                        echo "<div class='image-gallery'>";

                                        // Itera sobre os arquivos
                                        foreach ($files as $file) {
                                            // Verifica se o arquivo é uma imagem (extensões comuns: jpg, jpeg, png, gif)
                                            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                            if ($ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "gif") {

                                                // Exibe o arquivo como uma imagem com tamanho fixo e legenda
                                                echo "<div class='image-container'>";
                                                echo "<a href='$finalUrl/$file' target='_blank'>";

                                                echo "<img src='$finalUrl/$file' alt='$file' width='$width' height='$height' />";
                                                echo "</a>";
                                                echo "<div class='image-caption'>$file</div>";

                                                // Remove a barra extra no final do diretório
                                                $dir = rtrim($dir, '/');

                                                echo "<button class='btn btn-dark rounded-pill btn-sm' onclick='deleteImage(\"../$dir/$file\")'>Excluir</button>";

                                                echo "</div>";
                                            }
                                        }

                                        echo "</div>"; // Fechando a galeria
                                    } else {
                                        echo "Nenhuma imagem encontrada para este POP.";
                                    }
                                }
                                ?>
                            </div>


                            <div class="modal fade" id="modalAnexarImagem" tabindex="-1">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Anexar Imagem</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="card-body">
                                                <form action="/telecom/sitepop/processa/upload.php" method="POST" enctype="multipart/form-data" id="uploadForm">

                                                    <div id="imageFields">

                                                        <div class="col-lg-12">
                                                            <div class="col-12 d-flex justify-content-end">
                                                                <button type="button" class="btn btn-primary" onclick="addImageField()">Adicionar Imagem</button>
                                                            </div>
                                                            <div class="row image-field">
                                                                <label class="form-label">Imagem 1:</label>
                                                                <div class="col-6">
                                                                    <input class="form-control" type="file" name="images[]" accept="image/*" required>
                                                                </div>
                                                                <div class="col-6">
                                                                    <input class="form-control" type="text" name="captions[]" placeholder="Legenda" maxlength="15" required>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="text-center">
                                                        <input readonly hidden type="text" name="popId" value="<?= $idPOP ?>">
                                                        <input class="btn btn-danger" type="submit" value="Realizar Upload">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                function addImageField() {
                                    const imageFields = document.getElementById('imageFields');
                                    const imageCount = imageFields.childElementCount + 1;

                                    const imageField = document.createElement('div');
                                    imageField.classList.add('row', 'image-field', 'mb-3');

                                    const imageLabel = document.createElement('label');
                                    imageLabel.textContent = `Imagem ${imageCount}:`;
                                    imageLabel.classList.add('form-label');
                                    imageField.appendChild(imageLabel);

                                    const imageWrapper = document.createElement('div');
                                    imageWrapper.classList.add('col-5');

                                    const imageInput = document.createElement('input');
                                    imageInput.classList.add('form-control');
                                    imageInput.type = 'file';
                                    imageInput.name = 'images[]';
                                    imageInput.accept = 'image/*';
                                    imageInput.required = true;
                                    imageWrapper.appendChild(imageInput);

                                    imageField.appendChild(imageWrapper);

                                    const captionWrapper = document.createElement('div');
                                    captionWrapper.classList.add('col-5');

                                    const captionInput = document.createElement('input');
                                    captionInput.classList.add('form-control');
                                    captionInput.type = 'text';
                                    captionInput.name = 'captions[]';
                                    captionInput.placeholder = 'Legenda';
                                    captionInput.required = true;
                                    captionInput.maxLength = 15;
                                    captionWrapper.appendChild(captionInput);

                                    imageField.appendChild(captionWrapper);

                                    const removeButtonWrapper = document.createElement('div');
                                    removeButtonWrapper.classList.add('col-2');

                                    const removeButton = document.createElement('button');
                                    removeButton.type = 'button';
                                    removeButton.classList.add('btn', 'btn-danger', 'ms-2');
                                    removeButton.textContent = 'Remover';
                                    removeButton.addEventListener('click', () => {
                                        imageField.remove();
                                    });
                                    removeButtonWrapper.appendChild(removeButton);

                                    imageField.appendChild(removeButtonWrapper);

                                    imageFields.appendChild(imageField);
                                }

                                function deleteImage(imageUrl) {
                                    if (confirm("Tem certeza de que deseja excluir esta imagem? " + imageUrl)) {
                                        fetch('processa/delete_anexo.php', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json'
                                                },
                                                body: JSON.stringify({
                                                    imageUrl: imageUrl
                                                })
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.success) {
                                                    location.reload();
                                                } else {
                                                    alert('Falha ao excluir a imagem. Por favor, tente novamente.');
                                                }
                                            })
                                            .catch(error => {
                                                console.error('Erro ao excluir a imagem:', error);
                                                alert('Ocorreu um erro ao excluir a imagem. Por favor, tente novamente.');
                                            });
                                    }
                                }

                                document.getElementById('uploadForm').addEventListener('submit', (event) => {
                                    const imageInputs = document.querySelectorAll('input[name="images[]"]');
                                    const isEmpty = Array.from(imageInputs).some((input) => input.files.length === 0);

                                    if (isEmpty) {
                                        event.preventDefault();
                                        alert('Por favor, selecione todas as imagens.');
                                    }
                                });
                            </script>
                        </div>
                    </div><!-- End Default Tabs -->
                </div>
            </div>
        </div>
    </section>
</main>
<?php
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>