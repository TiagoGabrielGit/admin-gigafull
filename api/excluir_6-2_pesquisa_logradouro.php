<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$sql = 
"SELECT
logradouros.id as id,
logradouros.logradouro as logradouro
FROM 
logradouros as logradouros  
WHERE
logradouros.deleted = 1
and
logradouros.bairro = $id
ORDER BY
logradouros.logradouro ASC     
";

$consulta = mysqli_query($mysqli, $sql);
if($consulta):
    echo "<option value=''>Selecione</option>";
    while($campo = mysqli_fetch_object($consulta)):
        
       echo "<option value='$campo->id'> $campo->logradouro </option>";
    endwhile;

else: 
	echo "Algo deu errado";
endif;
?> 