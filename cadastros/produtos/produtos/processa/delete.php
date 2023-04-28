<?php
session_start();

include_once("../../../../conexoes/conexao.php");

$delete_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$delete_data = "UPDATE `equipamentos` SET `deleted`= '2' WHERE id = '$delete_id' ";

$res_delete = mysqli_query($mysqli, $delete_data);

if (mysqli_affected_rows($mysqli)) {
	header("Location: /cadastros/produtos/produtos/index.php");
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
	header("Location: /cadastros/produtos/produtos/index.php");
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