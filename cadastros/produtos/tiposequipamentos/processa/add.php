<?php
require "../../../../conexoes/conexao.php";
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tipos de Equipamentos - Network Admin</title>
    <link href="../../../../alerts/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../../../../alerts/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container theme-showcase" role="main">
        <?php
        $tipo = $_POST['tipo'];
        $result_tipos = "INSERT INTO tipoequipamento (tipo, deleted, cadastroDefault, criado) VALUES ('$tipo', '1', '2', NOW())";
        $resultado_tipos = mysqli_query($mysqli, $result_tipos);

        if (mysqli_affected_rows($mysqli) > 0) { ?>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Novo tipo cadastrado com Sucesso!</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo $tipo; ?>
                        </div>
                        <div class="modal-footer">
                            <a href="/cadastros/produtos/tiposequipamentos/index.php"><button type="button" class="btn btn-success">Ok</button></a>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $('#myModal').modal('show');
                });
            </script>

        <?php } else { ?>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Erro ao cadastrar novo tipo!</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo $tipo; ?>
                        </div>
                        <div class="modal-footer">
                            <a href="/cadastros/produtos/tiposequipamentos/index.php"><button type="button" class="btn btn-danger">Ok</button></a>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $('#myModal').modal('show');
                });
            </script>
        <?php } ?>


    </div>
</body>

</html>