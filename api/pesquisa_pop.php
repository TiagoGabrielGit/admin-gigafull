<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$sql_pop = "SELECT id, pop FROM pop WHERE active = 1 AND empresa_id = $id ORDER BY pop ASC";

$consulta = mysqli_query($mysqli, $sql_pop);
if ($consulta) {
    $options = "";
    while ($resp = mysqli_fetch_object($consulta)) {
        $options .= "<option value='$resp->id'> $resp->pop </option>";
    }
    if (!empty($options)) {
        echo "<option value=''>Selecione</option>" . $options;
    } else {
        echo "<option value=''>Nenhum POP encontrado</option>";
    }
} else {
    echo "<option value=''>Erro na consulta do banco de dados</option>";
}
?>
