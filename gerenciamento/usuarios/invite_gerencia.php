<?php
require "../../includes/menu.php";
try {
    require "../../conexoes/conexao_pdo.php";
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql_invite =
        "SELECT
        ui.id as 'id',
        e.fantasia as 'empresa',
        CASE
        WHEN tipo_acesso = 1 THEN 'Smart'
        WHEN tipo_acesso = 2 THEN 'Cliente'
        WHEN tipo_acesso = 3 THEN 'Tenant'
        END as 'tipo_acesso',
        p.perfil as 'perfil',
        CASE
        WHEN ui.permissao_chamado = 1 THEN 'Apenas por empresa'
        WHEN ui.permissao_chamado = 2 THEN 'Apenas por equipe'
        WHEN ui.permissao_chamado = 3 THEN 'Empresa e Equipe'
        END as 'permissao_chamados',
        CASE
        WHEN ui.validade_invite < NOW() THEN 'Expirado'
        WHEN ui.validade_invite > NOW() THEN ui.validade_invite
        END AS 'validade',
        CASE
        WHEN ui.active = 1 THEN 'Ativo'
        WHEN ui.active = 0 THEN 'Inativo'
        END as 'status'
        FROM 
        usuario_invite as ui
        LEFT JOIN
        empresas as e
        ON
        ui.empresa_id = e.id
        LEFT JOIN
        perfil as p
        ON
        p.id = ui.perfil_id
        ORDER BY
        ui.id DESC";

    $stmt = $pdo->prepare($sql_invite);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
    exit;
}
?>

<style>
    #tabelaLista:hover {
        cursor: pointer;
        background-color: #E0FFFF;
    }
</style>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Gerência Invites</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <h5 class="card-title">Invites Enviados</h5>
                            </div>
                            <div class="col-lg-4">
                                <a href="usuarios.php">
                                    <button style="margin-top: 15px" type="button" class="btn btn-danger">
                                        Listagem Usuários
                                    </button>
                                </a>
                            </div>
                        </div>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Empresa</th>
                                    <th scope="col">Tipo Acesso</th>
                                    <th scope="col">Perfil</th>
                                    <th scope="col">Permissão Chamados</th>
                                    <th scope="col">Validade</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $row) : ?>
                                    <tr id="tabelaLista" onclick="location.href='edit_invite.php?id=<?= $row['id'] ?>'">
                                        <th scope="row"><?= $row['id']; ?></th>
                                        <td><?= $row['empresa']; ?></td>
                                        <td><?= $row['tipo_acesso']; ?></td>
                                        <td><?= $row['perfil']; ?></td>
                                        <td><?= $row['permissao_chamados']; ?></td>
                                        <td><?= $row['validade']; ?></td>
                                        <td><?= $row['status']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->
<?php
require "../../includes/footer.php";
?>