<?php
session_start();

if ($_SESSION['id']) {
    require "../../../../conexoes/conexao_pdo.php";


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $descricao = $_POST["descricao"];
        $inicio = $_POST["inicio"];
        $tipo = $_POST["tipo"];
        $autor_id = $_SESSION['id'];
        $classificacao = "0";
        $active = "1";


        if ($tipo == 100) {
            $hostID = $_POST["olt"];
            $pon_id = $_POST["pons"];
        } else if ($tipo == 102) {
            $hostID = $_POST["rotasFibras"];
            $pon_id = "";
        } else {
            $hostID = "";
            $pon_id = "";
        }

        $query = "INSERT INTO incidentes (descricaoIncidente, inicioIncidente, incident_type, autor_id, equipamento_id, classificacao, active, pon_id) VALUES (:descricao, :inicio, :tipo, :autor_id, :equipamento_id, :classificacao, :active, :pon_id)";

        try {
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stmt->bindParam(':inicio', $inicio, PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $tipo, PDO::PARAM_INT);
            $stmt->bindParam(':autor_id', $autor_id, PDO::PARAM_INT);
            $stmt->bindParam(':equipamento_id', $hostID, PDO::PARAM_INT);
            $stmt->bindParam(':classificacao', $classificacao, PDO::PARAM_INT);
            $stmt->bindParam(':pon_id', $pon_id, PDO::PARAM_INT);
            $stmt->bindParam(':active', $active, PDO::PARAM_INT);


            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $incidente_id = $pdo->lastInsertId();
                header("Location: /servicedesk/incidentes/view.php?id=$incidente_id");
                exit();
            } else {
                echo "Falha ao criar o incidente.";
            }
        } catch (PDOException $e) {
            echo "Erro na inserção do incidente: " . $e->getMessage();
        }
    } else {
        header("Location: sua_pagina_de_erro.php");
        exit();
    }
}
