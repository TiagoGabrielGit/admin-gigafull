<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$sql = 
"SELECT
rack.id as id,
rack.nomenclatura as nomenclatura
FROM 
pop_rack as rack
WHERE
rack.pop_id = $id  
";

$consulta = mysqli_query($mysqli, $sql);

if($consulta):
    
    while($campo = mysqli_fetch_object($consulta)):
        
       echo "<option value='$campo->id'> $campo->nomenclatura </option>";
    endwhile;

else: 
	echo "Algo deu errado";
endif;
?> 