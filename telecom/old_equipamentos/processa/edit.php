<?php
session_start();
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

                if (isset($_POST['editEquipamentoRack1'])) {

                        $rack_id = $_POST['editEquipamentoRack1'];
                } else {
                        $rack_id = "0";
                }

                if (empty($_POST['inputSerial'])) {
                        $serialEquipamento = "";
                } else {
                        $serialEquipamento = $_POST['inputSerial'];
                }

                if (empty($_POST['portaWeb'])) {
                        $portaWeb = "";
                } else {
                        $portaWeb = $_POST['portaWeb'];
                }

                if (empty($_POST['portaSSH'])) {
                        $portaSSH = "";
                } else {
                        $portaSSH = $_POST['portaSSH'];
                }

                if (empty($_POST['portaTelnet'])) {
                        $portaTelnet = "";
                } else {
                        $portaTelnet = $_POST['portaTelnet'];
                }

                if (empty($_POST['portaWinbox'])) {
                        $portaWinbox = "";
                } else {
                        $portaWinbox = $_POST['portaWinbox'];
                }


                //Captura todos os dados        
                $inputEmpresa = $_POST['inputEmpresa'];
                $inputPop = $_POST['editEquipamentoPop'];
                $inputHostname = $_POST['inputHostname'];
                $inputFabricante = $_POST['inputFabricante'];
                $inputEquipamento = $_POST['inputEquipamento'];
                $inputTipoEquipamento = $_POST['inputTipoEquipamento'];
                $inputIpAddress = $_POST['inputIpAddress'];
                $inputStatus = $_POST['inputStatus'];
                $anotacaoEquipamento = $_POST['anotacaoEquipamento'];
                $usuario_id = $_SESSION['id'];



                $result_update_eqpop = "UPDATE equipamentospop SET serialEquipamento='$serialEquipamento', portaTelnet='$portaTelnet', portaSSH='$portaSSH', portaWeb='$portaWeb', portaWinbox='$portaWinbox', anotacaoEquipamento='$anotacaoEquipamento', empresa_id='$inputEmpresa', pop_id='$inputPop', ipaddress='$inputIpAddress', hostname='$inputHostname', tipoEquipamento_id='$inputTipoEquipamento', equipamento_id='$inputEquipamento', statusEquipamento='$inputStatus', rack_id='$rack_id', modificado=NOW() WHERE id='$id'";
                $resultado_eqpop = mysqli_query($mysqli, $result_update_eqpop);


                if (mysqli_affected_rows($mysqli) > 0) { ?>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                                <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel">Editado com Sucesso!</h4>
                                                </div>
                                                <div class="modal-body">
                                                        <?php echo $inputHostname; ?>
                                                </div>
                                                <div class="modal-footer">
                                                        <a href="/telecom/equipamentos/index.php"><button type="button" class="btn btn-success">Ok</button></a>
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
                                                        <?= $result_update_eqpop; ?> <>
                                                        <?php echo $inputHostname; ?>
                                                </div>
                                                <div class="modal-footer">
                                                        <a href="/telecom/equipamentos/index.php"><button type="button" class="btn btn-danger">Ok</button></a>
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