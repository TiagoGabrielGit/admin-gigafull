<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../../../conexoes/conexao_pdo.php";

    $idCadastro = $_POST['idUC'];

    $dados = [
        'idCadastro' => $idCadastro,
    ];

    $sql_delete = "DELETE FROM usuario_competencia WHERE id = :idCadastro";

    $stmt = $pdo->prepare($sql_delete);
    $stmt->execute($dados);
}
