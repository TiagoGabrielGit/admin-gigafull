<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$sql = 
"SELECT
logradouros.id as id,
logradouros.cep as cep
FROM 
logradouros as logradouros  
WHERE
logradouros.deleted = 1
and
logradouros.id = $id  
";

$consulta = mysqli_query($mysqli, $sql);

if($consulta):
    
    while($campo = mysqli_fetch_object($consulta)):
        
       echo "<option value='$campo->id'> $campo->cep </option>";
    endwhile;

else: 
	echo "Algo deu errado";
endif;
?> 