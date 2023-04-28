<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$id = $_GET["id"];

$sql_lista_tipos =
"SELECT
te.id as id,
te.tipo as tipo
FROM
equipamentos_atributos as ea
LEFT JOIN
tipoequipamento as te
ON
te.id = ea.tipoequipamento_id
WHERE
ea.equipamento_id = $id
and
ea.active = 1
ORDER BY
te.tipo ASC
";

$consulta = mysqli_query($mysqli, $sql_lista_tipos);
if ($consulta) :
    echo "<option value=''>Selecione</option>";
    while ($resp = mysqli_fetch_object($consulta)) :

        echo "<option value='$resp->id'> $resp->tipo </option>";
    endwhile;

else :
    echo "Algo deu errado";
endif;
