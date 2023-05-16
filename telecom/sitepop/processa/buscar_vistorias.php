<?php
require "../../../conexoes/conexao.php";
require "../../../conexoes/conexao_pdo.php";

// Obtém a data selecionada enviada pela requisição POST
$idVistoria = $_POST['data'];

$sql_vistoria_equipamentos =
    "SELECT
ve.id as vistoriaEquipamentoId,
ve.equipamento_id as equipamentoId,
eqpop.hostname as equipamento
FROM
vistoria_equipamento as ve
LEFT JOIN
equipamentospop as eqpop
ON
eqpop.id = ve.equipamento_id
WHERE
ve.vistoria_id = $idVistoria
";
$r_vistoria_equipamentos = mysqli_query($mysqli, $sql_vistoria_equipamentos);
if ($r_vistoria_equipamentos) :
    echo "<option value=''>Selecione</option>";
    while ($c_vistoria_equipamentos = mysqli_fetch_object($r_vistoria_equipamentos)) :
        echo "<option value='$c_vistoria_equipamentos->vistoriaEquipamentoId'> $c_vistoria_equipamentos->equipamento </option>";
    endwhile;

else :
    echo "Algo deu errado";
endif;
