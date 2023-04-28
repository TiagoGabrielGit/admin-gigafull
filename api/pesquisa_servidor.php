<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$sql_servidor =
    "SELECT
    eqpop.id,
    eqpop.hostname
FROM 
    equipamentospop as eqpop
WHERE
    eqpop.pop_id = $id
    and
    eqpop.tipoEquipamento_id = 4
    and
    statusEquipamento = 'Ativado'
ORDER BY
    eqpop.hostname ASC    
";

$consulta = mysqli_query($mysqli, $sql_servidor);
if ($consulta) :
    echo "<option value=''>Selecione</option>";
    while ($resp = mysqli_fetch_object($consulta)) :

        echo "<option value='$resp->id'> $resp->hostname </option>";
    endwhile;

else :
    echo "Algo deu errado";
endif;
