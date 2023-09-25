<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../conexoes/conexao_pdo.php";
    $idComunicacao = $_POST['idComunicacao'];
    $msgEmail = $_POST['msgEmail'];
    $assuntoEmail = $_POST['assuntoEmail'];



    if (isset($_POST['acao'])) {
        $acao = $_POST['acao'];

        switch ($acao) {
            case "salvar_rascunho":
                try {
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "UPDATE comunicacao SET msgEmail = :msgEmail, assuntoEmail = :assuntoEmail, status = 1 WHERE id = :idComunicacao";

                    $stmt = $pdo->prepare($sql);

                    $stmt->bindParam(':idComunicacao', $idComunicacao, PDO::PARAM_INT);
                    $stmt->bindParam(':msgEmail', $msgEmail, PDO::PARAM_STR);
                    $stmt->bindParam(':assuntoEmail', $assuntoEmail, PDO::PARAM_STR);

                    if ($stmt->execute()) {
                        $envia_notificacao = false;
                        header("Location: /index.php");
                        exit();
                    }
                } catch (PDOException $e) {
                    echo "Erro ao atualizar o status: " . $e->getMessage();
                }
                break;

            case "salvar_enviar":
                try {
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "UPDATE comunicacao SET msgEmail = :msgEmail, assuntoEmail = :assuntoEmail, status = 2 WHERE id = :idComunicacao";

                    $stmt = $pdo->prepare($sql);

                    $stmt->bindParam(':idComunicacao', $idComunicacao, PDO::PARAM_INT);
                    $stmt->bindParam(':msgEmail', $msgEmail, PDO::PARAM_STR);
                    $stmt->bindParam(':assuntoEmail', $assuntoEmail, PDO::PARAM_STR);

                    if ($stmt->execute()) {
                        $envia_notificacao = true;
                    } else {
                        $envia_notificacao = false;
                    }
                } catch (PDOException $e) {
                    echo "Erro ao atualizar o status: " . $e->getMessage();
                }
                break;

            case "cancelar_comunicacao":
                try {
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "UPDATE comunicacao SET status = 0 WHERE id = :idComunicacao";

                    $stmt = $pdo->prepare($sql);

                    $stmt->bindParam(':idComunicacao', $idComunicacao, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        $envia_notificacao = false;
                        header("Location: /index.php");
                        exit();
                    }
                } catch (PDOException $e) {
                    echo "Erro ao atualizar o status: " . $e->getMessage();
                }
                break;

            default:
                // Ação desconhecida
                break;
        }
    }

    if ($envia_notificacao) { ?>
        <script>
            setTimeout(function() {
                var comunicadoID = <?= $idComunicacao ?>;
                fetch('/notificacao/mail/comunicado.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id_comunicacao=' + comunicadoID
                }).then(function(response) {
                    if (response.ok) {
                        window.location.href = "/index.php";
                    } else {
                        window.location.href = "/index.php";
                    }
                }).catch(function(error) {
                    console.error('Erro na requisição:', error);
                });
            });
        </script>
    <?php
    } else {
    ?>
<?php
    }
}
