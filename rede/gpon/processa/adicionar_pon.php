<?php
session_start();
if (isset($_SESSION['id'])) {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require "../../../conexoes/conexao_pdo.php";

        try {
            $oltId = $_POST['olt'];

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $pdo->beginTransaction();

            $sql = "INSERT INTO gpon_pon (olt_id, slot, pon, cod_int, active) VALUES (:oltId, :slot, :pon, :cod_int, '1')";
            $stmt = $pdo->prepare($sql);

            $insercoesBemSucedidas = true; // Flag para controlar se todas as inserções foram bem-sucedidas

            for ($i = 0; $i < count($_POST['slot']); $i++) {
                $slot = $_POST['slot'][$i];
                $pon = $_POST['pon'][$i];
                $codigo = $_POST['codigo'][$i]; // Use o valor de código correto aqui

                // Verifique se já existe um registro com os mesmos valores
                $checkSql = "SELECT COUNT(*) FROM gpon_pon WHERE olt_id = :oltId AND slot = :slot AND pon = :pon";
                $checkStmt = $pdo->prepare($checkSql);
                $checkStmt->execute([
                    ':oltId' => $oltId,
                    ':slot' => $slot,
                    ':pon' => $pon,
                ]);

                $rowCount = $checkStmt->fetchColumn();

                if ($rowCount == 0) {
                    $stmt->execute([
                        ':oltId' => $oltId,
                        ':slot' => $slot,
                        ':pon' => $pon,
                        ':cod_int' => $codigo, // Use o valor de código correto aqui
                    ]);
                } else {
                    $insercoesBemSucedidas = false; // Defina a flag como false se uma inserção não for bem-sucedida
                }
            }

            if ($insercoesBemSucedidas) {
                $pdo->commit();
                header('Location: /rede/gpon/pons.php?olt_id=' . $oltId);
            } else {
                $pdo->rollBack();
                header('Location: /rede/gpon/pons.php?olt_id=' . $oltId . '&error=cadastro_ja_existe');
            }
        } catch (PDOException $e) {
            //echo "Erro: " . $e->getMessage();
            header('Location: /rede/gpon/pons.php?olt_id=' . $oltId . '&error=cadastro_ja_existe');
        }
    }
} else {
    header("Location: /index.php");
    exit();
}
