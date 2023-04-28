<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$sql_pop = 
"SELECT
    pop.id,
    pop.pop
FROM 
    pop as pop
WHERE
    pop.active = 1
    and
    pop.empresa_id = $id
ORDER BY
pop.pop ASC    
";

$consulta = mysqli_query($mysqli, $sql_pop);
if($consulta):
    echo "<option value=''>Selecione</option>";
    while($resp = mysqli_fetch_object($consulta)):
        
       echo "<option value='$resp->id'> $resp->pop </option>";
    endwhile;

else: 
	echo "Algo deu errado";
endif;
