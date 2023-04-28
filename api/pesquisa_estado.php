<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$sql_estado = 
"SELECT
    estado.id,
    estado.estado
FROM 
    estado as estado  
WHERE
    estado.deleted = 1
    and
    estado.pais = $id
ORDER BY
    estado.estado ASC    
";

$consulta = mysqli_query($mysqli, $sql_estado);
if($consulta):
    echo "<option value=''>Selecione</option>";
    while($estado = mysqli_fetch_object($consulta)):
        
       echo "<option value='$estado->id'> $estado->estado </option>";
    endwhile;

else: 
	echo "Algo deu errado";
endif;
?> 