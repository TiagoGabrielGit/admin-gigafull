<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

$submenu_id = "67";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT u.perfil_id 
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = $uid AND pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $sql_credenciais_portal =
        "SELECT
        portal.id as cred_id,
        portal.privacidade as cred_priv,
        portal.portaldescricao as cred_descricao,
        portal.paginaacesso as cred_portal,
        portal.usuario_id as user_criador,

        portal.portalusuario as cred_usuario,
        portal.portalsenha as cred_senha,
        portal.tipo as cred_tipo,
        portal.anotacao as anotacaoEmail,
        emp.fantasia as emp_fantasia,
        p.nome as nomeCriador
        FROM
        credenciais_portal as portal
        LEFT JOIN
        empresas as emp
        ON
        emp.id = portal.empresa_id
        LEFT JOIN
        usuarios as u
        ON
        u.id = portal.usuario_id
        LEFT JOIN
        pessoas as p
        ON
        u.pessoa_id = p.id
        WHERE
        portal.id = '$id'";

    $resultado = mysqli_query($mysqli, $sql_credenciais_portal);
    $row = mysqli_fetch_assoc($resultado);
    $credencialTipo = $row['cred_tipo'];

    if ($row['cred_priv'] == 1) {
        require "view_liberado.php";
    } else if ($row['user_criador'] == $_SESSION['id']) {
        require "view_liberado.php";
    } else if ($row['cred_priv'] == 2) {
        $userId = $_SESSION['id'];

        // Verificar se o equipamento está liberado para o usuário
        $sql_check_perm_user = "SELECT * FROM credenciais_portal_privacidade_usuario WHERE credencial_id = :id AND usuario_id = :userId";
        $stmt_check_perm_user = $pdo->prepare($sql_check_perm_user);
        $stmt_check_perm_user->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_check_perm_user->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt_check_perm_user->execute();

        // Verificar se o equipamento está liberado para alguma equipe do usuário
        $sql_check_perm_equipe = "SELECT * FROM credenciais_portal_privacidade_equipe WHERE credencial_id = :id AND equipe_id IN (SELECT equipe_id FROM equipes_integrantes WHERE integrante_id = :userId)";
        $stmt_check_perm_equipe = $pdo->prepare($sql_check_perm_equipe);
        $stmt_check_perm_equipe->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_check_perm_equipe->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt_check_perm_equipe->execute();

        if ($stmt_check_perm_user->rowCount() > 0 || $stmt_check_perm_equipe->rowCount() > 0) {
            require "view_liberado.php";
        } else {
            require "../../../acesso_negado.php";
        }
    } else {
        require "../../../acesso_negado.php";
    }
?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>


    <script>
        $(document).ready(function() {

            $('#cadastroTipo').on('change', function() {

                var selectValor = '#' + $(this).val();
                //alert(selectValor);
                $('#formularioCredenciais').children('div').hide();
                $('#formularioCredenciais').children(selectValor).show();
                $(selectValor).children('div').show();

            })
        })
    </script>

    <script>
        $("#add-campo").click(function() {
            $("#portal").append(`
                    <br><br>
    
                    <hr class="sidebar-divider">
    
                    <div class="col-6" style="display: inline-block;">
                    <label for="portalDescricao" class="form-label">Descrição</label>
                    <input name="portalDescricao[]" type="text" class="form-control" id="portalDescricao" required>
                    </div>
    
                    <br>
                 
                    <div class="col-4" style="display: inline-block;">
                    <label for="portalUsuarioSenha" class="form-label">Usuário</label>
                    <input name="portalUsuario[]" type="text" class="form-control" id="portalUsuario" required>
                    </div>
    
                    <div class="col-4" style="display: inline-block;">
                    <label for="portalSenha" class="form-label">Senha</label>
                    <input name="portalSenha[]" type="text" class="form-control" id="portalSenha" required>
                    </div>
    
                    `);
        });
    </script>


    <script>
        $("#cadastroEmpresa").change(function() {
            var empresaSelecionada = $(this).children("option:selected").val();

            $.ajax({
                url: "/api/pesquisa_equipamentos_via_empresa.php",
                method: "GET",
                dataType: "HTML",
                data: {
                    id: empresaSelecionada
                }
            }).done(function(resposta) {
                $("#equipamentoEquipamento").html(resposta);
            }).fail(function(resposta) {
                alert(resposta)
            });
        });
    </script>


    <script>
        $("#cadastroEmpresa").change(function() {
            var empresaSelecionada = $(this).children("option:selected").val();

            $.ajax({
                url: "/api/pesquisa_vms_via_empresa.php",
                method: "GET",
                dataType: "HTML",
                data: {
                    id: empresaSelecionada
                }
            }).done(function(resposta) {
                $("#vmVm").html(resposta);
            }).fail(function(resposta) {
                alert(resposta)
            });
        });
    </script>


    <script>
        $("#btnSalvar").click(function() {
            var dados = $("#addCredenciais").serialize();

            $.post("portal/processa/add.php", dados, function(retorna) {
                $("#msg").slideDown('slow').html(retorna);

                //Limpar os campos
                $('#addCredenciais')[0].reset();

                //Apresentar a mensagem leve
                retirarMsg();
            });
        });

        //Retirar a mensagem após 1700 milissegundos
        function retirarMsg() {
            setTimeout(function() {
                $("#msg").slideUp('slow', function() {});
            }, 1700);
        }
    </script>

    <script>
        $("#editEmpresa").change(function() {
            var empresaSelecionada = $(this).children("option:selected").val();

            $.ajax({
                url: "/api/pesquisa_vms_via_empresa.php",
                method: "GET",
                dataType: "HTML",
                data: {
                    id: empresaSelecionada
                }
            }).done(function(resposta) {
                $("#editVM").html(resposta);
            }).fail(function(resposta) {
                alert(resposta)
            });
        });
    </script>

    <script>
        $("#btnSalvarEdit").click(function() {
            var dados = $("#editCredenciais").serialize();

            $.post("processa/edit.php", dados, function(retorna) {

                $("#msg").slideDown('slow').html(retorna);

                //Apresentar a mensagem leve
                retirarMsg();
            });
        });

        //Retirar a mensagem após 1700 milissegundos
        function retirarMsg() {

            setTimeout(function() {

                location.reload();
                $("#msg").slideUp('slow', function() {});

            }, 1700);
        }
    </script>

<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>