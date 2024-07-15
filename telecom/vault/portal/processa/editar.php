<?php
session_start();

if (isset($_SESSION['id'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        require($_SERVER['DOCUMENT_ROOT'] . '/conexoes/conexao_pdo.php');

        //Variaveis 
        $idCadastro = $_POST['id'];
        $IDTipo = $_POST['IDTipo'];
        $privacidade = $_POST['editPrivacidade'];
        $descricao = $_POST['editDescricao'];
        $usuario = $_POST['editUsuario'];
        $senha = $_POST['editSenha'];

        $cont_insert = false;

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
            header("Location: /telecom/vault/portal/view.php?id=$idCadastro");
            exit();
        } else {
            header("Location: /telecom/vault/portal/view.php?id=$idCadastro");
            exit();
        }
    }
}
