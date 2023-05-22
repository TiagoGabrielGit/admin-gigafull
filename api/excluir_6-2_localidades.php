<?php
require $_SERVER['DOCUMENT_ROOT'] . "/conexoes/conexao.php";

$type = isset($_GET['type']) ? $_GET['type'] : '';
$id   = isset($_GET['id']) ? $_GET['id'] : '';

if ($type != '' && $id != '') {

    if ($type == 'estado') {
        // pesquisa estado passando ID do pais
        $sql = "SELECT estado, id FROM estado WHERE pais = $id ";
        $resultado = mysqli_query($mysqli, $sql);
        $resp = array();
        while ($e = $resultado->fetch_assoc()) :
            array_push($resp, ['id' => $e['id'], 'estado' => $e['estado']]);
        endwhile;

        echo json_encode($resp);
    } else {
        if ($type == 'cidade') {
            // pesquisa cidade passando ID do estado
            $sql = "SELECT id, cidade FROM cidades WHERE estado = $id ";
            $resultado = mysqli_query($mysqli, $sql);
            $resp = array();
            while ($c = $resultado->fetch_assoc()) :
                array_push($resp, ['id' => $c['id'], 'estado' => $c['cidade']]);
            endwhile;

            echo json_encode($resp);
        } else {
            //proxima API
        }
    }
} else {
    echo "erro";
}
