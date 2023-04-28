<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$sql = 
"SELECT
pess.id as pessoa_id,
pess.email as pessoa_email
FROM
pessoas as pess
WHERE
pess.id = '$id'
";

$consulta = mysqli_query($mysqli, $sql);

if($consulta):
    
    while($campo = mysqli_fetch_object($consulta)): 
        echo "$campo->pessoa_email";
    endwhile;

else: 
	echo "Algo deu errado";
endif;
?> 