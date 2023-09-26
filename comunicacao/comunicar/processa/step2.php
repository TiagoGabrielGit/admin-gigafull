<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../conexoes/conexao_pdo.php";
    $idComunicacao = $_POST['idComunicacao'];
    $templateEmail = $_POST['templateEmail'];

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

                    $sql = "UPDATE comunicacao SET step = 1 WHERE id = :idComunicacao";

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

            case "avancar":
                try {
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $sql = "UPDATE comunicacao SET template_email = :template_email, step = 3 WHERE id = :idComunicacao";

                    $stmt = $pdo->prepare($sql);

                    $stmt->bindParam(':idComunicacao', $idComunicacao, PDO::PARAM_INT);
                    $stmt->bindParam(':template_email', $templateEmail, PDO::PARAM_INT);



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
