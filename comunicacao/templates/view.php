<?php
require "../../includes/menu.php";
require "../../conexoes/conexao_pdo.php";

$submenu_id = "40";
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
    $sql_template = "SELECT ct.titulo as titulo, ct.template as template, ct.active as active, ct.tipo as tipo, ct.aplicado as aplicado
    FROM comunicacao_templates as ct
    WHERE ct.id = :id";
    $stmt = $pdo->prepare($sql_template);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $titulo = $result['titulo'];
        $template = $result['template'];
        $tipo = $result['tipo'];
        $aplicado = $result['aplicado'];
        $active = $result['active'];
    }
?>


    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edição de Template</h5>

                    <hr class="sidebar-divider">
                    <form method="POST" action="processa/editar_template.php">
                        <input id="id" name="id" value="<?= $id ?>" hidden readonly></input>

                        <div class="row">
                            <div class="col-lg-7">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label" for="title">Titulo</label>
                                        <input value="<?= $titulo ?>" required class="form-control" id="title" name="title"></input>
                                    </div>
                                </div>
                                <br>
                                <div class="row">

                                    <div class="col-12">
                                        <label class="form-label" for="conteudo">Template</label>

                                        <textarea id="conteudo" name="conteudo" class="form-control"><?= $template ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="status" class="form-label">Status</label>
                                        <select required id="status" name="status" class="form-select">
                                            <option value="" disabled>Selecione...</option>
                                            <option value="1" <?php if ($active == 1) echo "selected"; ?>>Ativo</option>
                                            <option value="0" <?php if ($active == 0) echo "selected"; ?>>Inativo</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <label for="tipo" class="form-label">Tipo</label>
                                        <select required id="tipo" name="tipo" class="form-select">
                                            <option value="" disabled selected>Selecione...</option>
                                            <option value="1" <?php if ($tipo == 1) echo "selected"; ?>>E-mail</option>
                                            <option value="2" <?php if ($tipo == 2) echo "selected"; ?>>WR Gateway</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label for="aplicado" class="form-label">Aplicado</label>
                                        <select required id="aplicado" name="aplicado" class="form-select">
                                            <option value="" disabled selected>Selecione...</option>
                                            <option value="1" <?php if ($aplicado == 1) echo "selected"; ?>>Incidentes</option>
                                            <option value="2" <?php if ($aplicado == 2) echo "selected"; ?>>Manutenção Programada</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="col-12">
                            <div class="text-center">
                                <button class="btn btn-sm btn-danger" type="submit">Salvar Alterações</button>
                            </div>
                        </div>
                    </form>
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