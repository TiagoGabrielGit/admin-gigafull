<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "39";
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
    $id = $_GET['id'];

    $comunicacao =
        "SELECT
			c.id as id,
			c.msgEmail as msgEmail,
            c.status as status,
            p.nome as nome,
            c.status as statusID,
            CASE
            WHEN status = 0 THEN 'Cancelada'
                                                                WHEN status = 1 THEN 'Rascunho'
                                                                WHEN status = 2 THEN 'Enviada'
            END as status
			FROM comunicacao as c
            LEFT JOIN usuarios as u ON u.id = c.usuario_criador
            LEFT JOIN pessoas as p ON u.pessoa_id = p.id
			WHERE
			c.id = :id";
    $r_comunicacao = $pdo->prepare($comunicacao);
    $r_comunicacao->bindParam(':id', $id, PDO::PARAM_INT); // Vincula o parâmetro :uid como um inteiro


    if ($r_comunicacao->execute()) {
        $c_comunicacao = $r_comunicacao->fetch(PDO::FETCH_ASSOC);

        if ($c_comunicacao !== false) {
            $msgEmail = $c_comunicacao['msgEmail'];
            $status = $c_comunicacao['status'];
            $criador = $c_comunicacao['nome'];
            $statusID = $c_comunicacao['statusID'];
        }
    }
?>

    <main id="main" class="main">
        <section class="section">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12">
                            <div class="text-left">
                                <h5 class="card-title">Gerenciar Comunicação</h5>
                            </div>
                            <div class="text-end">
                                <?php
                                if ($statusID == 1) { ?>
                                    <a href="/comunicacao/comunicar/index.php?<?= $id ?>" class="btn btn-sm btn-danger">Ir para Comunicado</a>
                                <?php }
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-7">
                                <label for="criador" class="form-label">Criador</label><br>
                                <span><b><?= $criador ?></b></span>
                            </div>
                            <div class="col-4">
                                <label for="criador" class="form-label">Status</label><br>
                                <span><b><?= $status ?></b></span>
                            </div>
                        </div>
                        <hr class="sidebar-divider">

                        <div class="row">
                            <div class="col-lg-4">
                                <label for="destinatariosEmail" class="form-label">Lista Destinatários</label>

                                <?php
                                $destinatarios =
                                    "SELECT e.fantasia, en.midia 
                                    FROM comunicacao_destinatarios  as cd
                                    LEFT JOIN empresas_notificacao as en ON en.id = cd.empresa_notificacao_id
                                    LEFT JOIN empresas as e ON e.id = en.empresa_id
                                    WHERE cd.comunicacao_id = :idComunicacao and cd.active = 1";

                                $r_destinatarios = $pdo->prepare($destinatarios);
                                $r_destinatarios->bindParam(':idComunicacao', $id, PDO::PARAM_INT); // Vincula o parâmetro :uid como um inteiro


                                $r_destinatarios->execute();
                                echo "<ul>";

                                while ($c_destinatarios = $r_destinatarios->fetch(PDO::FETCH_ASSOC)) {
                                    $fantasia = $c_destinatarios['fantasia'];
                                    $midia = $c_destinatarios['midia'];
                                    echo "<li>Empresa: $fantasia - $midia</li>";
                                }
                                ?>
                                </ul>
                            </div>
                        </div>

                        <br><br>
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-body">
                                        <br>
                                        <?= $msgEmail ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2"></div>
                        </div>


                    </div>
                </div>
            </div>
        </section>
    </main>

<?php
} else {
    require "../../acesso_negado.php";
}
require "../../includes/securityfooter.php";
?>