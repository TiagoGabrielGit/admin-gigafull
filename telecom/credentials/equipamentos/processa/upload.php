<?php
require "../../../conexoes/conexao_pdo.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gigafull Admin</title>
    <link href="/alerts/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/alerts/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container theme-showcase" role="main">

        <?php
        $idEquipamento = $_POST['idEquipamento'];
        $location = "../upload/idEquipamento_$idEquipamento/";
        $locationDB = "/telecom/equipamentos/upload/idEquipamento_$idEquipamento/";
        if (!file_exists($location)) {
            mkdir($location, 0777, true);
        }

        if (isset($_FILES['file'])) {
            $formatos = array('jpeg', 'jpg', 'png');
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            if (in_array($ext, $formatos)) {
                $name = $_POST['titleFile'];
                $tmp_name = $_FILES['file']['tmp_name'];
                $newName = $name . "." . $ext;

                $error = $_FILES['file']['error'];
                if ($error !== UPLOAD_ERR_OK) {
                    if ($error == UPLOAD_ERR_INI_SIZE) {
                        $msg_alert = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                    } elseif ($error == UPLOAD_ERR_FORM_SIZE) {
                        $msg_alert =  'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                    } elseif ($error == UPLOAD_ERR_PARTIAL) {
                        $msg_alert =  'The uploaded file was only partially uploaded.';
                    } elseif ($error == UPLOAD_ERR_NO_FILE) {
                        $msg_alert =  'No file was uploaded.';
                    } elseif ($error == UPLOAD_ERR_NO_TMP_DIR) {
                        $msg_alert =  'Missing a temporary folder.';
                    } elseif ($error == UPLOAD_ERR_CANT_WRITE) {
                        $msg_alert =  'Failed to write file to disk.';
                    } elseif ($error == UPLOAD_ERR_EXTENSION) {
                        $msg_alert =  'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.';
                    }
                } elseif (move_uploaded_file($tmp_name, $location . $newName)) {

                    $cont_insert = false;

                    $sql_insert = "INSERT INTO upload (diretorio, title, active)
                                VALUES (:diretorio, :title, '1')";
                    $stmt1 = $pdo->prepare($sql_insert);
                    $stmt1->bindParam(':diretorio', $locationDB);
                    $stmt1->bindParam(':title', $newName);

                    if ($stmt1->execute()) {
                        $cont_insert = true;
                    } else {
                        $cont_insert = false;
                    }

                    if ($cont_insert = true) {
                        $msg_alert = "Envio realizado!";
                    } else {
                        $msg_alert = "Falha no envio!";
                    }
                }
            } else {
                $msg_alert = "Formato não aceito.";
            }
        } else {
            $msg_alert = "Erro não especificado.";
        }
        ?>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Mensagem:</h4>
                    </div>
                    <div class="modal-body">
                        <?= $msg_alert ?>
                    </div>
                    <div class="modal-footer">
                        <a href="/telecom/equipamentos/view.php?id=<?= $idEquipamento ?>"><button type="button" class="btn btn-success">Ok</button></a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#myModal').modal('show');
            });
        </script>

    </div>
</body>

</html>