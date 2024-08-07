<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "18";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT u.perfil_id
    FROM usuarios u
    JOIN perfil_permissoes_submenu pp ON u.perfil_id = pp.perfil_id
    WHERE u.id = $uid AND 
    pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {

    $idUsuario = $_GET['id'];

    $sql_usuario =
        "SELECT 
        user.id as id, 
        pess.nome as nome,
        pess.email as email,
        user.senha as senha,
        user.perfil_id as idPerfil,
        user.mobile as mobile,
        user.control as control,
        user.dashboard as dashboard,
        user.notify_smart as 'notify_smart',
        user.notify_email_abertura as 'notify_email_abertura',
        user.notify_email_encaminhamento as 'notify_email_encaminhamento',
        user.notify_email_relatos as 'notify_email_relatos', 
        user.notify_email_apropriacao as 'notify_email_apropriacao',
        user.notify_email_execucao as 'notify_email_execucao',
        up.permite_abrir_chamados_outras_empresas as 'permite_abrir_chamados_outras_empresas',
        up.permite_atender_chamados as 'permite_atender_chamados',
        up.permite_atender_chamados_outras_empresas as 'permite_atender_chamados_outras_empresas',
        up.permite_interagir_chamados as 'permite_interagir_chamados',
        up.permite_encaminhar_chamados as 'permite_encaminhar_chamados',
        up.permite_gerenciar_interessados as 'permite_gerenciar_interessados',
        up.permite_gerenciar_incidente as 'permite_gerenciar_incidente',
        up.permite_selecionar_competencias_abertura_chamado as 'permite_selecionar_competencias_abertura_chamado',
        up.permite_selecionar_solicitantes_abertura_chamado as 'permite_selecionar_solicitantes_abertura_chamado',
        up.permite_selecionar_atendente_abertura_chamado as 'permite_selecionar_atendente_abertura_chamado',
        up.permite_alterar_configuracoes_chamado as 'permite_alterar_configuracoes_chamado',
        up.permite_visualizar_protocolo_erp as 'permite_visualizar_protocolo_erp',
        up.permite_configurar_privacidade_equipamentos as 'permite_configurar_privacidade_equipamentos',
        up.permite_configurar_privacidade_credenciais as 'permite_configurar_privacidade_credenciais',
        up.permissao_equipamentos_pop as 'permissao_equipamentos_pop',
        up.permissao_vms as 'permissao_vms',
        up.permissao_email as 'permissao_email',
        up.permissao_portal as 'permissao_portal',
        up.permissao_pop_site as 'permissao_pop_site',

        p.perfil as nome_perfil,
        user.chatIdTelegram as chatIdTelegram,
        CASE
            WHEN user.active = 1 THEN 'Ativado'
            WHEN user.active = 0 THEN 'Inativado'
        END AS active,     
        CASE
            WHEN user.notify_email = 1 THEN 'Ativado'
            WHEN user.notify_email = 0 THEN 'Inativado'
        END AS notify_email,
        CASE
            WHEN user.notify_smart = 1 THEN 'Ativado'
            WHEN user.notify_smart = 0 THEN 'Inativado'
        END AS notify_smart,
        CASE
            WHEN user.notify_telegram = 1 THEN 'Ativado'
            WHEN user.notify_telegram = 0 THEN 'Inativado'
        END AS notify_telegram
        FROM usuarios as user
        LEFT JOIN pessoas as pess ON pess.id = user.pessoa_id
        LEFT JOIN perfil as p ON p.id = user.perfil_id
        LEFT JOIN usuarios_permissoes as up ON user.id = up.usuario_id
        WHERE user.id = $idUsuario";

    $r_sql_usuario = mysqli_query($mysqli, $sql_usuario) or die("Erro ao retornar dados");
    $campos = $r_sql_usuario->fetch_array();

    $sql_perfil =
        "SELECT
p.id as idPerfil,
p.perfil as perfil
FROM perfil as p
WHERE p.active = 1";

    $horarioColaborador = "SELECT * FROM colaborador_horario WHERE user_id = $idUsuario";
    $r_horarioColaborador = $pdo->query($horarioColaborador);
    if ($r_horarioColaborador->rowCount() > 0) {
        // Existem registros para o user_id
        $row = $r_horarioColaborador->fetch(PDO::FETCH_ASSOC);

        // Preencha os campos do formulário com os valores do banco de dados
        $seg_ini_p1 = $row['seg_ini_p1'];
        $seg_fim_p1 = $row['seg_fim_p1'];
        $seg_ini_p2 = $row['seg_ini_p2'];
        $seg_fim_p2 = $row['seg_fim_p2'];

        $ter_ini_p1 = $row['ter_ini_p1'];
        $ter_fim_p1 = $row['ter_fim_p1'];
        $ter_ini_p2 = $row['ter_ini_p2'];
        $ter_fim_p2 = $row['ter_fim_p2'];

        $qua_ini_p1 = $row['qua_ini_p1'];
        $qua_fim_p1 = $row['qua_fim_p1'];
        $qua_ini_p2 = $row['qua_ini_p2'];
        $qua_fim_p2 = $row['qua_fim_p2'];

        $qui_ini_p1 = $row['qui_ini_p1'];
        $qui_fim_p1 = $row['qui_fim_p1'];
        $qui_ini_p2 = $row['qui_ini_p2'];
        $qui_fim_p2 = $row['qui_fim_p2'];

        $sex_ini_p1 = $row['sex_ini_p1'];
        $sex_fim_p1 = $row['sex_fim_p1'];
        $sex_ini_p2 = $row['sex_ini_p2'];
        $sex_fim_p2 = $row['sex_fim_p2'];

        $sab_ini_p1 = $row['sab_ini_p1'];
        $sab_fim_p1 = $row['sab_fim_p1'];
        $sab_ini_p2 = $row['sab_ini_p2'];
        $sab_fim_p2 = $row['sab_fim_p2'];

        $dom_ini_p1 = $row['dom_ini_p1'];
        $dom_fim_p1 = $row['dom_fim_p1'];
        $dom_ini_p2 = $row['dom_ini_p2'];
        $dom_fim_p2 = $row['dom_fim_p2'];
    } else {
        $seg_ini_p1 = "";
        $seg_fim_p1 = "";
        $seg_ini_p2 = "";
        $seg_fim_p2 = "";

        $ter_ini_p1 = "";
        $ter_fim_p1 = "";
        $ter_ini_p2 = "";
        $ter_fim_p2 = "";

        $qua_ini_p1 = "";
        $qua_fim_p1 = "";
        $qua_ini_p2 = "";
        $qua_fim_p2 = "";

        $qui_ini_p1 = "";
        $qui_fim_p1 = "";
        $qui_ini_p2 = "";
        $qui_fim_p2 = "";

        $sex_ini_p1 = "";
        $sex_fim_p1 = "";
        $sex_ini_p2 = "";
        $sex_fim_p2 = "";

        $sab_ini_p1 = "";
        $sab_fim_p1 = "";
        $sab_ini_p2 = "";
        $sab_fim_p2 = "";

        $dom_ini_p1 = "";
        $dom_fim_p1 = "";
        $dom_ini_p2 = "";
        $dom_fim_p2 = "";
    }

    $gerenteColaborador = "SELECT p.nome as 'gerente', u.id as 'usuario'FROM colaborador_gerencia as cg LEFT JOIN usuarios as u ON u.id = cg.gerente_id LEFT JOIN pessoas as p ON p.id = u.pessoa_id WHERE user_id  = $idUsuario";
    $r_gerenteColaborador = $pdo->query($gerenteColaborador);
    if ($r_gerenteColaborador->rowCount() > 0) {
        $rowGerente = $r_gerenteColaborador->fetch(PDO::FETCH_ASSOC);

        $gerente = $rowGerente['gerente'];
        $usuarioGerente = $rowGerente['usuario'];

        if ($usuarioGerente <> null) {
            $opcaoGerente = '<option value="' . $usuarioGerente . '" selected="">' . $gerente . '</option>';
        } else {
            $opcaoGerente = '<option value="" disabled selected="">Selecione...</option>';
        }
    } else {
        $opcaoGerente = '<option value="" disabled selected="">Selecione...</option>';
    }

    $coordenadorColaborador = "SELECT p.nome as 'coordenador', u.id as 'usuario'FROM colaborador_gerencia as cg LEFT JOIN usuarios as u ON u.id = cg.coordenador_id LEFT JOIN pessoas as p ON p.id = u.pessoa_id WHERE user_id  = $idUsuario";
    $r_coordenadorColaborador = $pdo->query($coordenadorColaborador);
    if ($r_coordenadorColaborador->rowCount() > 0) {
        $rowCoordenador = $r_coordenadorColaborador->fetch(PDO::FETCH_ASSOC);

        $coordenador = $rowCoordenador['coordenador'];
        $usuarioCoordenador = $rowCoordenador['usuario'];

        if ($usuarioCoordenador <> null) {
            $opcaoCoordenador = '<option value="' . $usuarioCoordenador . '" selected="">' . $coordenador . '</option>';
        } else {
            $opcaoCoordenador = '<option value="" disabled selected="">Selecione...</option>';
        }
    } else {
        $opcaoCoordenador = '<option value="" disabled selected="">Selecione...</option>';
    }
?>

    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="dados-tab" data-bs-toggle="tab" data-bs-target="#dados" type="button" role="tab" aria-controls="dados" aria-selected="true">Informações</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="colaborador-tab" data-bs-toggle="tab" data-bs-target="#colaborador" type="button" role="tab" aria-controls="colaborador" aria-selected="true">Colaborador</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="competencia-tab" data-bs-toggle="tab" data-bs-target="#competencia" type="button" role="tab" aria-controls="competencia" aria-selected="true">Competência</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="log-tab" data-bs-toggle="tab" data-bs-target="#log" type="button" role="tab" aria-controls="log" aria-selected="true">LOGs</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="permission-tab" data-bs-toggle="tab" data-bs-target="#permission" type="button" role="tab" aria-controls="permission" aria-selected="true">Permissões</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="notificacao-tab" data-bs-toggle="tab" data-bs-target="#notificacao" type="button" role="tab" aria-controls="notificacao" aria-selected="true">Notificação</button>
                                            </li>
                                        </ul>

                                        <div class="tab-content pt-2" id="myTabContent">
                                            <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                                                <?php require "tabs/information.php" ?>
                                            </div>


                                            <div class="tab-pane fade" id="colaborador" role="tabpanel" aria-labelledby="colaborador-tab">
                                                <?php require "tabs/colaborador.php"
                                                ?>
                                            </div>


                                            <div class="tab-pane fade" id="competencia" role="tabpanel" aria-labelledby="competencia-tab">
                                                <?php require "tabs/competencias.php"
                                                ?>
                                            </div>

                                            <div class="tab-pane fade" id="log" role="tabpanel" aria-labelledby="log-tab">
                                                <?php require "tabs/log.php"
                                                ?>
                                            </div>

                                            <div class="tab-pane fade" id="permission" role="tabpanel" aria-labelledby="permission-tab">
                                                <?php require "tabs/permission.php"
                                                ?>
                                            </div>

                                            <div class="tab-pane fade" id="notificacao" role="tabpanel" aria-labelledby="notificacao-tab">
                                                <?php require "tabs/notificacao.php"
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

    <script>
        $("#nomeUsuario").change(function() {
            var pessoaSelecionada = $(this).children("option:selected").val();

            $.ajax({
                url: "/api/pesquisa_email.php",
                method: "GET",
                dataType: "HTML",
                data: {
                    id: pessoaSelecionada
                }
            }).done(function(resposta) {
                document.getElementById("inputEmail").value = '';
                document.getElementById("inputEmail").value = resposta;
            }).fail(function(resposta) {
                alert(resposta)
            });
        });
    </script>

    <script>
        function mostrarOcultarSelect() {
            var tipoAcessoSmart = document.getElementById("inviteAcessoSmart");
            var divConfiguracoesUsuario = document.getElementById("inviteConfiguracoesUsuario");

            if (tipoAcessoSmart.checked) {
                divConfiguracoesUsuario.style.display = "block";
            } else {
                divConfiguracoesUsuario.style.display = "none";
            }
        }
    </script>

    <script>
        function incluirCompetencia(idCompetencia, idUsuario, nomeUsuario, competencia) {
            document.querySelector("#idIncluirCompetencia").value = idCompetencia;
            document.querySelector("#idUsuarioCompetencia").value = idUsuario;

            let mensagemConfirmCompetencia = ` 
                     
        Deseja atribuir a competência <b> ${competencia} </b> ao usuário  <b> ${nomeUsuario} </b>?`
            document.querySelector("#msgConfirmCompetencia").innerHTML = mensagemConfirmCompetencia
        }
    </script>

    <script>
        function retirarCompetencia(idUC, nomeUsuario2, competencia2) {
            document.querySelector("#idUC").value = idUC;

            let mensagemRetirarCompetencia = ` 
                     
        Deseja retirar a competência <b> ${competencia2} </b> do usuário  <b> ${nomeUsuario2} </b>?`
            document.querySelector("#msgRetirarCompetencia").innerHTML = mensagemRetirarCompetencia
        }
    </script>

    <script>
        $("#btnConfirmCompetencia").click(function() {
            var dadosIncluiCompetencia = $("#formIncluiCompetencia").serialize();

            $.post("processa/incluiCompetencia.php", dadosIncluiCompetencia, function(retornaIncluiCompetencia) {
                location.reload();

            });
        });
    </script>

    <script>
        $("#btnRetirarCompetencia").click(function() {
            var dadosRetirarCompetencia = $("#formRetirarCompetencia").serialize();

            $.post("processa/retiraCompetencia.php", dadosRetirarCompetencia, function(retornaRetirarCompetencia) {
                location.reload();

            });
        });
    </script>

    <script>
        $("#btnReset").click(function() {
            var senhaProvisoria = gerarSenhaProvisoria();
            var dadosFormulario = $("#resetarSenha").serialize();

            // Enviar dados via AJAX
            $.ajax({
                url: "processa/alterarSenha.php", // Substitua pelo caminho correto para o arquivo que salvará no banco de dados
                type: "POST",
                data: dadosFormulario + "&senha=" + senhaProvisoria,
                success: function(response) {
                    document.querySelector("#msgConfirmacao").hidden = true;
                    document.querySelector("#btnReset").hidden = true;
                    $("#msgSenhaGerada").slideDown('slow').html(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#msgSenhaGerada").slideDown('slow').html(response);
                }
            });
        });
    </script>

    <script>
        function gerarSenhaProvisoria() {
            var caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()";
            var senha = "";
            var comprimentoSenha = 15; // Define o comprimento da senha (pode ser ajustado conforme necessário)

            for (var i = 0; i < comprimentoSenha; i++) {
                var indiceAleatorio = Math.floor(Math.random() * caracteres.length);
                senha += caracteres.charAt(indiceAleatorio);
            }

            return senha;
        };
    </script>

    <script>
        $("#btnHorarioTrabalho").click(function() {
            var dadosHorarioTrabalho = $("#formHorarioTrabalho").serialize();

            // Enviar dados via AJAX
            $.ajax({
                url: "processa_colaborador/horario_trabalho.php",
                type: "POST",
                data: dadosHorarioTrabalho,
                success: function(responseHorarioTrabalho) {
                    $("#msgHorarioTrabalho").slideDown('slow').html(responseHorarioTrabalho);

                    // Aguardar 1 segundo e depois ocultar a mensagem
                    setTimeout(function() {
                        $("#msgHorarioTrabalho").slideUp('slow');
                        location.reload();
                    }, 1000);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#msgHorarioTrabalho").slideDown('slow').html(responseHorarioTrabalho);

                    // Aguardar 1 segundo e depois ocultar a mensagem
                    setTimeout(function() {
                        $("#msgHorarioTrabalho").slideUp('slow');
                        location.reload();
                    }, 1000);
                }
            });
        });
    </script>

    <script>
        $("#btnGerencia").click(function() {
            var dadosGerencia = $("#formGerencia").serialize();

            // Enviar dados via AJAX
            $.ajax({
                url: "processa_colaborador/gerencia.php",
                type: "POST",
                data: dadosGerencia,
                success: function(responseGerencia) {
                    $("#msgGerencia").slideDown('slow').html(responseGerencia);

                    // Aguardar 1 segundo e depois ocultar a mensagem
                    setTimeout(function() {
                        $("#msgGerencia").slideUp('slow');
                        location.reload();
                    }, 1000);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#msgGerencia").slideDown('slow').html(responseGerencia);

                    // Aguardar 1 segundo e depois ocultar a mensagem
                    setTimeout(function() {
                        $("#msgGerencia").slideUp('slow');
                        location.reload();
                    }, 1000);
                }
            });
        });
    </script>


<?php
} else {
    require($_SERVER['DOCUMENT_ROOT'] . '/acesso_negado.php');
}
require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
?>