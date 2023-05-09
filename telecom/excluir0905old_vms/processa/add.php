<?php
require "../../../protect.php";
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

        //Obtem os dados
        $cadastroEmpresa = $_POST['cadastroEmpresa'];
        $cadastroPop = $_POST['cadastroPop'];
        $cadastroServidor = $_POST['cadastroServidor'];
        $cadastroHostname = $_POST['cadastroHostname'];
        $cadastroSO = $_POST['cadastroSO'];
        $cadastroIPAddress = $_POST['cadastroIPAddress'];
        $cadastroDomino = $_POST['cadastroDomino'];
        $cadastroVLAN = $_POST['cadastroVLAN'];
        $cadastroStatusVM = $_POST['cadastroStatusVM'];
        $cadastroMemoria = $_POST['cadastroMemoria'];
        $cadastroVCPU = $_POST['cadastroVCPU'];
        $cadastroDisco1 = $_POST['cadastroDisco1'];
        $cadastroDisco2 = $_POST['cadastroDisco2'];

        if (empty($_POST['cadastroVLAN'])) {
            $cadastroVLAN = $_POST['cadastroVLAN'];
        } else {
            $cadastroVLAN = "";
        }

        //Realiza o cadastro
        $result = "INSERT INTO vms (empresa_id, pop_id, servidor_id, hostname, ipaddress, dominio, vlan, sistemaOperacional, recursoMemoria, recursoCPU, recursoDisco1, recursoDisco2, statusvm, criado) VALUES ('$cadastroEmpresa', '$cadastroPop', '$cadastroServidor', '$cadastroHostname', '$cadastroIPAddress', '$cadastroDomino', '$cadastroVLAN', '$cadastroSO', '$cadastroMemoria', '$cadastroVCPU', '$cadastroDisco1', '$cadastroDisco2', '$cadastroStatusVM', NOW())";
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
                        <a href="/telecom/vms/view.php?id=<?= $id_vm?>"><button type="button" class="btn btn-success">Ok</button></a>
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