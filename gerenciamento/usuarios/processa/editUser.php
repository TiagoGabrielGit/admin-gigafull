<?php
require "../../../conexoes/conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartControl</title>
    <link href="/alerts/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/alerts/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container theme-showcase" role="main">
        <?php
        $id = $_POST['id'];

        $perfil = $_POST['perfil'];
        $active = $_POST['situacao'];
        $notEmail = $_POST['notificaEmail'];
        $permissaoAberturaChamado = $_POST['permissaoAberturaChamado'];
        $tipoUser = $_POST['tipoAcesso'];
        if ($tipoUser == "1") {
            $perfil = $_POST['perfil'];
            $permissaoVisualizaChamado = $_POST['permissaoVisualizaChamado'];
            $permissaoAbrirChamado = $_POST['permissaoAbrirChamado'];
            $permissaoApropriarChamados = $_POST['permissaoApropriarChamados'];
            $permissaoEncaminharChamados = $_POST['permissaoEncaminharChamados'];
            $permissaoInteressadosChamados = $_POST['permissaoInteressadosChamados'];
            $permissaoSelecionarCompetencias = $_POST['permissaoSelecionarCompetencias'];
        } else if ($tipoUser == "2" || $tipoUser == "3") {
            $perfil = "0";
            $permissaoVisualizaChamado = "0";
            $permissaoAbrirChamado = "0";
            $permissaoApropriarChamados = "0";
            $permissaoEncaminharChamados = "0";
            $permissaoInteressadosChamados = "0";
            $permissaoSelecionarCompetencias = "0";
        }

        $empresaID = $_POST['empresaSelect'];

        $resultEditUser = "UPDATE usuarios SET permissao_selecionar_competencias='$permissaoSelecionarCompetencias', permissao_visualiza_chamado='$permissaoVisualizaChamado', 
        permissao_chamado='$permissaoAberturaChamado', notify_email='$notEmail', empresa_id='$empresaID',
        tipo_usuario='$tipoUser', perfil_id='$perfil', active='$active', modificado=NOW(), permissao_abrir_chamado='$permissaoAbrirChamado',
        permissao_apropriar_chamado='$permissaoApropriarChamados', permissao_encaminhar_chamado='$permissaoEncaminharChamados', permissao_interessados_chamados='$permissaoInteressadosChamados' WHERE id='$id'"

        ?>

        <?php
        $resultado = mysqli_query($mysqli, $resultEditUser);

        if (mysqli_affected_rows($mysqli) > 0) { ?>

            <div class="modal fade" id="myModalSenhaOk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Alterado com Sucesso!</h4>
                        </div>

                        <div class="modal-body">
                            Alterações realizadas.
                        </div>
                        <div class="modal-footer">
                            <a href="/gerenciamento/usuarios/view.php?id=<?= $id ?>"><button type="button" class="btn btn-success">Ok</button></a>
                        </div>
                    </div>
                </div>
            </div>


            <script>
                $(document).ready(function() {
                    $('#myModalSenhaOk').modal('show');
                });
            </script>
        <?php } else { ?>

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Erro ao alterar!</h4>
                        </div>
                        <div class="modal-body">
                            Erro, verifique.
                        </div>
                        <div class="modal-footer">
                            <a href="/gerenciamento/usuarios/view.php?id=<?= $id ?>"><button type="button" class="btn btn-danger">Ok</button></a>
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