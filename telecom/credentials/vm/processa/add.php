<?php
require "../../../../conexoes/conexao.php";
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

        //Obtem os dados
        $cadastroEmpresa = $_POST['VMcadastroEmpresa'];
        $cadastroPop = $_POST['VMcadastroPop'];
        $cadastroServidor = $_POST['VMcadastroServidor'];
        $cadastroHostname = $_POST['VMcadastroHostname'];
        $cadastroSO = $_POST['VMcadastroSO'];
        $cadastroIPAddress = $_POST['VMcadastroIPAddress'];
        $cadastroDomino = $_POST['VMcadastroDomino'];
        $cadastroVLAN = $_POST['VMcadastroVLAN'];
        $cadastroStatusVM = $_POST['VMcadastroStatus'];
        $cadastroMemoria = $_POST['VMcadastroMemoria'];
        $cadastroVCPU = $_POST['VMcadastroVCPU'];
        $cadastroDisco1 = $_POST['VMcadastroDisco1'];
        $cadastroDisco2 = $_POST['VMcadastroDisco2'];
        $privacidade = "1";
        $idUsuario = $_SESSION['id'];

        if (empty($_POST['VMcadastroVLAN'])) {
            $cadastroVLAN = $_POST['VMcadastroVLAN'];
        } else {
            $cadastroVLAN = "";
        }

        //Realiza o cadastro
        $result = "INSERT INTO vms (privacidade, usuario_criador, empresa_id, pop_id, servidor_id, hostname, ipaddress, dominio, vlan, sistemaOperacional, recursoMemoria, recursoCPU, recursoDisco1, recursoDisco2, statusvm, criado)
        VALUES ('$privacidade', '$idUsuario', '$cadastroEmpresa', '$cadastroPop', '$cadastroServidor', '$cadastroHostname', '$cadastroIPAddress', '$cadastroDomino', '$cadastroVLAN', '$cadastroSO', '$cadastroMemoria', '$cadastroVCPU', '$cadastroDisco1', '$cadastroDisco2', '$cadastroStatusVM', NOW())";
        $resultado = mysqli_query($mysqli, $result);

        $id_vm = mysqli_insert_id($mysqli);

        if (mysqli_affected_rows($mysqli) > 0) { ?>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Cadastro realizado com Sucesso!</h4>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer">
                        <a href="/telecom/credentials/vm/view.php?id=<?= $id_vm?>"><button type="button" class="btn btn-success">Ok</button></a>
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
                        </div>
                        <div class="modal-footer">
                            <a href="/telecom/vms/index.php"><button type="button" class="btn btn-danger">Ok</button></a>
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