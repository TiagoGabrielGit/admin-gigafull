<?php
$ipOLT = $_GET['ipOLT'];
$userOLT = $_GET['userOLT'];
$passOLT = $_GET['passOLT'];

exec("bash /bash/provisiona.sh $ipOLT $userOLT $passOLT",$retorno);

for ($i = 0; $i < 20; $i++) {
    unset($retorno[$i]);
}

foreach($retorno as $key) {
    echo $key."<br>";
}

echo $retorno[43];