<?php
require "../../../includes/menu.php";
require "../../../includes/remove_setas_number.php";
require "../../../conexoes/conexao_pdo.php";

$submenu_id = "35";
$uid = $_SESSION['id'];

$permissions_submenu =
    "SELECT 
	u.perfil_id
FROM 
	usuarios u
JOIN 
	perfil_permissoes_submenu pp
ON 
	u.perfil_id = pp.perfil_id
WHERE
	u.id = $uid
AND 
	pp.url_submenu = $submenu_id";

$exec_permissions_submenu = $pdo->prepare($permissions_submenu);
$exec_permissions_submenu->execute();

$rowCount_permissions_submenu = $exec_permissions_submenu->rowCount();

if ($rowCount_permissions_submenu > 0) {
    if (isset($_GET['id'])) {
        //VALIDA SE FOI PASSADO ALGUM ID NA URL DA PAGINA
        $idMP = $_GET['id'];
        $sql_mp =
            "SELECT mp.step as step, mp.titulo as titulo, mp.dataAgendamento as dataAgendamento, mp.duracao as duracao, mp.descricao as descricao, mp.responsavel_contato as responsavel_contato, mp.responsavel_name as responsavel_name
            FROM
            manutencao_programada as mp
            WHERE
            mp.id = :idMP
            ORDER BY mp.id DESC";

        $r_mp = $pdo->prepare($sql_mp);
        $r_mp->bindParam(':idMP', $idMP, PDO::PARAM_INT);
        $r_mp->execute();
        $result = $r_mp->fetch(PDO::FETCH_ASSOC);
        $step = $result['step'];
        $titulo = $result['titulo'];
        $dataAgendamento = $result['dataAgendamento'];
        $duracao = $result['duracao'];
        $descricao = $result['descricao'];
        $responsavel_name = $result['responsavel_name'];
        $responsavel_contato = $result['responsavel_contato'];

        
    } else {
        $verifica_mp_rascunho =
            "SELECT mp.id as idMP, mp.step as step, mp.titulo as titulo, mp.dataAgendamento as dataAgendamento, mp.duracao as duracao, mp.descricao as descricao, mp.responsavel_name as responsavel_name, mp.responsavel_contato as responsavel_contato
        FROM
        manutencao_programada as mp
        WHERE
        mp.usuario_criador = :uid
        and mp.active = 3
        ORDER BY mp.id DESC";

        $r_mp_rascunho = $pdo->prepare($verifica_mp_rascunho);
        $r_mp_rascunho->bindParam(':uid', $uid, PDO::PARAM_INT);

        if ($r_mp_rascunho->execute()) {
            $c_mp_rascunho = $r_mp_rascunho->fetch(PDO::FETCH_ASSOC);

            if ($c_mp_rascunho !== false) {
                $idMP = $c_mp_rascunho['idMP'];

                $step = $c_mp_rascunho['step'];
                $titulo = $c_mp_rascunho['titulo'];
                $dataAgendamento = $c_mp_rascunho['dataAgendamento'];
                $duracao = $c_mp_rascunho['duracao'];
                $descricao = $c_mp_rascunho['descricao'];
                $responsavel_name = $c_mp_rascunho['responsavel_name'];
                $responsavel_contato = $c_mp_rascunho['responsavel_contato'];
            } else {
                //CRIA UMA NOVA MANUTENCAO 
                $novaMP =
                    "INSERT INTO manutencao_programada (usuario_criador, created, active, step) VALUES (:uid, NOW(), 3, 1)";
                $stmt = $pdo->prepare($novaMP);
                $stmt->bindParam(':uid', $uid);

                if ($stmt->execute()) {
                    $idMP = $pdo->lastInsertId();
                    $step = "1";
                    $titulo = "";
                    $dataAgendamento = "";
                    $duracao = "";
                    $descricao = "";
                    $responsavel_name = "";
                    $responsavel_contato = "";
                }
            }
        }
    }

?>

    <main id="main" class="main">
        <section class="section">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Agendar Manutenção Programada <?= $idMP ?> - Passo <?= $step ?></h5>

                        <?php
                        if ($step == 1) {
                            require "step1.php";
                        } else if ($step == 2) {
                            require "step2.php";
                        } else if ($step == 3) {
                            require "step3.php";
                        } else if ($step == 4) {
                            require "step4.php";
                        }
                        ?>

                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#celular').inputmask('(99) 99999-9999');
        });
    </script>

<?php
} else {
    require "../../../acesso_negado.php";
}
require "../../../includes/securityfooter.php";
?>