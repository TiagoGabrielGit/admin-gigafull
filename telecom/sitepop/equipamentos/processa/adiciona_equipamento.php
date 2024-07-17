<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

if (isset($_SESSION['id'])) {
    $cadastroEmpresa = $_POST['EquipamentocadastroEmpresa'];
    $cadastroPop = $_POST['EquipamentoCadastroPop'];
    $cadastroEquipamento = $_POST['EquipamentocadastroEquipamento'];
    $cadastroTipoEquipamento = $_POST['EquipamentoCadastroTipoEquipamento'];
    $hostname = $_POST['EquipamentoCadastrohostname'];
    $ipaddress = $_POST['EquipamentoCadastroIPAddress'];
    $statusEquipamento = $_POST['EquipamentoCadastroStatus'];
    $privacidade = "2";
    $idUsuario = $_SESSION['id'];

    $serialEquipamento = empty($_POST['EquipamentoCadastroSerial']) ? "" : $_POST['EquipamentoCadastroSerial'];

    try {
        $pdo->beginTransaction();

        $sql = "INSERT INTO equipamentospop (privacidade, usuario_criador, empresa_id, pop_id, equipamento_id, tipoEquipamento_id, hostname, ipaddress, statusEquipamento, deleted, serialEquipamento, criado)
                VALUES (:privacidade, :usuario_criador, :empresa_id, :pop_id, :equipamento_id, :tipoEquipamento_id, :hostname, :ipaddress, :statusEquipamento, '1', :serialEquipamento, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':privacidade', $privacidade);
        $stmt->bindParam(':usuario_criador', $idUsuario);
        $stmt->bindParam(':empresa_id', $cadastroEmpresa);
        $stmt->bindParam(':pop_id', $cadastroPop);
        $stmt->bindParam(':equipamento_id', $cadastroEquipamento);
        $stmt->bindParam(':tipoEquipamento_id', $cadastroTipoEquipamento);
        $stmt->bindParam(':hostname', $hostname);
        $stmt->bindParam(':ipaddress', $ipaddress);
        $stmt->bindParam(':statusEquipamento', $statusEquipamento);
        $stmt->bindParam(':serialEquipamento', $serialEquipamento);

        $stmt->execute();

        $id_equipamento = $pdo->lastInsertId();

        if ($stmt->rowCount() > 0) {
            $pdo->commit();
            header("Location: /telecom/sitepop/equipamentos/view.php?id=$id_equipamento");
            exit();
        } else {
            $pdo->rollBack();
            header("Location: /telecom/sitepop/equipamentos/view.php?id=$id_equipamento");
            exit();        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Erro: " . $e->getMessage();
    }
} else {
    header("Location: /index.php");
    exit();
}
