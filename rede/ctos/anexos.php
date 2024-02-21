<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$uid = $_SESSION['id'];

$submenu_id = "48";

$permissions = "SELECT u.perfil_id
FROM usuarios u
JOIN perfil_permissoes_submenu pp
ON u.perfil_id = pp.perfil_id
WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions = $pdo->prepare($permissions);
$exec_permissions->execute();

$rowCount_permissions = $exec_permissions->rowCount();

if ($rowCount_permissions > 0) {

    $id = $_GET['id'];
?>
    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-8">
                                <h2 class="card-title">Anexos</h2>
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
                    $dir = "../../uploads/chamados/chamado$id/";

                    // Verifica se o diretório existe
                    if (is_dir($dir)) {
                        // Obtém a lista de arquivos no diretório
                        $files = scandir($dir);

                        // Tamanho desejado para as imagens
                        $width = 150; // Largura
                        $height = 150; // Altura

                        // Exibe as imagens em uma galeria
                        echo "<div class='image-gallery'>";

                        // Itera sobre os arquivos
                        foreach ($files as $file) {
                            // Verifica se o arquivo é uma imagem (extensões comuns: jpg, jpeg, png, gif)
                            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            if ($ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "gif") {
                                // Exibe o arquivo como uma imagem com tamanho fixo e legenda
                                echo "<div class='image-container'>";
                                echo "<a href='$dir/$file' target='_blank'>";

                                echo "<img src='$dir/$file' alt='$file' width='$width' height='$height' />";
                                echo "</a>";
                                //echo "<div class='image-caption'>$file</div>";

                                // Remove a barra extra no final do diretório
                                $dir = rtrim($dir, '/');


                                echo "</div>";
                            }
                        }

                        echo "</div>"; // Fechando a galeria
                    } else {
                        echo "Nenhuma imagem encontrada para esta CTO.";
                    }

                    ?>
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