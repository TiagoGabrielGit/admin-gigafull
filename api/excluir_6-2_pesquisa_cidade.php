<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$sql_cidade =
    "SELECT
    cidade.id,
    cidade.cidade
FROM 
    cidades as cidade  
WHERE
    cidade.deleted = 1
    and
    cidade.estado = $id
ORDER BY
    cidade.cidade ASC    
";

$consulta = mysqli_query($mysqli, $sql_cidade);
if ($consulta) :
    echo "<option value=''>Selecione</option>";
    while ($cidade = mysqli_fetch_object($consulta)) :
        
        echo "<option value='$cidade->id'> $cidade->cidade </option>";
    endwhile;

else :
    echo "Algo deu errado";
endif;
