<?php
require "../../protect.php";
require "../../conexoes/conexao.php";
require "../../conexoes/sql.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Network Admin</title>
    <link href="../../alerts/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../../alerts/js/bootstrap.min.js"></script>
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

        //Cadastra pessoa
        $result_pessoas = "INSERT INTO `pessoas`( `nome`, `email`, `telefone`, `celular`, `cpf`, `atributoCliente`, `atributoPrestadorServico`, `permiteUsuario`, `deleted`, `criado`) VALUES ('$nome','$email','$telefone','$celular','$cpf','$atributoCliente', '$atributoPrestadorServico','$permiteUsuario', '1' , NOW())";
        $resultado = mysqli_query($mysqli, $result_pessoas);


        //Obtem ID do cadastro realizado
        $id_pessoa = mysqli_insert_id($mysqli);

        //Realiza o cadastro do endereco
        $result_endereco = "INSERT INTO pessoas_endereco (pessoa_id, logradouro_id, numero, complemento, criado) VALUES ('$id_pessoa','$logradouro','$numero','$complemento', NOW())";
        $resultado_endereco = mysqli_query($mysqli, $result_endereco);

        if (mysqli_affected_rows($mysqli) > 0) { ?>

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Cadastro realizado com Sucesso!</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo "$nome"; ?>
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

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Erro ao realizar cadastro!</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo "$razaoSocial"; ?>
                        </div>
                        <div class="modal-footer">
                            <a href="/empresas.php"><button type="button" class="btn btn-danger">Ok</button></a>
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