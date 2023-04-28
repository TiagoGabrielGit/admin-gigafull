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
    <link href="../..//alerts/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../..//alerts/js/bootstrap.min.js"></script>
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

        $id = $_POST['id'];
        $razaoSocial = $_POST['razaoSocial'];
        $telefone = $_POST['telefone'];
        $celular = $_POST['celular'];
        $fantasia = $_POST['fantasia'];
        $cnpj = $_POST['cnpj'];
        $email = $_POST['email'];
        $atributoCliente = $_POST['atributoCliente'];
        $atributoEmpresaPropria = $_POST['atributoEmpresaPropria'];
        $atributoFornecedor = $_POST['atributoFornecedor'];
        $atributoPrestadorServico = $_POST['atributoPrestadorServico'];
        $atributoTransportadora = $_POST['atributoTransportadora'];
        $logradouro = $_POST['logradouro'];
        $numero = $_POST['numero'];
        $complemento = $_POST['complemento'];

        $result = "UPDATE empresas SET celular='$celular', atributoEmpresaPropria='$atributoEmpresaPropria', atributoTransportadora='$atributoTransportadora', atributoPrestadorServico='$atributoPrestadorServico', atributoCliente='$atributoCliente', atributoFornecedor='$atributoFornecedor', razaoSocial='$razaoSocial', fantasia='$fantasia', cnpj='$cnpj', email='$email', telefone='$telefone', modificado=NOW() WHERE id='$id'";
        $resultado = mysqli_query($mysqli, $result);


        $result_endereco = "UPDATE empresas_endereco SET logradouro_id='$logradouro', numero='$numero', complemento='$complemento', modificado=NOW() WHERE empresa_id='$id'";
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
                            <?php echo $razaoSocial; ?>
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
                            <h4 class="modal-title" id="myModalLabel">Erro ao editar!</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo $razaoSocial; ?>
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