<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require "../../../../conexoes/conexao_pdo.php";
        // Verifica se o campo ve_tipoID está definido
        if (isset($_POST["ve_tipoID"]) && isset($_POST["vincularEmpresa"])) {
            // Obtém o ID do tipo e a empresa selecionada a partir do formulário
            $ve_tipoID = $_POST["ve_tipoID"];
            $empresaID = $_POST["vincularEmpresa"];


            $inserir_assoc = "INSERT INTO incidentes_types_empresa (empresa_id, incidente_type_id) VALUES (:empresa_id, :tipo_id)";
            $stmt_inserir = $pdo->prepare($inserir_assoc);
            $stmt_inserir->bindParam(':empresa_id', $empresaID);
            $stmt_inserir->bindParam(':tipo_id', $ve_tipoID);
            $stmt_inserir->execute();
        }
    }

    // Redireciona de volta para a página anterior após o processamento
    header("Location: /servicedesk/incidentes/configuracoes/index.php");
    exit();
} else {
    header("Location: /index.php");
}
