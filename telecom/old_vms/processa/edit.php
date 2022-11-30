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
        $id = $_POST['id'];

        //Captura todos os dados        
        $editEmpresa = $_POST['editEmpresa'];
        $editPOP = $_POST['editPOP'];
        $editServidor = $_POST['editServidor'];
        $editHostname = $_POST['editHostname'];
        $editSO = $_POST['editSO'];
        $editIPAddress = $_POST['editIPAddress'];
        $editDominio = $_POST['editDominio'];
        $editVLAN = $_POST['editVLAN'];
        $editStatusVM = $_POST['editStatusVM'];
        $editMemoria = $_POST['editMemoria'];
        $editVCPU = $_POST['editVCPU'];
        $editDisco1 = $_POST['editDisco1'];
        $editDisco2 = $_POST['editDisco2'];
        $anotacaoVM = $_POST['anotacaoVM'];
        $usuario_id = $_SESSION['id'];


        $result_update_vm = "UPDATE vms SET anotacaoVM='$anotacaoVM', empresa_id='$editEmpresa', pop_id='$editPOP', servidor_id='$editServidor', hostname='$editHostname', ipaddress='$editIPAddress',
        dominio='$editDominio', vlan='$editVLAN', sistemaOperacional='$editSO', recursoMemoria='$editMemoria', recursoCPU='$editVCPU', 
        recursoDisco1='$editDisco1', recursoDisco2='$editDisco2', statusvm='$editStatusVM', modificado=NOW() WHERE id='$id'";
        $resultado_eqpop = mysqli_query($mysqli, $result_update_vm);


        if (mysqli_affected_rows($mysqli) > 0) { ?>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Editado com Sucesso!</h4>
                        </div>
                        <div class="modal-body">
                            <?php echo $editHostname; ?>
                        </div>
                        <div class="modal-footer">
                            <a href="/telecom/vms/view.php?id=<?= $_POST['id']; ?>"><button type="button" class="btn btn-success">Ok</button></a>
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
                            <?php echo $editHostname;

                            echo $result_insert_apube;

                            echo $result_update_vm;
                                                       
                            ?>
                        </div>
                        <div class="modal-footer">
                            <a href="/telecom/vms/view.php?id=<?= $_POST['id'];?>"><button type="button" class="btn btn-danger">Ok</button></a>
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