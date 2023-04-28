<?php
require "../../../conexoes/conexao.php";

$idOLT = $_GET['idOLT'];
$slotOLT = $_GET['slotOLT'];
$ponOLT = $_GET['ponOLT'];
$idONU = $_GET['idONU'];

$captura_dados_olt =
    "SELECT 
rno.olt_ipAddress as ipOLT,
rno.olt_username as userOLT,
rno.olt_password as passOLT
FROM
redeneutra_olts as rno
WHERE
rno.id = $idOLT
";

$r_dados_olt = mysqli_query($mysqli, $captura_dados_olt);
$campos_dados_olt = $r_dados_olt->fetch_array();

$ipOLT = $campos_dados_olt['ipOLT'];
$userOLT = $campos_dados_olt['userOLT'];
$passOLT = $campos_dados_olt['passOLT'];

exec("bash ../../../bash/olt/huawei/diagONU.bash $ipOLT $userOLT $passOLT $slotOLT $ponOLT $idONU", $retorno1);

$array_result = [];
foreach ($retorno1 as $key => $value) {

    $pos1 = strpos($value, 'Run state');
    if ($pos1 !== false) {
        $array_result1[] = $key;
    }

    $pos2 = strpos($value, 'Description');
    if ($pos2 !== false) {
        $array_result2[] = $key;
    }

    $pos3 = strpos($value, 'Last down cause');
    if ($pos3 !== false) {
        $array_result3[] = $key;
    }

    $pos4 = strpos($value, 'Last down time');
    if ($pos4 !== false) {
        $array_result4[] = $key;
    }

    $pos5 = strpos($value, 'SN   ');
    if ($pos5 !== false) {
        $array_result5[] = $key;
    }

    $pos6 = strpos($value, 'Rx optical power(dBm)');
    if ($pos6 !== false) {
        $array_result6[] = $key;
    }

    $pos7 = strpos($value, 'OLT Rx ONT optical power(dBm)');
    if ($pos7 !== false) {
        $array_result7[] = $key;
    }

    $pos8 = strpos($value, 'Temperature(C)');
    if ($pos8 !== false) {
        $array_result8[] = $key;
    }
}

$linhaState = $array_result1[0];
$linhaState = $retorno1[$linhaState];
$posicaoState = strpos($linhaState, ':');
$estado = substr($linhaState, $posicaoState + 2);
//echo $estado;

$linhaDesc = $array_result2[0];
$linhaDesc = $retorno1[$linhaDesc];
$posicaoDesc = strpos($linhaDesc, ':');
$descricao = substr($linhaDesc, $posicaoDesc + 2);

$linhaLastDownCause = $array_result3[0];
$linhaLastDownCause = $retorno1[$linhaLastDownCause];
$posicaoLastDownCause = strpos($linhaLastDownCause, ':');
$lastDownCause = substr($linhaLastDownCause, $posicaoLastDownCause + 2);

$linhaLastDownTime = $array_result4[0];
$linhaLastDownTime = $retorno1[$linhaLastDownTime];
$posicaoLastDownTime = strpos($linhaLastDownTime, ':');
$lastDownTime = substr($linhaLastDownTime, $posicaoLastDownTime + 2);

$linhaSN = $array_result5[0];
$linhaSN = $retorno1[$linhaSN];
$posicaoSN = strpos($linhaSN, ':');
$SN = substr($linhaSN, $posicaoSN + 2);

$linhaSinal = $array_result6[0];
$linhaSinal = $retorno1[$linhaSinal];
$posicaoSinal = strpos($linhaSinal, ':');
$sinalONU = substr($linhaSinal, $posicaoSinal + 2);

$linhaSinalONU = $array_result6[0];
$linhaSinalONU = $retorno1[$linhaSinalONU];
$posicaoSinalONU = strpos($linhaSinalONU, ':');
$sinalONU = substr($linhaSinalONU, $posicaoSinalONU + 2);

$linhaSinalOLT = $array_result7[0];
$linhaSinalOLT = $retorno1[$linhaSinalOLT];
$posicaoSinalOLT = strpos($linhaSinalOLT, ':');
$sinalOLT = substr($linhaSinalOLT, $posicaoSinalOLT + 2);

$linhaTemperatura = $array_result8[0];
$linhaTemperatura = $retorno1[$linhaTemperatura];
$posicaoTemperatura = strpos($linhaTemperatura, ':');
$temperaturaONU = substr($linhaTemperatura, $posicaoTemperatura + 2);

echo '{"estado":"' . $estado . '","descricao":"' . $descricao . '","cause":"' . $lastDownCause . '","causeTime":"' . $lastDownTime . '","serial":"' . $SN . '","sinalONU":"' . $sinalONU . '","sinalOLT":"' . $sinalOLT . '","temperaturaONU":"' . $temperaturaONU . '"}';
