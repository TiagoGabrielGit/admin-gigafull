<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$sql_bairros = 
"SELECT
    bairro.id,
    bairro.bairro
FROM 
    bairros as bairro  
WHERE
    bairro.deleted = 1
    and
    bairro.cidade = $id
ORDER BY
    bairro.bairro ASC    
";

$consulta = mysqli_query($mysqli, $sql_bairros);
if($consulta):
    echo "<option value=''>Selecione</option>";
    while($bairro = mysqli_fetch_object($consulta)):
        
       echo "<option value='$bairro->id'> $bairro->bairro </option>";
    endwhile;

else: 
	echo "Algo deu errado";
endif;
?> 