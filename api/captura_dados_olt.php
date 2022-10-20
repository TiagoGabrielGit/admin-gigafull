<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$sql =
    "SELECT
    rno.id as idOLT,
    rno.olt_ipAddress as ipOLT,
    rno.olt_username as userOLT,
    rno.olt_password as passOLT
FROM
	redeneutra_olts as rno
WHERE
	rno.id = $id
";

/*$consulta = mysqli_query($mysqli, $sql);
if ($consulta) :
    while ($campo = mysqli_fetch_object($consulta)) :
        echo $campo->ipOLT;
        echo $campo->userOLT;
        echo $campo->passOLT;
    endwhile;

else :
    echo "Algo deu errado";
endif;*/
 
 
$consulta = mysqli_query($mysqli, $sql);

$result = mysqli_fetch_assoc($consulta);
echo json_encode($result);