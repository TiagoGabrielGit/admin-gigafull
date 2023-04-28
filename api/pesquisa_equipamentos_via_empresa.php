<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$sql_equipamentos =
    "SELECT
    eqpop.id as id,
    eqpop.hostname as hostname
FROM 
    equipamentospop as eqpop
WHERE
    eqpop.deleted = 1
    and
    eqpop.empresa_id = $id
ORDER BY
    eqpop.hostname ASC    
";

$consulta = mysqli_query($mysqli, $sql_equipamentos);
if ($consulta) :

?>

<?php
    echo "<option value=''>Selecione</option>";

    while ($resp = mysqli_fetch_object($consulta)) :

        echo "<option value='$resp->id'> $resp->hostname </option>";
    endwhile;

else :
    echo "Algo deu errado";
endif;
?>
