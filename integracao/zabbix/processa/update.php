<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../conexoes/conexao_pdo.php";

        $tokenAPI = $_POST["tokenAPI"];
        $statusIntegracao = $_POST["statusIntegracao"];
        $urlZabbix = $_POST["urlZabbix"];
        $idZabbix = $_POST['idZabbix'];
        $descricaoZabbix = $_POST['descricaoZabbix'];

        try {

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE integracao_zabbix SET descricao = :descricaoZabbix, tokenAPI = :tokenAPI, urlZabbix = :urlZabbix, statusIntegracao = :statusIntegracao WHERE id = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':descricaoZabbix', $descricaoZabbix);

            $stmt->bindParam(':tokenAPI', $tokenAPI);
            $stmt->bindParam(':statusIntegracao', $statusIntegracao);
            $stmt->bindParam(':urlZabbix', $urlZabbix);
            $stmt->bindParam(':id', $idZabbix);


            $stmt->execute();

            header("Location: /integracao/zabbix/index.php");
            exit();
        } catch (PDOException $e) {
            echo "Erro na atualização: " . $e->getMessage();
        }

        // Feche a conexão com o banco de dados
        $pdo = null;
    } else {
        // Se o formulário não foi enviado corretamente, redirecione de volta para a página do formulário
        header("Location: /integracao/zabbix/index.php");
        exit();
    }
} else {
    header("Location: /index.php");
    exit();
}
