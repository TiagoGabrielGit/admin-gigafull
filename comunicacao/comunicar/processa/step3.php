<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../conexoes/conexao_pdo.php";
    $idComunicacao = $_POST['idComunicacao'];
    $msgEmail = $_POST['msgEmail'];
    $assuntoEmail = $_POST['assuntoEmail'];
    $normalizacao = $_POST['normalizacao'];
    if (isset($_POST['acao'])) {
        $acao = $_POST['acao'];

        switch ($acao) {
            case "salvar_rascunho":
                try {
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "UPDATE comunicacao SET status = 1 WHERE id = :idComunicacao";

                    $stmt = $pdo->prepare($sql);

                    $stmt->bindParam(':idComunicacao', $idComunicacao, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        header("Location: /index.php");
                        exit();
                    }
                } catch (PDOException $e) {
                    echo "Erro ao atualizar o status: " . $e->getMessage();
                }
                break;
            case "voltar":
                try {



                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "UPDATE comunicacao SET step = 2 WHERE id = :idComunicacao";

                    $stmt = $pdo->prepare($sql);

                    $stmt->bindParam(':idComunicacao', $idComunicacao, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        header("Location: /comunicacao/comunicar/index.php");
                        exit();
                    } else {
                        header("Location: /comunicacao/comunicar/index.php");
                        exit();
                    }
                } catch (PDOException $e) {
                    echo "Erro ao atualizar o status: " . $e->getMessage();
                }
                break;

            case "enviar":
                try {
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $com_normalizacao = "SELECT normalizacao, incidente_id FROM comunicacao as c LEFT JOIN comunicacao_templates as ct ON c.template_email = ct.id WHERE c.id = :idComunicacao";
                    $stmt_com_normalizacao = $pdo->prepare($com_normalizacao);
                    $stmt_com_normalizacao->bindParam(':idComunicacao', $idComunicacao, PDO::PARAM_INT);
                    $stmt_com_normalizacao->execute();
                    $resultado = $stmt_com_normalizacao->fetch(PDO::FETCH_ASSOC);
                    $normalizacao = $resultado['normalizacao'];
                    $incidente_id = $resultado['incidente_id'];

                    $sql = "UPDATE comunicacao SET msgEmail = :msgEmail, assuntoEmail = :assuntoEmail, status = 2 WHERE id = :idComunicacao";

                    $stmt = $pdo->prepare($sql);

                    $stmt->bindParam(':idComunicacao', $idComunicacao, PDO::PARAM_INT);
                    $stmt->bindParam(':msgEmail', $msgEmail, PDO::PARAM_STR);
                    $stmt->bindParam(':assuntoEmail', $assuntoEmail, PDO::PARAM_STR);


                    if ($stmt->execute()) {
                        if ($normalizacao == 1 && !empty($incidente_id)) {

                            $sql_update_incidentes = "UPDATE incidentes SET envio_com_normalizacao = 1 WHERE id = :incidente_id";
                            $stmt_update_incidentes = $pdo->prepare($sql_update_incidentes);
                            $stmt_update_incidentes->bindParam(':incidente_id', $incidente_id, PDO::PARAM_INT);
                            $stmt_update_incidentes->execute();
                        }
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
                        header("Location: /index.php");
                        exit();
                    }
                } catch (PDOException $e) {
                    echo "Erro ao atualizar o status: " . $e->getMessage();
                }
                break;

            default:
                break;
        }
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
