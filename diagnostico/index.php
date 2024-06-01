<?php
require($_SERVER['DOCUMENT_ROOT'] . '/includes/menu.php');
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Código do Cliente</title>
    <link rel="stylesheet" href="/path/to/your/styles.css">
</head>

<body>
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="process_form.php">
                                <div class="col-6">
                                    <label class="form-label" for="codigo">Código do Cliente</label>
                                    <input required class="form-control" id="codigo" name="codigo" type="text">
                                </div>
                                <div class="col-6 mt-3">
                                    <button type="submit" class="btn btn-primary">Enviar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php
    require($_SERVER['DOCUMENT_ROOT'] . '/includes/securityfooter.php');
    ?>
</body>

</html>