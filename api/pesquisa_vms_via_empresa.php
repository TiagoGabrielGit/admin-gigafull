<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$sql_vm =
    "SELECT
    vm.id as id,
    vm.hostname as hostname
FROM 
    vms as vm
WHERE
    vm.empresa_id = $id
ORDER BY
vm.hostname ASC    
";

$consulta = mysqli_query($mysqli, $sql_vm);
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
