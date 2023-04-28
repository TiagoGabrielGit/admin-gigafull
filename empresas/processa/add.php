<?php
require "../../conexoes/conexao.php";
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

        if (!isset($_POST['atributoCliente'])) {
            $_POST['atributoCliente'] = 2;
        }

        if (!isset($_POST['atributoFornecedor'])) {
            $_POST['atributoFornecedor'] = 2;
        }

        if (!isset($_POST['atributoPrestadorServico'])) {
            $_POST['atributoPrestadorServico'] = 2;
        }

        if (!isset($_POST['atributoTransportadora'])) {
            $_POST['atributoTransportadora'] = 2;
        }

        if (!isset($_POST['atributoEmpresaPropria'])) {
            $_POST['atributoEmpresaPropria'] = 2;
        }

        //Obtem os dados
        $razaoSocial = $_POST['razaoSocial'];
        $fantasia = $_POST['fantasia'];
        $cnpj = $_POST['cnpj'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $celular = $_POST['celular'];
        $atributoCliente = $_POST['atributoCliente'];
        $atributoEmpresaPropria = $_POST['atributoEmpresaPropria'];
        $atributoFornecedor = $_POST['atributoFornecedor'];
        $atributoPrestadorServico = $_POST['atributoPrestadorServico'];
        $atributoTransportadora = $_POST['atributoTransportadora'];
        $logradouro = $_POST['logradouro'];
        $numero = $_POST['numero'];
        $complemento = $_POST['complemento'];

        //Realiza o cadastro da empresa
        $result_empresa = "INSERT INTO empresas (telefone, celular, razaoSocial, fantasia, cnpj, email, atributoEmpresaPropria, atributoCliente, atributoFornecedor, atributoPrestadorServico, atributoTransportadora, deleted, criado)
        VALUES ('$telefone', '$celular', '$razaoSocial', '$fantasia', '$cnpj', '$email', '$atributoEmpresaPropria', '$atributoCliente', '$atributoFornecedor', '$atributoPrestadorServico', '$atributoTransportadora', '1', NOW())";
        $resultado = mysqli_query($mysqli, $result_empresa);

        //Obtem ID do cadastro realizado
        $id_empresa = mysqli_insert_id($mysqli);

        //Realiza o cadastro do endereco
        $result_endereco = "INSERT INTO empresas_endereco (empresa_id, logradouro_id, numero, complemento, criado) VALUES ('$id_empresa','$logradouro','$numero','$complemento', NOW())";
        $resultado_endereco = mysqli_query($mysqli, $result_endereco);
        
        if (mysqli_affected_rows($mysqli) > 0) { ?>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Cadastro realizado com Sucesso!</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo "$razaoSocial"; ?>
                        </div>
                        <div class="modal-footer">
                            <a href="/empresas/empresas.php"><button type="button" class="btn btn-success">Ok</button></a>
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
                            <h4 class="modal-title" id="myModalLabel">Erro ao realizar cadastro!</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo "$razaoSocial"; ?>
                        </div>
                        <div class="modal-footer">
                            <a href="/empresas/empresas.php"><button type="button" class="btn btn-danger">Ok</button></a>
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