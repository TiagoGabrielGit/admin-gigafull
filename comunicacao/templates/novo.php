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

?>


    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Novo Template</h5>
                    <hr class="sidebar-divider">
                    <form method="POST" action="processa/novo_template.php">


                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label" for="title">Titulo</label>
                                            <input required class="form-control" id="title" name="title"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="tipo" class="form-label">Tipo</label>
                                            <select required id="tipo" name="tipo" class="form-select">
                                                <option value="" disabled selected>Selecione...</option>
                                                <option value="1">E-mail</option>
                                                <option value="2">WR Gateway</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="aplicado" class="form-label">Aplicado</label>
                                            <select required id="aplicado" name="aplicado" class="form-select">
                                                <option value="" disabled selected>Selecione...</option>
                                                <option value="1">Incidentes</option>
                                                <option value="2">Manutenção Programada</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <textarea id="editorContent" name="editorContent" class="tinymce-editor"></textarea><!-- End TinyMCE Editor -->
                                </div>
                            </div>
                        </div>

                        <br><br>
                        <div class="col-12">
                            <div class="text-center">
                                <button class="btn btn-sm btn-danger" type="submit">Criar Template</button>
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