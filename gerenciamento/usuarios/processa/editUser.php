<?php
require "../../../conexoes/conexao.php";
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
        $id = $_POST['id'];

        $perfil = $_POST['perfil'];
        $active = $_POST['situacao'];
        $tipoUser = $_POST['tipoAcesso'];

        if ($tipoUser == "3") {
            if (empty($_POST['parceiroSelect'])) {
                $parceiro = "";
            } else {
                $parceiro = $_POST['parceiroSelect'];
            }
        } else {
            $parceiro = "";
        }




        $resultEditUser = "UPDATE usuarios SET parceiroRN_id=NULLIF('$parceiro', ''), tipo_usuario='$tipoUser', perfil_id='$perfil', active='$active', modificado=NOW() WHERE id='$id'"

        ?>

        <?php
        $resultado = mysqli_query($mysqli, $resultEditUser);

        if (mysqli_affected_rows($mysqli) > 0) { ?>

            <div class="modal fade" id="myModalSenhaOk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Alterado com Sucesso!</h4>
                        </div>

                        <div class="modal-body">
                            Alterações realizadas.
                        </div>
                        <div class="modal-footer">
                            <a href="/gerenciamento/usuarios/view.php?id=<?= $id ?>"><button type="button" class="btn btn-success">Ok</button></a>
                        </div>
                    </div>
                </div>
            </div>


            <script>
                $(document).ready(function() {
                    $('#myModalSenhaOk').modal('show');
                });
            </script>
        <?php } else { ?>

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Erro ao alterar!</h4>
                        </div>
                        <div class="modal-body">
                            Erro, verifique.
                        </div>
                        <div class="modal-footer">
                            <a href="/gerenciamento/usuarios/view.php?id=<?= $id ?>"><button type="button" class="btn btn-danger">Ok</button></a>
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