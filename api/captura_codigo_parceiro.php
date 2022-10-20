<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$codigo_parceiro =
"SELECT
rnp.codigo as codigoParceiro
FROM
redeneutra_parceiro as rnp
WHERE
rnp.id = $id
";

$consulta = mysqli_query($mysqli, $codigo_parceiro);

$result = mysqli_fetch_assoc($consulta);
echo json_encode($result);
?> 