<?php
session_start();
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
        $cadastroEmpresa = $_POST['EquipamentocadastroEmpresa'];
        $cadastroPop = $_POST['EquipamentoCadastroPop'];
        $cadastroEquipamento = $_POST['EquipamentocadastroEquipamento'];
        $cadastroTipoEquipamento = $_POST['EquipamentoCadastroTipoEquipamento'];
        $hostname = $_POST['EquipamentoCadastrohostname'];
        $ipaddress = $_POST['EquipamentoCadastroIPAddress'];
        $statusEquipamento = $_POST['EquipamentoCadastroStatus'];
        $rackPop = $_POST['EquipamentoCadastroRackPop'];
        $privacidade = "1";
        $idUsuario = $_SESSION['id'];

        if (empty($_POST['EquipamentoCadastroSerial'])) {
            $serialEquipamento = "";
        } else {
            $serialEquipamento = $_POST['EquipamentoCadastroSerial'];
        }

        //Realiza o cadastro 
        $result = "INSERT INTO equipamentospop (privacidade, usuario_criador, empresa_id, pop_id, equipamento_id, tipoEquipamento_id, hostname, ipaddress, statusEquipamento, deleted, rack_id, serialEquipamento, criado)
        VALUES ('$privacidade', '$idUsuario', '$cadastroEmpresa', '$cadastroPop', '$cadastroEquipamento', '$cadastroTipoEquipamento', '$hostname', '$ipaddress', '$statusEquipamento', '1', '$rackPop', '$serialEquipamento', NOW())";
        $resultado = mysqli_query($mysqli, $result);

        $id_equipamento = mysqli_insert_id($mysqli);

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
                            <a href="/telecom/credentials/equipamentos/view.php?id=<?= $id_equipamento ?>"><button type="button" class="btn btn-success">Ok</button></a>

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
                            <a href="/telecom/credentials/index.php"><button type="button" class="btn btn-danger">Ok</button></a>
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