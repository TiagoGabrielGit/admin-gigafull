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
        $nome = $_POST['inputNome'];
        $tipo_usuario = $_POST['tipoAcesso'];
        $nome = $_POST['inputNome'];
        $perfil = $_POST['perfil'];
        $senha = md5($_POST['senha']);
        if ($tipo_usuario == 3) {
            $parceiroRN = $_POST['empresaSelect'];
        } else {
            $parceiroRN = "";
        }

        $result_usuario = "INSERT INTO usuarios (pessoa_id, tipo_usuario, empresa_id, parceiroRN_id, senha, perfil_id, active, criado)
         VALUES ('$nome', '$tipo_usuario', '$parceiroRN', NULLIF('$parceiroRN', ''), '$senha', '$perfil', '1', NOW())";
        $resultado_usuario = mysqli_query($mysqli, $result_usuario);

        if (mysqli_affected_rows($mysqli) > 0) { ?>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Usuário cadastrado com Sucesso!</h4>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <a href="/gerenciamento/usuarios/usuarios.php"><button type="button" class="btn btn-success">Ok</button></a>
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
                            <h4 class="modal-title" id="myModalLabel">Erro ao cadastrar novo usuário!</h4>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                            <a href="/gerenciamento/usuarios/usuarios.php"><button type="button" class="btn btn-danger">Ok</button></a>
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