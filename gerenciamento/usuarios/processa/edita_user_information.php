<?php
require "../../../conexoes/conexao_pdo.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $active = $_POST['situacao'];
    $perfil = $_POST['perfil'];
    $empresaID = $_POST['empresaSelect'];
    $dashboard = $_POST['usuarioDashboard'];
    $mobile = $_POST['mobile'];
    $control = $_POST['control'];


    $sql = "UPDATE usuarios SET 
    empresa_id = :empresaID,
    mobile = :mobile,
    control = :control,

    perfil_id = :perfil,
    active = :active,
    dashboard = :dashboard,
    modificado = NOW()
WHERE id = :id";

    // Preparar a consulta
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':mobile', $mobile);
    $stmt->bindValue(':control', $control);

    $stmt->bindValue(':empresaID', $empresaID);
    $stmt->bindValue(':perfil', $perfil);
    $stmt->bindValue(':active', $active);
    $stmt->bindValue(':dashboard', $dashboard);
    $stmt->bindValue(':id', $id);

    // Executar a consulta
    if ($stmt->execute()) {
        header("Location: /gerenciamento/usuarios/view.php?id=$id");
        exit;
    } else {
        header("Location: /gerenciamento/usuarios/view.php?id=$id");
        exit;
    }
}
