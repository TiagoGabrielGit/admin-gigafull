<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$sql_equipamentos = 
"SELECT
    eqp.id as id,
    eqp.equipamento as equipamento
FROM 
    equipamentos as eqp  
WHERE
    eqp.deleted = 1
    and
    eqp.fabricante = $id
ORDER BY
    eqp.equipamento ASC    
";

$consulta = mysqli_query($mysqli, $sql_equipamentos);
if($consulta):
    echo "<option value=''>Selecione</option>";
    while($resp = mysqli_fetch_object($consulta)):
        
       echo "<option value='$resp->id'> $resp->equipamento </option>";
    endwhile;

else: 
	echo "Algo deu errado";
endif;
