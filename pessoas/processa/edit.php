<?php
require "../../protect.php";
require "../../conexoes/conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Network Admin</title>
    <link href="/alerts/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/alerts/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container theme-showcase" role="main">

        <?php
        if (!isset($_POST['atributoCliente'])) {
            $_POST['atributoCliente'] = 2;
        }

        if (!isset($_POST['permiteUsuario'])) {
            $_POST['permiteUsuario'] = 2;
        }

        if (!isset($_POST['atributoPrestadorServico'])) {
            $_POST['atributoPrestadorServico'] = 2;
        }

        $id = $_POST['id'];
        $nome = $_POST['nomePessoa'];
        $cpf = $_POST['cpf'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $celular = $_POST['celular'];
        $atributoCliente = $_POST['atributoCliente'];
        $permiteUsuario = $_POST['permiteUsuario'];
        $atributoPrestadorServico = $_POST['atributoPrestadorServico'];
        $logradouro = $_POST['logradouro'];
        $numero = $_POST['numero'];
        $complemento = $_POST['complemento'];

        $result = "UPDATE pessoas SET nome='$nome', cpf='$cpf', email='$email', telefone='$telefone', celular='$celular', atributoCliente='$atributoCliente', permiteUsuario='$permiteUsuario', atributoPrestadorServico='$atributoPrestadorServico', modificado=NOW() WHERE id='$id'";
        $resultado = mysqli_query($mysqli, $result);


        $result_endereco = "UPDATE pessoas_endereco SET logradouro_id='$logradouro', numero='$numero', complemento='$complemento', modificado=NOW() WHERE pessoa_id='$id'";
        $resultado_endereco = mysqli_query($mysqli, $result_endereco);

        if (mysqli_affected_rows($mysqli) > 0) { ?>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Editado com Sucesso!</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo $nome; ?>
                        </div>
                        <div class="modal-footer">
                            <a href="/pessoas/pessoas.php"><button type="button" class="btn btn-success">Ok</button></a>
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
                            <h4 class="modal-title" id="myModalLabel">Erro ao editar!</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo $nome; ?>
                        </div>
                        <div class="modal-footer">
                            <a href="/pessoas/pessoas.php"><button type="button" class="btn btn-danger">Ok</button></a>
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