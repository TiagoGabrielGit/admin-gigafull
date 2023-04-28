<?php
session_start();

include_once("../../../conexoes/conexao.php");

$inativa = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$inativa_usuario = "UPDATE `usuarios` SET `active`= '0' WHERE id = '$inativa' ";
$res_inativa_usuario = mysqli_query($mysqli, $inativa_usuario);


if (mysqli_affected_rows($mysqli)) {
	header("Location: /gerenciamento/usuarios/usuarios.php");
	$_SESSION['msg'] =
	'<div class="alert alert-success alert-dismissible fade show" role="alert">
		<strong>Registro excluído com sucesso!</strong>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		<script>
			setTimeout(function(){
				$(".alert").addClass("hide");
				$(".alert").removeClass("show");
				},3000);
		</script>
	</div>';
}
else{
	header("Location:/gerenciamento/usuarios/usuarios.php");
	$_SESSION['msg'] = 
	'<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<strong>Erro ao excluir</strong>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		<script>
			setTimeout(function(){
				$(".alert").addClass("hide");
				$(".alert").removeClass("show");
				},3000);
		</script>
	</div>';
}

?>