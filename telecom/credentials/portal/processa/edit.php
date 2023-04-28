<?php
session_start();
include_once '../../../conexoes/conexao_pdo.php';

//Variaveis 
$idCadastro = $_POST['id'];
$IDTipo = $_POST['IDTipo'];
$privacidade = $_POST['editPrivacidade'];
$descricao = $_POST['editDescricao'];
$usuario = $_POST['editUsuario'];
$senha = $_POST['editSenha'];



$cont_insert = false;

//tipo = email
if ($IDTipo == "email") {
    $webmail = $_POST['editWebmail'];
    $anotacaoEmail = $_POST['anotacaoEmail'];

    $sql = "UPDATE credenciais_email SET privacidade = :priv, webmail = :webmail, emaildescricao = :descr, emailusuario = :user, emailsenha = :senha, anotacao = :anotacao WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':priv', $privacidade);
    $stmt->bindParam(':webmail', $webmail);
    $stmt->bindParam(':descr', $descricao);
    $stmt->bindParam(':user', $usuario);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':id', $idCadastro);
    $stmt->bindParam(':anotacao', $anotacaoEmail);
    

    if ($stmt->execute()) {
        $cont_insert = true;
    } else {
        $cont_insert = false;
    }


    if ($cont_insert) {
        echo "<p style='color:green;'>Editado com Sucesso</p>";
    } else {
        echo "<p style='color:red;'>Erro ao editar</p>";
    }
}


//tipo = vm
if ($IDTipo == "vm") {

    $sql = "UPDATE credenciais_vms SET privacidade = :priv, vmdescricao = :descr, vmusuario = :user, vmsenha = :senha WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':priv', $privacidade);
    $stmt->bindParam(':descr', $descricao);
    $stmt->bindParam(':user', $usuario);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':id', $idCadastro);

    if ($stmt->execute()) {
        $cont_insert = true;
    } else {
        $cont_insert = false;
    }


    if ($cont_insert) {
        echo "<p style='color:green;'>Editado com Sucesso</p>";
    } else {
        echo "<p style='color:red;'>Erro ao editar</p>";
    }
}


//tipo = equipamento
if ($IDTipo == "equipamento") {

    $sql = "UPDATE credenciais_equipamento SET privacidade = :priv, equipamentodescricao = :descr, equipamentousuario = :user, equipamentosenha = :senha WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':priv', $privacidade);
    $stmt->bindParam(':descr', $descricao);
    $stmt->bindParam(':user', $usuario);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':id', $idCadastro);

    if ($stmt->execute()) {
        $cont_insert = true;
    } else {
        $cont_insert = false;
    }


    if ($cont_insert) {
        echo "<p style='color:green;'>Editado com Sucesso</p>";
    } else {
        echo "<p style='color:red;'>Erro ao editar</p>";
    }
}

//tipo = portal
if ($IDTipo == "portal") {



    $sql = "UPDATE credenciais_portal SET privacidade = :priv, paginaacesso = :pagina, portaldescricao = :descr, portalusuario = :user, portalsenha = :senha, anotacao = :anotacao WHERE id = :id";
    $pagina = $_POST['editPagina'];
    $anotacaoPortal = $_POST['anotacaoPortal'];

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':priv', $privacidade);
    $stmt->bindParam(':pagina', $pagina);
    $stmt->bindParam(':descr', $descricao);
    $stmt->bindParam(':user', $usuario);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':id', $idCadastro);
    $stmt->bindParam(':anotacao', $anotacaoPortal);
    

    if ($stmt->execute()) {
        $cont_insert = true;
    } else {
        $cont_insert = false;
    }

    if ($cont_insert) {
        echo "<p style='color:green;'>Editado com Sucesso</p>";
    } else {
        echo "<p style='color:red;'>Erro ao editar</p>";
    }
}
